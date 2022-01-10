<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Login extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->methods['users_1get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key

        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('date');
    }

    function login_post() {
        $this->load->helper('security');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->response([
                        'success' => false,
                        'status_code' => 403,
                        'message' => 'Login error',
                        
                        'data'=> preg_replace('/\s+/', ' ', trim(strip_tags(validation_errors())))
                        
                        ],REST_Controller::HTTP_OK);
            
           
        } 
        
        else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $this->load->model('admin_model');
            $username_exists = $this->admin_model->username_exists($username);
            if ($username_exists) {
                // $password = md5(config_item('salt') . $password); 
                $database_password = $this->admin_model->get_password_username($username);

                if (strcmp($password, $database_password) == 0) {
                    $admin_detail = $this->admin_model->get_user_id($username, $database_password);
                    if ($admin_detail) {
                        
                        
                        // if(!empty($this->db->get_where('tbl_e_gov_emp',array('id'=>$admin_detail->id))->row()))
                        // {
                        //     $data=$this->db->get_where('tbl_e_gov_emp',array('id'=>$admin_detail->id))->row();
                            
                        // }
                        
                        // else
                        // {
                            $data['uid']=$admin_detail->staff_id;
                        // }
                        
                        
                        $this->response([
                        'success' => true,
                        'status_code' => 200,
                        'user_data'=>$data,
                        'message' => 'Successfully loggedin'
                        ],

                        REST_Controller::HTTP_OK);
                
                     
                    }
                } else {
                    $this->response([
                        'success' => false,
                        'status_code' => 403,
                        'message' => 'Wrong Password'
                    ], REST_Controller::HTTP_NOT_FOUND);
                }
            } else {
                    $this->response([
                        'success' => false,
                        'status_code' => 403,
                        'message' => 'User doesnot exist'
                    ], REST_Controller::HTTP_NOT_FOUND);

            }
        }
    }



    function registration_post()
    {

        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[tbl_authenticate.username]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[tbl_user_details.email]');
        $this->db->set('last_login', 'NOW()', FALSE);

        if ($this->form_validation->run() == FALSE) {

                $this->response([
                        'success' => false,
                        'status_code' => 403,
                        'message' => 'Details insertion problem',
                        'data'=> preg_replace('/\s+/', ' ', trim(strip_tags(validation_errors())))
                        ],

                        REST_Controller::HTTP_OK);
          
        } else {
            $data['username'] = $this->input->post('username');
            $data['password'] = md5($this->input->post('password'));
            $insert_validation = $this->db->insert('tbl_authenticate', $data);
     
            if ($insert_validation) {
                 $insert_id = $this->db->insert_id();

                $data2['name'] = $this->input->post('name');
               
                $data2['email'] = $this->input->post('email');
             
                $data2['uid'] = $insert_id;

                $insert = $this->db->insert('tbl_user_details', $data2);
                if ($insert) {
                    $this->response([
                        'success' => true,
                        'status_code' => 200,
                        'message' => 'User has been added successfully.',
                  ],

                        REST_Controller::HTTP_OK);
                }
                
            }

             else {
                $this->response([
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'Signup Error.'],
                    REST_Controller::HTTP_NOT_FOUND);
            }
        }

    }


public function user_get($id = "")
    {
    
        if ($id === NULL) {
            $q1 = "select d.uid as user_id, d.name,d.contact,d.address,d.dob,d.gender,d.email,i.image from tbl_user_details d JOIN 
                    tbl_user_image i ON d.uid=i.uid";
            $users = $this->db->query($q1)->result();

            if ($users) {
                $this->response([
                    'success' => true,
                    'status_code' => 200,
                    'message' => 'successful.',
                    'data' => $data = [$users],],
                    REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->response([
                    'success' => FALSE,
                    'status_code' => 403,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }


//        $id = (int)$id;

        if ($id < 0) {
            $this->response("Invalid Request", REST_Controller::HTTP_BAD_REQUtbEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $q2 = "select * from tbl_user_details";
        $user = $this->db->query($q2)->row();
        $status = array();
        if (!empty($user)) {
            $this->set_response([
                'success' => true,
                'status_code' => 200,
                'message' => 'successfull.',
                'data' => $data = [$user],], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'success' => FALSE,
                'status_code' => 403,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }

    }
}
?>