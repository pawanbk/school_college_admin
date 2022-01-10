<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends OAS_Controller{
	public $data = array();

	function __construct(){
		parent::__construct();
  }

  function index(){
    $this->data['main_title'] = "Dashboard";
    $this->data['title_small'] = "Dashboard Page";

    $this->data['inner_template'] = 'Dashboard/DashboardViewPage';
    $this->load->view('Common/common', $this->data);
  }


  public function changeUserPassword(){
    if(isset($_POST['change_password'])){

      $output = array(
        'result' => '',
        'response' => FALSE,
        'msg' => "Operation Failed",
      );

      $this->load->library('form_validation');
      $this->form_validation->set_rules('curr_password', 'Current Password', 'required|max_length[25]');
      $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[5]|max_length[25]');
      $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|min_length[5]|matches[new_password]|max_length[25]');

      if($this->form_validation->run($this) === FALSE) {
        $output = array(
          'result' => $this->form_validation->error_array(),
          'response' => FALSE,
          'msg' => 'Form validation error',
          'type' =>'form-error',
        );
      }
      else{
        $username = $this->session->userdata('user_name');
        $empId = $this->session->userdata['emp_id'];

        $getCurrPass = $this->db->query("SELECT pass_word FROM staffs WHERE user_name = '$username' AND is_active = 'y' AND lock_flag = 'false'")->row_array();

        if ($getCurrPass['pass_word']==md5($this->input->post('curr_password'))) {

          if ($this->input->post('curr_password') != $this->input->post('confirm_password')) {
            $newPass = $this->input->post('confirm_password');

            $checkPassword = $this->checkpasswordParameter($newPass);

            if ($checkPassword['response']) {
              $pass = array(
                'invalid_login_attempt' => '0',
                'pass_word' => md5($newPass),
                'updated_by' => $this->session->userdata['emp_id'],
                'update_remarks' => "Password Changed",
                'updated_on' => date('Y-m-d H:i:s'),
              );

              $this->db->update('staffs', $pass, array('emp_id' => $empId));

              $output = array(
                'response' => True,
                'msg' => "Password Changed Successfully",
                'result' => ""
              );
            }
            else{
              $output = array(
                'response' => false,
                'msg' => $checkPassword['msg'],
                'result' => "",
              );
            }
          }
          else{
            $output = array(
              'response' => false,
              'msg' => "OLD PASSWORD!! Please Enter A New Password",
              'result' => "",
            );
          }
        }
        else{
          $output = array(
            'response' => false,
            'msg' => "Incorrect current Password. Please try again !!!",
            'result' => "",
          );
        }
      }
      print(json_encode($output));
      exit();
    }

    $this->data['main_title'] = "Change Password";
    $this->data['title_small'] = "";
    $this->data['inner_template'] = 'Dashboard/ChangePasswordPage';
    $this->load->view('Common/common', $this->data);
  }

  function checkpasswordParameter($newPass){
    $password = trim($newPass);
    $regex_lowercase = '/[a-z]/';
    $regex_uppercase = '/[A-Z]/';
    $regex_number = '/[0-9]/';
    $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';
    
    if (preg_match_all($regex_lowercase, $password) < 1){
      $output = array(
        'response' => False,
        'msg' => "The field must have at least one lowercase letter",
        'result' => "",
      );
      return $output;
    }
    
    if (preg_match_all($regex_uppercase, $password) < 1){
      $output = array(
        'response' => false,
        'msg' => "The field must have at least one uppercase letter",
        'result' => "",
      );
      return $output;
    }

    if (preg_match_all($regex_number, $password) < 1){
      $output = array(
        'response' => false,
        'msg' => "The field must have at least one number",
        'result' => "",
      );
      return $output;
    }

    if (preg_match_all($regex_special, $password) < 1){
      $output = array(
        'response' => false,
        'msg' => "The field must have at least one special character",
        'result' => "",
      );
      return $output;
    }

    $output = array(
      'response' => True,
      'msg' => "",
      'result' => "",
    );
    return $output;
  }

  

  function getEmployeeNotifications(){
    // $empId = $this->session->userdata['emp_id'];

    // $this->load->model('DashboardModel');
    // $data['myPendingLeaves'] = $this->DashboardModel->getMyPendingLeaveRequest($empId);

    $this->load->view('Dashboard/DashBoardWidget/EmployeeNotifications');
    return;
  }

}

?>