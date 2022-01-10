<?php defined('BASEPATH') OR exit('No direct script access allowed');

class OAS_Controller extends MX_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->load->helper('auth');
		verifyLoggedInStatus();
		verifyLoggedinStatusAjaxCall();			
	}

	protected function _checkMenuAccess(string $menuCode):bool{

		$roleId = $this->session->userdata('role_id');
		$empId = $this->session->userdata('emp_id');

		$sql = "select b.menu_code from role_permission a 
		inner join menu_master b on a.menu_id=b.menu_id 
		where a.role_id='$roleId' and b.menu_code='$menuCode' and b.is_active='y'
		UNION 
		select b.menu_code from user_permission a 
		inner join menu_master b on a.menu_id=b.menu_id 
		where a.emp_id='$empId' and b.menu_code='$menuCode' and b.is_active='y'";

		$menu = $this->db->query($sql);

		if(1===$menu->num_rows()){
			return TRUE;
		}	
		return FALSE;
	}

	protected function _hasMenuAccess(string $menuCode){
		if(! $this->_checkMenuAccess($menuCode)){
			show_error('The action you have requested is not allowed.', 403, 'Unauthorized Access !!');
		}
	}	
}

