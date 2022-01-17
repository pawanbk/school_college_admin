<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MenuSetupModel extends CI_Model {

	function getMenuAll():array{
		$data = $this->db->select("a.menu_id, a.menu_code, a.menu_name, a.pre_menu_id,a.menu_type,a.menu_index")
		->from('menu_master a')
		->where(array('a.is_active'=>'y'))
		->order_by('a.pre_menu_id,a.menu_index')
		->get();
		
		$result = array();

		//fetching from mysqli_result object and encrypting id and formatting array index to create nested hierarchy array
		while($row = mysqli_fetch_assoc($data->result_id)){
			$row['enc_menu_id'] = urlencode(base64_encode($row['menu_id']));
			$result[$row['menu_id']] = $row;
		}
		
		return $result;
	}

	function getMenuAllOuter():array{
		$data = $this->db->select("a.menu_id, a.menu_code, a.menu_name, a.pre_menu_id, a.menu_type, a.menu_index,a.icon_class")
		->from('menu_master a')
		->where(array('a.is_active'=>'y','a.menu_type'=>'outer'))
		->order_by('a.pre_menu_id,a.menu_index')
		->get();
		
		$result = array();

		//fetching from mysqli_result object and encrypting id and formatting array index to create nested hierarchy array
		while($row = mysqli_fetch_assoc($data->result_id)){
			$row['enc_menu_id'] = urlencode(base64_encode($row['menu_id']));
			$result[$row['menu_id']] = $row;
		}
		
		return $result;
	}


	function getMenuByID(string $menuId):array{
		$this->db->select("a.menu_id, a.menu_code, a.menu_name, a.pre_menu_id,b.menu_name as parent_menu, a.menu_type, a.route, a.icon_class, a.menu_index")
		->from('menu_master a')
		->where(array('a.menu_id'=>$menuId,'a.is_active'=>'y'))
		->join('menu_master b','a.pre_menu_id=b.menu_id','left');
		$result = $this->db->get()->row_array();
		return $result;
	}

	
	function insertNewMenu(array $data):string{
		$data['created_by'] = $this->session->userdata('emp_id');
		$data['created_date'] = date('Y-m-d H:i:s');

		$this->db->insert('menu_master', $data);
		return urlencode(base64_encode($this->db->insert_id()));
	}


	function updateMenuById(string $menuId , array $data):string{
		$data['modified_by'] = $this->session->userdata('emp_id');
		$data['modified_date'] = date('Y-m-d H:i:s');

		$this->db->update('menu_master', $data, array('menu_id'=>$menuId));
		return urlencode(base64_encode($menuId));
	}
}