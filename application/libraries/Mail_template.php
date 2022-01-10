<?php

class Mail_template{
  var $CI;

  public function __construct(){
    $this->CI =& get_instance();
  }    

  public function send_email($from = null, $to = null, $cc = null, $subject = null, $msg = null){
    $this->CI->load->library('email'); 
    $config['protocol'] = 'sendmail';
    $config['wordwrap'] = FALSE;
    $config['mailtype'] = 'html';
    $this->CI->email->initialize($config);

    $this->CI->email->from($from);
    $this->CI->email->to($to); 

    if($email_cc ! ="" || $email_cc != null){
      $this->CI->email->cc($cc);
    }

    $this->CI->email->subject($subject);
    $this->CI->email->message($msg);
    $this->CI->email->send();
  }
} 