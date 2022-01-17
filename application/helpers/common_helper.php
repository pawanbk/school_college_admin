<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(! function_exists('arrayHierarchy')){
	function arrayHierarchy(array $data, string $prelinkColumnName, string $idColumnName):array{
		$hierarchyData = array(); 
		foreach ( $data as &$row ) {
			if ('0'==$row[$prelinkColumnName]) {
				
				$hierarchyData[] = &$row;
			}
			else {
				$pid = $row[$prelinkColumnName];
				if ( isset($data[$pid]) ) {
					$data[$pid]['child'][] = &$row;
				}
			}
		}

		return $hierarchyData;
	}
}

if(! function_exists('populateMenu')){	
	function populateMenu():string{
		$CI =& get_instance();

		$sql = "select b.menu_id, b.menu_code, b.menu_name,b.pre_menu_id,b.menu_index, b.route, b.icon_class
		from menu_master b
		where b.menu_type='outer' and b.is_active='y'
		order by pre_menu_id,menu_index";
		
		$data = $CI->db->query($sql);

		$menu = array();

		while($row = mysqli_fetch_assoc($data->result_id)){
			$menu[$row['menu_id']] = $row;
		}

		$menu = arrayHierarchy($menu, 'pre_menu_id', 'menu_id');

		$output = formatMenuOuput($menu);
		return $output;
	}
}


if(! function_exists('formatMenuOuput')){
	function formatMenuOuput(array $data):string{
		$output = ''; 

		foreach ($data as $key => $row) {

			if(isset($row['child'])){
				$output .= '<li>';
				$output .= '<a href="javascript: void(0);" class="has-arrow waves-effect">';
				$output .= '<i class="'.$row['icon_class'].'"></i>';
				$output .= '<span>'.$row['menu_name'].'</span>';
			}
			else{
				$output .= '<li>';
				$output .= '<a href="'.site_url($row['route']).'">'.$row['menu_name'].'</a>';
				$output .= '</li>';
			}

			if(isset($row['child'])){
				$output .= '</a>';

				$output .= '<ul class="sub-menu" aria-expanded="false">';
				$output .= formatMenuOuput($row['child']);
				$output .= '</ul>';
			}
			else{
				$output .= '</li>';
			}

			$output .= '</li>';
		}
		return $output;
	}
}


if(! function_exists('getBranchHavingAccess')){	
	function getBranchHavingAccess(){
		$CI =& get_instance();

		$empId = $CI->session->userdata('emp_id');
		$currBranchId = $CI->session->userdata('branch_id');

		// branch control according to session role
		$branchAccessArray = array();
		$branchAccess = $CI->db->query("SELECT br.branch_id
			from user_branch_access_master ubac inner join branch_master br on br.branch_id=ubac.branch_id AND br.is_deleted_flag='n' WHERE ubac.emp_id= '$empId'
			UNION
			SELECT
			'$currBranchId' as branch_id"
		);

		while($row = mysqli_fetch_assoc($branchAccess->result_id)){
			$branchAccessArray[$row['branch_id']] = $row;
		}

		$branchAccessList = implode(" , ", array_map(function ($entry){
			return $entry['branch_id'];
		}, $branchAccessArray));

		return $branchAccessList;
	}
}

if(! function_exists('getProfilePhotoPath')){	
	function getProfilePhotoPath():string{
		$CI =& get_instance();

		$profileImage = base_url().'assets/images/Icon-user.png';		
		return $profileImage;
	}
}


