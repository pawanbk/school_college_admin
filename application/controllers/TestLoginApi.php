<?php defined('BASEPATH') OR exit('No direct script access allowed');


class TestLoginApi extends MX_Controller {

	/**
	 * [_authToken description]
	 *
	 * contains Auth Token 
	 * Issued for different Channel
	 */
	private $_authToken = array(
		'4WVgVJsMsQty5GKBqXitQAEHIp2CAetF' => 'SMS',
		'ZXgF1iHVOorYwh3qXIWEb63DWsfPsvS8' => 'WEB',
		'weY99lHZs4kWZDi7LaPPK7csymIHuow9' => 'APP',
	);

	public function doLogin(){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$token = $_POST['token'];

		if ($username == 'suman' && $password == 'suman' && $token == 'JowbRycEEhw0Rip8DjLj') {
			$output = array(
				'response' => True,
				'msg' => "Login is successful",
				'result' => "",
				'metadata' => array(
					'auth_token' => '12345'
				)
			);

			print(json_encode($output));
			exit();
		}
	}

	/**
	 * [api description]
	 *
	 * Function exposed to external 
	 * calls private function based on "action" passed to it
	 */
	public function api(){
		$result = array(
			'result' => '',
			'response' => FALSE,
			'msg' => 'Invalid Operation !!',
		);

		try {
			$json = file_get_contents("php://input");
			$data = json_decode($json);

			if(empty($data) || NULL== $data){
				if('POST'==strtoupper($_SERVER['REQUEST_METHOD'])){
				
					if(array_key_exists('action', $_POST)){
						$action = $_POST['action'];
						unset($_POST['action']);

						$data = $_POST;
						$data['files'] = $_FILES;
						$return = $this->_run($action, $data);
						$result = array(
							'result' => $return['data'],
							'response' => TRUE,
							'msg' => isset($return['msg']) ? $return['msg'] : '',
						);
					}
					else{
						throw new Exception('Not A Valid Post Request !!');
					}
				}
				elseif('GET'==strtoupper($_SERVER['REQUEST_METHOD'])) {
					if(array_key_exists('action', $_GET)){
						$action = $_GET['action'];
						unset($_GET['action']);

						$data = $_GET;
						$return = $this->_run($action, $data);
						$result = array(
							'result' => $return['data'],
							'response' => TRUE,
							'msg' => isset($return['msg']) ? $return['msg'] : '',
						);
					}
					else{
						throw new Exception('Not A Valid Get Request !!');
					}
				}
				else{
					throw new Exception('Not A Valid Request !!');
				}
			}
			elseif (is_array($data)) {
				$result = array();
				foreach ($data as $row) {
					$row = json_decode(json_encode($row), true);
					$action = $row['action'];
					unset($row['action']);
					$return = $this->_run($action, $row);
					$result[$action] = array(
						'result' => $return['data'],
						'response' => TRUE,
						'msg' => isset($return['msg']) ? $return['msg'] : '',
					);
				}
			}
			else{
				$data = json_decode(json_encode($data), true);
				$action = $data['action'];
				unset($data['action']);
				$return = $this->_run($action, $data);
				$result = array(
					'result' => $return['data'],
					'response' => TRUE,
					'msg' => isset($return['msg']) ? $return['msg'] : '',
				);
			}
		} 
		catch (Exception $e) {
			$result = array(
				'result' => '',
				'response' => FALSE,
				'msg' => $e->getMessage(),
			);
		}	
		finally{
			$output = $result;
			print(json_encode($output));
			exit();
		}
	}

	/**
	 * [_run description]
	 *
	 * @param string $action
	 * @param array $data
	 *
	 * @return array $result : data, msg
	 */
	private function _run($action, $data){
		$action = "_".$action;

		$TicketingApi = new TicketingApi();
		
		if(! method_exists($TicketingApi, $action)) {
			throw new Exception('Incorrect Action !!');
		}

		if((!isset($data['authToken'])) || (empty($data['authToken'])) || (!array_key_exists($data['authToken'], $this->_authToken))){
			throw new Exception('Unauthorized Request !!');
		}
	
		$result = $this->$action($data);
	
		return $result;
	}

