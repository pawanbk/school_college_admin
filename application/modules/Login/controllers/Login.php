<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller {

  function __construct(){
    parent::__construct();
    $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
    $this->output->set_header("Pragma: no-cache");
    $this->load->helper('form');
    $this->load->library('form_validation');
  }

  function index(){

    if($this->session->userdata('oas_logged_in')){
      redirect(base_url().'Dashboard');
   }

    if(isset($_POST['checkLogin'])){
      $this->load->helper('form');
      $this->load->library('form_validation');

      $this->form_validation->set_rules('username_info','Email Address', 'required|valid_email');
      $this->form_validation->set_rules('password_info','Password', 'required|max_length[25]');
      
      if($this->form_validation->run() === FALSE) {
        $error_msg = validation_errors();
        $this->session->set_flashdata('error_msg', $error_msg);
      }
      else{
        $email = $this->input->post('username_info');
        $pass_word = $this->input->post('password_info');

        $this->load->model('LoginModel');
        $checkUsername = $this->LoginModel->checkStaffUsername($email);

        if (!empty($checkUsername)) {
          $checkPassword = $this->LoginModel->checkStaffPassword($email, $pass_word);

          if (!empty($checkPassword)) {
            
            $data_session = array(
              'full_name' => $checkPassword['full_name'],
              'email' => $checkPassword['email'],
              'emp_id'=> $checkPassword['user_id'],
              'oas_logged_in'=>TRUE,
            ); 
            
            $this->session->set_userdata($data_session);
            
            redirect('Dashboard');
            exit();
          }
          else{
             
            $checkLocked = $this->db->select('is_locked_flag, is_active')->where('email', $email)->get('user_auth')->row_array();
            
            if('Locked'==$checkLocked['is_locked_flag'] || 'In-Active'==$checkLocked['is_active']){
                $this->session->set_flashdata('error_msg', 'Your Account has been locked!! <br><br>Please Contact System Administrator');
            }
            else{
                $this->session->set_flashdata('error_msg', 'Incorrect Username or Password');
            }
          }
        }
        else{
          $this->session->set_flashdata('error_msg', 'Incorrect Username or Password');
        }
      }
    }

    $this->load->view('login_page');
  }


  public function logout(){
    $this->session->sess_destroy();
    redirect(base_url());
  }

  function resetPassword(){
    $this->load->library('form_validation');

    if(isset($_POST['user_name'])){

      $this->form_validation->set_rules('user_name','UserName','min_length[4]|required');

      if($this->form_validation->run($this) === FALSE) {

      }
      else{
        $username = $this->input->post('user_name');

        $result = $this->db->select('user.emp_id, emp.email_official')
        ->join('staffs user', 'user.emp_id = emp.emp_id')
        ->where('user.user_name', $username)
        ->where('user.is_deleted_flag', 'n')
        ->where('emp._status', 'employed')
        ->get('employee_master emp')->row_array();

        if(!empty($result)){
          $defaultEmailSender = $this->db->query("SELECT value as email from global_configuration where title='defaultEmailSender'")->row_array();

          /*generating random bytes*/
          $VerificationCode = bin2hex(random_bytes(5));  

          $encEmpId = urlencode(base64_encode($result['emp_id']));
          $message = '
          Dear Concern,<br/><br/>
          You have initiated your account reset process.<br/><br/>
          <b>CODE:</b>  '.$VerificationCode.'<br/><br/>

          <a href="'.base_url().'Login/codeVerificationAccountReset/'.$encEmpId.'" _target="_blank"> Click Here to Reset Your account.</a>
          <br/><br/>
          OR<br/>
          Visit This Link :- '.base_url().'Login/codeVerificationAccountReset/'.$encEmpId.'
          <br/><br/>
          With Regards,<br/>
          HRIS - Classic Tech Pvt. Ltd.'
          ;

          /*updating user table with VerificationCode*/
          $data['verification_code'] = $VerificationCode;
          $this->db->update('staffs', $data, array('user_name' => $username));

          $config['protocol'] = 'sendmail';
          $config['wordwrap'] = FALSE;
          $config['mailtype'] = 'html';
          $this->load->library('email', $config);
          $this->email->from($defaultEmailSender['email']);
          $this->email->to($result['email_official']);      

          $this->email->subject('Password Reset');
          $this->email->message($message);

          $this->email->send();

          $this->session->set_flashdata('success_msg', 'Reset Link Sent To Your Mail Successfully !!');
          redirect(base_url().'Login/', 'refresh');
        }
        else{
          $this->session->set_flashdata('error_msg', 'Invalid User');
          redirect(base_url().'Login/', 'refresh');
        }
      }   
    }

    $this->load->view('ResetPass');

  }

  public function codeVerificationAccountReset($empId){
    $data['encEmpId'] = $empId;
    $empId = base64_decode(urldecode($empId));

    $this->load->library('form_validation');

    if(isset($_POST['changePassword'])){
      $this->form_validation->set_rules('verification_code', 'Verification Code', 'required|min_length[10]');
      $this->form_validation->set_rules('new_password', 'New Password', 'required');
      $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]|callback_is_valid_password');

      if($this->form_validation->run($this) === FALSE){


      }
      else{
        $sql = "SELECT user.user_id, user.user_name, emp.email_official, user.verification_code from employee_master emp
        INNER JOIN staffs user ON `user`.emp_id = emp.emp_id 
        WHERE `user`.user_id = '$empId' and `user`.is_deleted_flag = 'n' AND emp._status='employed'";

        $result = $this->db->query($sql)->row_array();
        
        if(!empty($result)){
          if($result['verification_code']==$this->input->post('verification_code')){
            $dataUpdate['modified_by'] = $result['user_name'];
            $dataUpdate['modified_date'] = date('Y-m-d H:i:s');
            $dataUpdate['modified_deleted_remarks'] = "Password Reset";
            $dataUpdate['pass_word'] = md5($this->input->post('confirm_password'));
            $dataUpdate['lock_flag'] = 'n';
            $dataUpdate['invalid_login_attempt'] = 0;
            $dataUpdate['verification_code'] = null;
            $this->db->update('staffs',$dataUpdate,array('user_id' => $empId));
            
            $this->session->set_flashdata('success_msg', 'Password Reset Changed Successfully!!');
            redirect(base_url().'Login','refresh');
          }
          else{
            $this->session->set_flashdata('error_msg', 'Invalid Verification Code !!');
            redirect(base_url().'Login/codeVerificationAccountReset/'.$data['encEmpId'],'refresh');
          }
        }
        else{
          $this->session->set_flashdata('error_msg', 'Illegal Activity Detected and Report to System Administrator.');
          redirect(base_url().'Login','refresh');
        }

      }
    }

    $this->load->view('Verification', $data);
  }
}
?>