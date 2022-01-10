<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

if(! function_exists('verifyLoggedInStatus')){
	function verifyLoggedInStatus(){
		$CI = & get_instance();
		if(! $CI->session->userdata('oas_logged_in')){
			$CI->session->sess_destroy();
			redirect('Login');
		}
	}
}


if(! function_exists('verifyLoggedinStatusAjaxCall')){
	function verifyLoggedinStatusAjaxCall(){
		$CI = & get_instance();
		if(! $CI->session->userdata('oas_logged_in')){
			$CI->session->sess_destroy();
			exit("invalid login");
		}
	}
}

/* End of file auth_helper.php */
/* Location: ./application/helpers/auth_helper.php */