	/**
	 * [_createTicket description]
	 *
	 * @param array $data : username, contact_no, subject, message, ticket_problem_type_id, ticket_problem_id
	 *
	 * @return array $result : data, msg
	 */
	private function _createTicket($data){
		$status = TRUE;
		$returnMsg = '';
		$createdBy = '1';
		$createdDate =  date('Y-m-d H:i:s');

		$customerUsername = $data['username'];
		/*Load database radiusdb*/
		$CustomerinfoDB = $this->load->database('radiusdb', true);
		/*Query to fetch Customer Details by Username*/
		$customerDtl = $CustomerinfoDB->select('id,zip as customer_id,username, branch')->from('userinfo')->where(array('username'=>$customerUsername))->get()->row_array();

		$requestType = $this->_authToken[$data['authToken']];

		$ticketConfigObj = $this->db->query("select title, value from ct_ticket_configuration where title in ('defaultSmsQueueId', 'defaultWebQueueId', 'defaultAppQueueId', 'defaultPrefixTicketNo')");
		$ticketConfigArray = array();

		while($row = mysqli_fetch_assoc($ticketConfigObj->result_id)){
			$ticketConfigArray[$row['title']] = $row['value'];
		}

		switch ($requestType) {
			case 'SMS':
			$ticketChannel = 'sms';
			$communicationTypeId = 7;
			$defaultQueueId = $ticketConfigArray['defaultSmsQueueId'];
			break;
			case 'WEB':
			$ticketChannel = 'web';
			$communicationTypeId = 8;
			$defaultQueueId = $ticketConfigArray['defaultWebQueueId'];
			break;
			case 'APP':
			$ticketChannel = 'app';
			$communicationTypeId = 12;
			$defaultQueueId = $ticketConfigArray['defaultAppQueueId'];
			break;
		}

		/*If no username found in userinfo table*/
		if(empty($customerDtl)){
			$status = FALSE;
			if('sms' == $ticketChannel){
				$returnMsg = "Invalid Username !!\nThank You - ClassicTech"; 
			}
			else{
				$returnMsg = "No Username Found !!";
			}
		}
		else{

			/*starting transaction*/
			$this->db->trans_start();
			
			/*generating the Ticket No*/
			$ticketNo = $this->db->query("select nextvalue('ticket_no') as ticket_no")->row_array();

			$dataTicketInsert = array(
				'ticket_no' => $ticketNo['ticket_no'],
				'user_id' => $customerDtl['id'],
				'customer_id' => $customerDtl['customer_id'],
				'username' => $customerDtl['username'],
				'queue_id' => $defaultQueueId,
				'user_branch' => $customerDtl['branch'],
				'priority_id' => 3,
				'state_id' => 1,
				'ticket_channel' => $ticketChannel,
				'message' => $data['subject'],
				'ticket_type' => 'external',
				'created_by' => $createdBy,
				'created_date' => $createdDate,
			);

			if('sms' == $ticketChannel){
				$dataTicketInsert['alternate_contact_number'] = $data['contact_no'];
			}
			else{
				$dataTicketInsert['ticket_problem'] = base64_decode(urldecode($data['ticket_problem_type_id']));
				$dataTicketInsert['ticket_sub_problem'] = base64_decode(urldecode($data['ticket_problem_id']));
			}

			$this->db->insert('ct_tickets', $dataTicketInsert);	
			$ticketId = $this->db->insert_id();

			$dataHistory = array(
				'ticket_id' => $ticketId,
				'queue_id' => $dataTicketInsert['queue_id'],
				'priority_id' => $dataTicketInsert['priority_id'],
				'state_id' => $dataTicketInsert['state_id'],
				'user_branch' => $dataTicketInsert['user_branch'],
				'ticket_action_id' => 6,
				'changed_by' => $createdBy,
				'created_on' => $createdDate,
			); 
			$this->db->insert('ct_tickets_history', $dataHistory);	
			$historyId = $this->db->insert_id();	

			$dataCommunicationLogInsert = array(
				'ticket_id' => $ticketId,
				'communication_type_id' => $communicationTypeId,
				'ticket_history_id' => $historyId,
				'sender_type_id' => 1,
				'subject' => $data['subject'],
				'message' => $data['message'],
				'message_html' => $data['message'],
				'created_by' => $createdBy,
				'created_date' => $createdDate,
			);

			if('sms' == $ticketChannel){
				$dataCommunicationLogInsert['from_name'] = $data['contact_no'];
			}
			$this->db->insert('ct_tickets_communication_log', $dataCommunicationLogInsert);	

			/*completing transaction*/ 
			$this->db->trans_complete();

			/*checking transaction status*/
			if($this->db->trans_status() === FALSE){
				$status = FALSE;
				if('sms' == $ticketChannel){
					$returnMsg = "Sorry !! Failed To Register Your Request.\nThank You - ClassicTech"; 
				}
				else{
					$returnMsg = "Sorry !! Failed To Register Your Request. Please Try Again Later.";
				}
			}

			/*If transaction successfull*/
			$returnMsg = "Your Request has been Registered Successfully.\nTicket No: ".$ticketConfigArray['defaultPrefixTicketNo'].$ticketNo['ticket_no']."\nThank You - ClassicTech"; 
			// if('sms' == $ticketChannel){
			// }
			// else{
			// 	$returnMsg = "Your Request has been Registered Successfully.\nTicket No: ".$ticketConfigArray['defaultPrefixTicketNo'].$ticketNo['ticket_no']."\nThank You - ClassicTech"; 
			// }
		}

		/*If status is false then raise an Exception with custom message*/
		if(! $status){
			throw new Exception($returnMsg);
		}
		
		$result['data']['ticket_no'] = $ticketConfigArray['defaultPrefixTicketNo'].$ticketNo['ticket_no'];
		$result['data']['ticket_id'] = $ticketId;
		$result['msg'] = $returnMsg;

		return $result;	
	}

