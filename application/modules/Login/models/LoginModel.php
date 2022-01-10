<?php defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	function checkStaffUsername($email){
		$this->db->select('email, user_id');
		$this->db->where('is_active', 'Active');
		$this->db->where('is_locked_flag', 'Not-Locked');
		$this->db->where('email', $email);
		$data = $this->db->get('user_auth')->row_array();
		return $data;
	}

	function checkStaffPassword($email, $password_detail){
		$this->db->select('user_id, full_name, email');
		$this->db->where('is_active', 'Active');
		$this->db->where('is_locked_flag', 'Not-Locked');
		$this->db->where('email', $email);
		$this->db->where('pass', md5($password_detail));
		$data = $this->db->get('user_auth')->row_array();
		return $data;
	}

}

?>