<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MenuSetup extends OAS_Controller {
	public $data = array();

	public function __construct(){
		parent::__construct();
	}

	
	public function index(){
		$this->data['main_title'] = "Menu Management";
		$this->data['title_small'] = "Menu List";

		$this->data['inner_template'] = 'MenuSetup/index';
		$this->load->view('Common/common', $this->data);
	}


	public function getMenuList(){
		$this->load->model('MenuSetupModel');
		$this->load->helper('common');

		$dataOutput = '';
		$msg = '';
		$response = FALSE;
		try {
			$dataOutput = arrayHierarchy($this->MenuSetupModel->getMenuAll(), 'pre_menu_id', 'menu_id');
			$response = TRUE;
		} catch (Throwable $e) {
			$msg = $e->getMessage()." :{";
		}

		$output = array(
			'result' => $dataOutput,
			'response' => $response,
			'msg' => $msg,
		);

		print(json_encode($output));
		exit();
	}


	public function add(){
		$this->load->model('MenuSetupModel');
		$this->load->library('form_validation');

		if(isset($_POST['save_menu'])){

			$output = array(
				'result' => '',
				'response' => FALSE,
				'msg' => "Operation Failed",
			);

			$this->form_validation->set_rules('menu_code', 'Menu Code', 'required|min_length[5]|max_length[80]|is_unique[menu_master.menu_code]');
			$this->form_validation->set_rules('menu_name', 'Menu Title', 'required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('menu_type', 'Menu Type', 'required');

			if(isset($_POST['menu_type']) && MENU_TYPE['OUTER']==$_POST['menu_type']){
				$this->form_validation->set_rules('route', 'Route', 'required|min_length[5]|max_length[80]');
			}

			$this->form_validation->set_rules('icon_class', 'Icon Class', 'min_length[4]|max_length[50]');
			$this->form_validation->set_rules('menu_index', 'Menu Position', 'required|less_than[999]|is_natural');

			if($this->form_validation->run() === FALSE) {
				$output = array(
					'result' => $this->form_validation->error_array(),
					'response' => FALSE,
					'msg' => 'Form validation error',
					'type' =>'form-error',
				);
			}
			else{
				$maxValue = $this->db->query("SELECT max(menu_id) AS max_value FROM menu_master")->row_array();
				$menuId = $maxValue['max_value'] + 1;

				$dataInsert = array(
					'menu_id' => $menuId,
					'menu_code'=>trim($this->input->post('menu_code')),
					'menu_name'=>trim(ucwords($this->input->post('menu_name'))),
					'pre_menu_id'=>(isset($_POST['parent_menu']) && ! empty($_POST['parent_menu'])) ? base64_decode(urldecode($this->input->post('parent_menu'))): 0,
					'menu_type'=>$this->input->post('menu_type'),
					'route'=>(isset($_POST['menu_type']) && (MENU_TYPE['OUTER']==$_POST['menu_type']))? trim($this->input->post('route')):'javascript::',
					'menu_index'=>trim($this->input->post('menu_index')),
				);

				if(''!=trim($this->input->post('icon_class'))){
					$dataInsert['icon_class'] = trim($this->input->post('icon_class'));
				}
				
				$result = $this->MenuSetupModel->insertNewMenu($dataInsert);
				
				if(! empty($result)){
					$output = array(
						'result' => $result,
						'response' => TRUE,
						'msg' => "New Menu Created Successfully",
					);
				}
			}

			print(json_encode($output));
			exit();
		}

		$view = $this->load->view('add','',TRUE);
		$output = array(
			'result' => $view,
			'response' => TRUE,
			'msg' => "",
		);
		print(json_encode($output));
		exit();
	}


	public function edit(string $menuId){
		$data['menuIdEnc'] = $menuId;
		$menuId = base64_decode(urldecode($menuId)); 

		$this->load->model('MenuSetupModel');
		$data['menu'] =$this->MenuSetupModel->getMenuByID($menuId);

		$this->load->library('form_validation');

		if(isset($_POST['update_menu'])){

			$output = array(
				'result' => '',
				'response' => FALSE,
				'msg' => "Operation Failed",
			);

			$this->form_validation->set_rules('menu_id', 'Menu Id', 'required');

			if($this->input->post('menu_code') != $data['menu']['menu_code']) {
				$this->form_validation->set_rules('menu_code', 'Menu Code', 'required|min_length[5]|max_length[80]|is_unique[menu_master.menu_code]');
			} else {
				$this->form_validation->set_rules('menu_code', 'Menu Code', 'required|min_length[5]|max_length[80]');
			}

			$this->form_validation->set_rules('menu_name', 'Menu Title', 'required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('menu_type', 'Menu Type', 'required');

			if(isset($_POST['menu_type']) && MENU_TYPE['OUTER']==$_POST['menu_type']){
				$this->form_validation->set_rules('route', 'Route', 'required|min_length[5]|max_length[80]');
			}

			$this->form_validation->set_rules('icon_class', 'Icon Class', 'min_length[4]|max_length[50]');
			$this->form_validation->set_rules('menu_index', 'Menu Position', 'required|less_than[999]|is_natural');


			if($this->form_validation->run() === FALSE) {
				$output = array(
					'result' => $this->form_validation->error_array(),
					'response' => FALSE,
					'msg' => 'Form validation error',
					'type' =>'form-error',
				);
			}
			else{
				$dataUpdate = array(
					'menu_code'=>trim($this->input->post('menu_code')),
					'menu_name'=>trim(ucwords($this->input->post('menu_name'))),
					'pre_menu_id'=>(isset($_POST['parent_menu']) && ! empty($_POST['parent_menu'])) ? base64_decode(urldecode($this->input->post('parent_menu'))): 0,
					'menu_type'=>$this->input->post('menu_type'),
					'route'=>(isset($_POST['menu_type']) && (MENU_TYPE['OUTER']==$_POST['menu_type']))? trim($this->input->post('route')):'javascript::',
					'menu_index'=>trim($this->input->post('menu_index')),
					'modified_deleted_remarks'=>$this->input->post('modifiedRemarks'),
				);

				if(''!=trim($this->input->post('icon_class'))){
					$dataUpdate['icon_class'] = trim($this->input->post('icon_class'));
				}
				
				$result = $this->MenuSetupModel->updateMenuById($menuId, $dataUpdate);
				if(! empty($result)){
					$output = array(
						'result' => $result,
						'response' => TRUE,
						'msg' => "Menu Updated Successfully",
					);
				}
			}

			print(json_encode($output));
			exit();
		}

		$view = $this->load->view('edit', $data, TRUE);
		$output = array(
			'result' => $view,
			'response' => TRUE,
			'msg' => "",
		);
		print(json_encode($output));
		exit();
	}

	
	public function viewDetail(string $menuId){
		$data['menuIdEnc'] = $menuId;
		$menuId = base64_decode(urldecode($menuId)); 

		$this->load->model('MenuSetupModel');
		$data['menu'] =$this->MenuSetupModel->getMenuByID($menuId);

		$view = $this->load->view('viewDetail', $data, TRUE);
		$output = array(
			'result' => $view,
			'response' => TRUE,
			'msg' => "",
		);
		print(json_encode($output));
		exit();
	}

}