	/**
	 * [_getProblemCatWithProblem description]
	 *
	 *
	 * @return array $result : data
	 */
	private function _getProblemCatWithProblem(){
		$problemTypeObj = $this->db->select("a.problem_type_id, a.problem_type_title")
		->from('ct_tickets_problem_type a')
		->where(array('a.is_deleted_flag'=>'n', 'a.visibility_type'=>'external'))
		->order_by('a.problem_type_id')
		->get();
		$problemTypeArray = array();

		/*fetching from mysqli_result object and encrypting id*/
		while($row = mysqli_fetch_assoc($problemTypeObj->result_id)) {
			$row ['enc_problem_type_id'] = urlencode(base64_encode($row['problem_type_id']));
			$problemTypeArray[$row['problem_type_id']] = $row;
		}

		$problemObj = $this->db->select("a.problem_id,a.problem_title, a.problem_type_id")
		->from('ct_tickets_problem a')
		->where(array('a.is_deleted_flag'=>'n', 'a.visibility_type'=>'external'))
		->order_by('a.problem_id')
		->get();

		/*fetching from mysqli_result object and encrypting id*/
		while($row = mysqli_fetch_assoc($problemObj->result_id)) {
			$row ['enc_problem_id'] = urlencode(base64_encode($row['problem_id']));
			$problemTypeArray[$row['problem_type_id']]['child'][$row['problem_id']] = $row;
		}

		$result['data'] = $problemTypeArray;
		return $result;
	}

	/**
	 * [_createTicket description]
	 *
	 * @param array $data : username
	 *
	 * @return array $result : data
	 */
	private function _getAllTickets($data){
		$customerUsername = $data['username'];
		/*Load database radiusdb*/
		$CustomerinfoDB = $this->load->database('radiusdb', true);
		/*Query to fetch Customer Details by Username*/
		$customerDtl = $CustomerinfoDB->select('id, branch')->from('userinfo')->where(array('username'=>$customerUsername))->get()->row_array();

		if(empty($customerDtl)){
			throw new Exception("No Username Found !!");
		}
		$ticketConfigArray = $this->db->query("select title, value from ct_ticket_configuration where title='defaultPrefixTicketNo'")->row_array();
		
		$sql = "Select tkt.ticket_id, tkt.ticket_no, tkt.state_id, 
		tkt.message as subject, tkt.created_date, state.state_name, log.message 
		from ct_tickets tkt
		inner join ct_tickets_state state on state.state_id=tkt.state_id
		LEFT JOIN ct_tickets_communication_log log on log.ticket_id=tkt.ticket_id
		INNER JOIN ct_tickets_history history on history.id=log.ticket_history_id and history.ticket_action_id=6 
		where tkt.user_id='".$customerDtl['id']."'";

		$ticketListObj = $this->db->query($sql);
		$ticketListArray = array();

		/*fetching from mysqli_result object and encrypting id*/
		while($row = mysqli_fetch_assoc($ticketListObj->result_id)) {
			$row ['enc_ticket_id'] = urlencode(base64_encode($row['ticket_id']));
			$row ['prefixed_ticket_no'] = $ticketConfigArray['value'].$row['ticket_no'];
			$ticketListArray[$row['ticket_id']] = $row;
		}

		$result['data'] = $ticketListArray;
		return $result;
	}

}