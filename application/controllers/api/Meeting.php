<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH .'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Meeting extends REST_Controller{

  function __construct(){
    parent::__construct();

    $this->load->database();

    $this->methods['users_1get']['limit'] = 500; 
    $this->methods['users_post']['limit'] = 100; 
    $this->methods['users_delete']['limit'] = 50;
  }

  public function userLogin_post() {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->response([
        'success' => false,
        'status_code' => 403,
        'message' => 'Login error',
        'data'=> preg_replace('/\s+/', ' ', trim(strip_tags(validation_errors())))
      ], 403);
    } 
    else {

      $username = $this->input->post('username');
      $password = $this->input->post('password');

      $checkUsername = $this->db->select('user_name, emp_id')
      ->where('is_active', 'y')
      ->where('lock_flag', 'false')
      ->where('user_name', $username)
      ->get('staffs')->row_array();

      if (!empty($checkUsername)) {
        $checkPassword = $this->db->select('emp_id, user_name, role_id')
        ->where('is_active', 'y')
        ->where('lock_flag', 'false')
        ->where('user_name', $username)
        ->where('pass_word', md5($password))
        ->get('staffs')->row_array();

        if (!empty($checkPassword)) {
          $empId = $checkPassword['emp_id'];

          $sql = "SELECT branch.branch_name, emp.curr_branch_id, CONCAT_WS(' ', emp.f_name, emp.m_name, emp.l_name) AS full_name, emp.curr_designation_id, emp.curr_unit_id, emp.curr_department_id, professional.professional_level_code, dm.designation_level_code, designation.designation_name, depart.department_name 
          FROM employee_master emp
          LEFT JOIN professional_level_master professional ON professional.professional_level_id = emp.curr_professional_level_id
          LEFT JOIN designation_master designation ON designation.designation_id = emp.curr_designation_id and designation.is_deleted_flag = 'n'
          LEFT JOIN designation_level_master dm ON dm.designation_level_id = designation.designation_level_id 
          LEFT JOIN department_master depart ON depart.department_id = emp.curr_department_id and depart.is_deleted_flag = 'n'
          LEFT JOIN branch_master branch ON branch.branch_id = emp.curr_branch_id and branch.is_deleted_flag = 'n' 
          WHERE emp.emp_id = '$empId' and emp.is_deleted_flag = 'n' and emp._status = 'employed'";

          $result = $this->db->query($sql)->row_array();

          $fiscalYear = $this->db->query("SELECT a.fiscal_year_id, a.fiscal_year_name, a.fiscal_year_start_date, ad_to_bs(a.fiscal_year_start_date) as fiscal_year_start_date_bs, a.fiscal_year_end_date, ad_to_bs(a.fiscal_year_end_date) as fiscal_year_end_date_bs, ad_to_bs(date_format(NOW(), '%Y-%m-%d')) as current_date_bs, date_format(NOW(), '%Y-%m-%d') as current_date_ad, a.is_locked_flag FROM fiscal_year_master a where date_format(NOW(), '%Y-%m-%d') BETWEEN a.fiscal_year_start_date and a.fiscal_year_end_date")->row_array();

          $data_session = array(
            'full_name' => $result['full_name'] ,
            'user_name'=> $checkPassword['user_name'],
            'fiscal_year_id' => $fiscalYear['fiscal_year_id'],
            'emp_id'=> $empId,
            'role_id'=> $checkPassword['role_id'],
            'branch_id'=> $result['curr_branch_id'],
            'branch_name'=> $result['branch_name'],
            'designation_id' => $result['curr_designation_id'],
            'department_id' => $result['curr_department_id'],
            'unit_id' => $result['curr_unit_id'],
            'designation' => $result['designation_name'],
            'curr_department' => $result['department_name'],
            'alkane_logged_in' => TRUE,
          );   

          $login_log = array(
            'emp_id' => $checkPassword['emp_id'],
            'ip' => $_SERVER['REMOTE_ADDR'],
            'login_date_time' => date('Y-m-d H:i:s'),
          );

          $this->db->where(array('emp_id'=>$checkPassword['emp_id']));
          $this->db->set('invalid_login_attempt', '0');
          $this->db->update('staffs');

          $this->db->insert('login_log', $login_log);

          $this->response([
            'success' => true,
            'status_code' => 200,
            'message' => 'Success',
            'data'=> $data_session,
          ],REST_Controller::HTTP_OK);
        }
        else{
          $response = $this->_invalidLogin($checkUsername['emp_id']);

          if (FALSE === $response) {
            $this->response([
              'success' => false,
              'status_code' => 403,
              'message' => 'Your Account has been locked !! Please Contact System Administrator',
              'data'=> '',
            ], 403); 
          }
        }
      }
      else{
        $this->response([
          'success' => false,
          'status_code' => 403,
          'message' => 'Incorrect Username or Password',
          'data'=> ''
        ], 403);
      }
    }
  }

  function _invalidLogin($empId){
    $invalidAttempt = $this->db->select('invalid_login_attempt')
    ->where('is_active', 'y')
    ->where('lock_flag', 'false')
    ->where('emp_id', $empId)
    ->get('staffs')->row_array();

    $invalidAttemptNum = '0';

    if (3 === (int)$invalidAttempt['invalid_login_attempt']) {
      $this->db->where(array('emp_id'=>$empId));
      $this->db->set('lock_flag', 'true');
      $this->db->update('staffs');
      return FALSE;
    }
    else{
      $invalidAttemptNum = (int)$invalidAttempt['invalid_login_attempt'] + 1;
      $remainingAttempt = 4 - (int)$invalidAttemptNum;

      $this->db->set('invalid_login_attempt', $invalidAttemptNum);
      $this->db->where(array('emp_id'=>$empId));
      $this->db->update('staffs');

      $this->response([
        'success' => false,
        'status_code' => 403,
        'message' => 'Login error',
        'data'=> 'Only '. $remainingAttempt.' Attempts Left.'
      ], 403);

      return TRUE;
    }
  }

  function checkOverlappedDateRange($existingStartTime, $existingEndTime, $userStartTime, $userEndTime){
    if(($existingEndTime < $userStartTime)){
      return false;
    }
    else if(($existingStartTime > $userStartTime) && ($existingStartTime > $userEndTime)) {
      return false;
    }
    else{
      return true;
    }
  }

  function headerList_get(){
    $data = $this->db->select('id, name, text')
    ->where('type', 'header')
    ->get('message_header_footer')->result_array();

    if(!empty($data)){
      $this->response([
        'success' => TRUE,
        'status_code' => 200,
        'message' => 'Success',
        'data'=> $data,
      ],REST_Controller::HTTP_OK);
    }
    else{
      $this->response([
        'success' => false,
        'status_code' => 403,
        'message' => 'No Data Found.',
        'data'=> '',
      ], 403); 
    }
  }

  function footerList_get(){
    $data = $this->db->select('id, name, text')
    ->where('type', 'footer')
    ->get('message_header_footer')->result_array();

    if(!empty($data)){
      $this->response([
        'success' => TRUE,
        'status_code' => 200,
        'message' => 'Success',
        'data'=> $data,
      ],REST_Controller::HTTP_OK);
    }
    else{
      $this->response([
        'success' => false,
        'status_code' => 403,
        'message' => 'No Data Found.',
        'data'=> '',
      ], 403); 
    }
  }

  function scheduleMeeting_post(){
    $this->load->library('form_validation');

    $this->form_validation->set_rules('category','Meeting Category','required');
    $this->form_validation->set_rules('set_for','Meeting Set For','required');

    $this->form_validation->set_rules('date','Meeting Date','required');
    $this->form_validation->set_rules('start_time','Meeting Time','required');

    $this->form_validation->set_rules('reminder_before','Meeting Reminder Time','required|numeric|greater_than[0]');

    $this->form_validation->set_rules('internal_sms','Internal SMS','required');
    $this->form_validation->set_rules('external_sms','External SMS','required');

    $this->form_validation->set_rules('header_id','Header','required');
    $this->form_validation->set_rules('footer_id','Footer','required');
    $this->form_validation->set_rules('body_text','Body Text','required');

    if ($this->form_validation->run() == FALSE) {
      $this->response([
        'success' => false,
        'status_code' => 403,
        'message' => 'Form Validation Error',
        'data'=> preg_replace('/\s+/', ' ', trim(strip_tags(validation_errors())))
      ], 403);
    } 
    else {

      $this->db->trans_begin();
      
      $startTime = $this->input->post('start_time');
      $endTime = $this->input->post('end_time');

      if(!empty($startTime) && !empty($endTime)){
        if (strtotime($startTime) >= strtotime($endTime)) {
          $this->response([
            'success' => false,
            'status_code' => 403,
            'message' => 'Incorrect Entry. Meeting end time cannot be greater than start time',
            'data'=> '',
          ], 403); 
        }
      }

      $checkMeeting = $this->db->select('start_time, end_time, meeting_id')
      ->where('meeting_date', $this->input->post('date'))
      ->where('status_flag', 'scheduled')
      ->get('meeting_master')->result_array();

      if (!empty($checkMeeting['start_time']) && !empty($checkMeeting['end_time'])) {
        foreach ($checkMeeting as $value) {
          $result = $this->checkOverlappedDateRange($value['start_time'], $value['end_time'], $startTime, $endTime);

          if (TRUE==$result) {
            $meetingData = $this->getMeetingInfoById($value['meeting_id']);

            $this->response([
              'success' => false,
              'status_code' => 403,
              'message' => 'Meeting already scheduled on '.$this->input->post('date').' from '.$startTime.' to '.$endTime,
              'data'=> $meetingData,
            ], 403); 
          }
        }
      }


      $maxValue = $this->db->query("SELECT max(meeting_id) AS max_value FROM meeting_master")->row_array();
      $meetingId = $maxValue['max_value'] + 1;

      $meeting = array(
        'meeting_id' => $meetingId,
        'category' => $this->input->post('category'),
        'set_for' => $this->input->post('set_for'),

        'company_name' => $this->input->post('company_name'),
        'contact_person' => $this->input->post('contact_person'),
        'contact_person_number' => $this->input->post('contact_number'),

        'meeting_date' => $this->input->post('date'),
        'start_time' => $this->input->post('start_time'),
        'reminder_before' => $this->input->post('reminder_before'),

        'internal_sms' => $this->input->post('internal_sms'),
        'external_sms' => $this->input->post('external_sms'),

        'header_id' => $this->input->post('header_id'),
        'footer_id' => $this->input->post('footer_id'),
        'body_text' => $this->input->post('body_text'),

        'branch_id' => $this->input->post('branch_id'),

        'status_flag' => 'scheduled',
        'created_date' => date('Y-m-d H:i:s'),
        'created_by' => $this->input->post('emp_id'),
      );

      if('Face to Face Meeting'==$this->input->post('category')){
        $meeting['end_time'] = $this->input->post('end_time');
        $meeting['venue'] = $this->input->post('venue');
      }

      $this->db->insert('meeting_master', $meeting);
      

      if(FALSE == $this->db->trans_status()){
        $this->db->trans_rollback();

        $this->response([
          'success' => false,
          'status_code' => 403,
          'message' => 'Transaction Failed',
          'data'=> '',
        ], 403); 
      }
      else{
        $this->db->trans_commit();

        $this->response([
          'success' => TRUE,
          'status_code' => 200,
          'message' => 'Success',
          'data'=> $meetingId,
        ],REST_Controller::HTTP_OK);
      }
    }
  }

  function getMeetingListByStatus_get(){
    $branchId = $this->input->get('branch_id');
    $status = $this->input->get('status');

    $data = $this->db->select('m.meeting_id, m.category, m.set_for, m.meeting_date, ad_to_bs(m.meeting_date) AS meeting_date_bs, m.start_time, m.end_time, m.venue, m.company_name, m.contact_person, m.contact_person_number, m.reminder_before, m.status_flag, m.created_date, getEmployeeNameByEmpId(m.created_by) AS created_by, body_text, h.text AS header, f.text AS footer')
    ->select("TIMESTAMPDIFF(MINUTE, m.start_time, m.end_time) AS diff_minute")
    ->join('message_header_footer h', 'h.id = m.header_id', 'LEFT')
    ->join('message_header_footer f', 'f.id = m.footer_id', 'LEFT')
    ->where('m.status_flag', $status)
    ->where('m.branch_id', $branchId)
    ->order_by('m.meeting_date', 'ASC')
    ->get('meeting_master m')->result_array();

    if (!empty($data)) {
      $this->response([
        'success' => true,
        'status_code' => 200,
        'message' => 'Success',
        'data'=> $data,
      ],REST_Controller::HTTP_OK);
    }
    else{
      $this->response([
        'success' => false,
        'status_code' => 403,
        'message' => 'No Data Found.',
        'data'=> '',
      ], 403); 
    }
  }

  function updateMeetingStatus_post(){
    $statusArray = array(
      'status_flag' => $this->input->post('status'),
      'modified_date' => date('Y-m-d H:i:s'),
      'modified_by' => $this->input->post('emp_id'),
      'remarks' => $this->input->post('remarks'),
    );
    
    $meetingId = $this->input->post('meeting_id');

    $this->db->update('meeting_master', $statusArray, array('meeting_id'=>$meetingId));

    $this->response([
      'success' => TRUE,
      'status_code' => 200,
      'message' => 'Meeting Status changed to '.$this->input->post('status').' successfully',
      'data'=> '',
    ],REST_Controller::HTTP_OK);
  }

  function getCurrentMeetingList_get(){
    $startDate = date('Y-m-d').' 00:00:00';
    $endDate = date('Y-m-d').' 23:59:59';

    $data = $this->db->select('m.meeting_id, m.category, m.set_for, m.meeting_date, ad_to_bs(m.meeting_date) AS meeting_date_bs, m.start_time, m.end_time, m.venue, m.company_name, m.contact_person, m.contact_person_number, m.reminder_before, m.status_flag, m.created_date, getEmployeeNameByEmpId(m.created_by) AS created_by, body_text, h.text AS header, f.text AS footer')
    ->select("TIMESTAMPDIFF(MINUTE, m.start_time, m.end_time) AS diff_minute")
    ->join('message_header_footer h', 'h.id = m.header_id', 'LEFT')
    ->join('message_header_footer f', 'f.id = m.footer_id', 'LEFT')
    ->where("meeting_date BETWEEN '$startDate' AND '$endDate' ")
    ->get('meeting_master m')->result_array();

    if (!empty($data)) {
      $this->response([
        'success' => TRUE,
        'status_code' => 200,
        'message' => 'Success',
        'data'=> $data,
      ],REST_Controller::HTTP_OK);
    }
    else{
      $this->response([
        'success' => FALSE,
        'status_code' => 403,
        'message' => 'No Data Found.',
        'data'=> '',
      ], 403);
    }
  }

  function saveUserToken_post(){
    $this->load->library('form_validation');

    $this->form_validation->set_rules('emp_id','Emp ID','required');
    $this->form_validation->set_rules('token','Token','required');

    if ($this->form_validation->run() == FALSE) {
      $this->response([
        'success' => false,
        'status_code' => 403,
        'message' => 'Form Validation Error',
        'data'=> preg_replace('/\s+/', ' ', trim(strip_tags(validation_errors())))
      ], 403);
    } 
    else {

      $checkToken = $this->db->select('fcm_token')->where('emp_id', $this->input->post('emp_id'))->get('notification_token')->row_array();

      if(empty($checkToken)){
        $token = array(
          'emp_id' => $this->input->post('emp_id'),
          'fcm_token' => $this->input->post('token'),
          'created_date' => date('Y-m-d H:i:s'),
        );

        $this->db->insert('notification_token', $token);
      }
      else{
        $token = array(
          'fcm_token' => $this->input->post('token'),
        );

        $this->db->update('notification_token', $token, array('emp_id'=>$this->input->post('emp_id')));
      }

      $this->response([
        'success' => TRUE,
        'status_code' => 200,
        'message' => 'Success',
        'data'=> '',
      ],REST_Controller::HTTP_OK);
    }
  }

  function getMeetingInfoById($meetingId){
    $data = $this->db->select('m.meeting_id, m.internal_sms, m.external_sms, m.category, m.set_for, m.meeting_date, ad_to_bs(m.meeting_date) AS meeting_date_bs, m.start_time, m.end_time, m.venue, m.company_name, m.contact_person, m.contact_person_number, m.reminder_before, m.status_flag, m.created_date, getEmployeeNameByEmpId(m.created_by) AS created_by, m.created_by AS emp_id, body_text, h.text AS header, f.text AS footer')
    ->select("TIMESTAMPDIFF(MINUTE, m.start_time, m.end_time) AS diff_minute")
    ->join('message_header_footer h', 'h.id = m.header_id', 'LEFT')
    ->join('message_header_footer f', 'f.id = m.footer_id', 'LEFT')
    ->where('meeting_id', $meetingId)
    ->get('meeting_master m')->row_array();

    return $data;
  }

  function meetingReminderNotification_get(){
    $this->load->helper('common');

    $this->db->trans_begin();

    $startDate = date('Y-m-d').' 00:00:00';
    $endDate = date('Y-m-d').' 23:59:59';

    $data = $this->db->select('meeting_id, reminder_before, start_time, internal_sms, external_sms')
    ->select("TIMESTAMPDIFF(MINUTE, start_time, end_time) AS diff_minute")
    ->where("meeting_date BETWEEN '$startDate' AND '$endDate' ")
    ->where('status_flag', 'scheduled')
    ->where('notification_flag', 0)
    ->get('meeting_master')->result_array();

    if (!empty($data)) {

      foreach ($data as $key => $value) {
        $startTime = date($value['start_time']);
        $reminderTime = date('H:i:s', strtotime($startTime) - ($value['reminder_before'] * 60));

        if (strtotime(date('H:i:s')) >= strtotime($reminderTime)) {
          $meetingInfo = $this->getMeetingInfoById($value['meeting_id']);

          $message = $meetingInfo['header']."\r\n\r\n".$meetingInfo['body_text']."\r\n\r\n".$meetingInfo['footer'];

          /*$this->load->library('SendUserNotification', '', 'SendUserNotification');
          $this->SendUserNotification->sendNotification($message);*/

          $this->db->update('meeting_master', array('notification_flag'=>1), array('meeting_id'=>$meetingInfo['meeting_id']));

          if (!empty($meetingInfo['contact_person_number']) && 1==$meetingInfo['external_sms']) {
            $data = array(
              'to' => $meetingInfo['contact_person_number'],
              'msg' => $message,
            );

            sendSMS($data);
          }

          if(1==$meetingInfo['internal_sms']){

            if ('self'==$meetingInfo['set_for']) {
              $this->db->where('emp_id', $meetingInfo['emp_id']);
            }
            else{
              $this->db->where('emp_id', 49);
            }

            $number = $this->db->select('mobile_no_official')->get('employee_master')->row_array();

            $data = array(
              'to' => $number['mobile_no_official'],
              'msg' => $message,
            );

            sendSMS($data);
          }
        }
      }
    }

    if(FALSE == $this->db->trans_status()){
      $this->db->trans_rollback();

      $this->response([
        'success' => FALSE,
        'status_code' => 403,
        'message' => 'Transaction Failed.',
        'data'=> '',
      ], 403);
    }
    else{
      $this->db->trans_commit();

      $this->response([
        'success' => TRUE,
        'status_code' => 200,
        'message' => 'Success',
        'data'=> '',
      ],REST_Controller::HTTP_OK);
    }
  }

  function editMeetingDetails_post(){
    $this->load->library('form_validation');

    $this->form_validation->set_rules('category','Meeting Category','required');

    $this->form_validation->set_rules('date','Meeting Date','required');
    $this->form_validation->set_rules('start_time','Meeting Start Time','required');

    $this->form_validation->set_rules('reminder_before','Meeting Reminder Before','required|numeric|greater_than[0]');
    
    $this->form_validation->set_rules('internal_sms','Internal SMS','required');
    $this->form_validation->set_rules('external_sms','Internal SMS','required');


    if ($this->form_validation->run() == FALSE) {
      $this->response([
        'success' => false,
        'status_code' => 403,
        'message' => 'Form Validation Error',
        'data'=> preg_replace('/\s+/', ' ', trim(strip_tags(validation_errors())))
      ], 403);
    } 
    else {

      $this->db->trans_begin();
      
      $startTime = $this->input->post('start_time');
      $endTime = $this->input->post('end_time');

      if (!empty($startTime) && !empty($endTime)) {
        if (strtotime($startTime) >= strtotime($endTime)) {
          $this->response([
            'success' => false,
            'status_code' => 403,
            'message' => 'Incorrect Entry. Meeting end time cannot be greater than start time',
            'data'=> '',
          ], 403); 
        }
      }


      $checkMeeting = $this->db->select('start_time, end_time, meeting_id')
      ->where('meeting_date', $this->input->post('date'))
      ->where('status_flag', 'scheduled')
      ->get('meeting_master')->result_array();

      if (!empty($checkMeeting['start_time']) && !empty($checkMeeting['end_time'])) {

        foreach ($checkMeeting as $value) {
          $result = $this->checkOverlappedDateRange($value['start_time'], $value['end_time'], $startTime, $endTime);

          if (TRUE==$result) {
            $meetingData = $this->getMeetingInfoById($value['meeting_id']);

            $this->response([
              'success' => false,
              'status_code' => 403,
              'message' => 'Meeting already scheduled on '.$this->input->post('date').' from '.$startTime.' to '.$endTime,
              'data'=> $meetingData,
            ], 403); 
          }
        }
      }


      $meeting = array(
        'meeting_date' => $this->input->post('date'),
        'start_time' => $this->input->post('start_time'),
        'reminder_before' => $this->input->post('reminder_before'),

        'internal_sms' => $this->input->post('internal_sms'),
        'external_sms' => $this->input->post('external_sms'),

        'status_flag' => 'scheduled',
        'modified_date' => date('Y-m-d H:i:s'),
        'modified_by' => $this->input->post('emp_id'),
      );

      if('Face to Face Meeting'==$this->input->post('category')){
        $meeting['end_time'] = $this->input->post('end_time');
        $meeting['venue'] = $this->input->post('venue');
      }
      
      $whereCondition = array(
        'meeting_id' => $this->input->post('meeting_id'),
      );

      $this->db->update('meeting_master', $meeting, $whereCondition);   

      if(FALSE == $this->db->trans_status()){
        $this->db->trans_rollback();

        $this->response([
          'success' => false,
          'status_code' => 403,
          'message' => 'Transaction Failed',
          'data'=> '',
        ], 403); 
      }
      else{
        $this->db->trans_commit();

        $this->response([
          'success' => TRUE,
          'status_code' => 200,
          'message' => 'Success',
          'data'=> $this->input->post('meeting_id'),
        ],REST_Controller::HTTP_OK);
      }
    }
  }

  

}

?>