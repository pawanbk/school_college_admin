<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Attendance extends REST_Controller
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
        date_default_timezone_set('Asia/Kathmandu');
    }


    function checkin_post(){
        $data['checkin_verify']=$this->input->post('checkin_verify');
        $data['date']=date("Y:m:d");
        $data['user_id'] = $this->input->post('user_id');
        $data['in_location'] = $this->input->post('in_location'); 
        $data['in_time'] = date("H:i:s");
        
        //Late entry
        $working_details=$this->db->get_where('tbl_working_hour',array('id'=>1))->row();
        $entry_cal=$this->gettime(strtotime($working_details->in_time) - strtotime($data['in_time'])); 
        
        if($entry_cal[0]<0)
        {
          
           $data['late_time'] = str_replace("-","","$entry_cal[0]:$entry_cal[1]:$entry_cal[2]");
        }
            
        
        

        
            $this->db->insert('tbl_attendance', $data);
            $db_error=$this->db->error();
            if ($this->db->affected_rows()>0) {
                    $this->response([
                        'success' => true,
                        'status_code' => 200,
                        'message' => 'Attendance Successfull',
                  ],

                        REST_Controller::HTTP_OK);
                
                
            }

             else {
                $this->response([
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'Attendance Error.',
                    'sql_error' => [$db_error]
                    ],
                    REST_Controller::HTTP_NOT_FOUND);
            }
        

    }
    
    
    function verifyCheckout_get()
    {
        $uid = $this->input->get('user_id');
        $date=date("Y-m-d");
        $result=$this->db->get_where('tbl_attendance',array('user_id'=>$uid,'date'=>$date))->row();
        
        if($this->db->affected_rows()>0){
          if (!$result->status) {
                    $this->response([
                        'success' => true,
                        'status_code' => 200,
                        'message' => 'Checkout process can be done',
                        'code'  => 1,
                        //code == 1 : DO CHECK OUT
                  ], REST_Controller::HTTP_OK);
               
                
            } else {
                $this->response([
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'Already Checkout'],
                    REST_Controller::HTTP_NOT_FOUND);
            }
      }
      
      else
      
      {
            $this->response([
                        'success' => true,
                        'status_code' => 200,
                        'message' => 'Check in First',
                        'code' => 2,
                        //code == 2 : CHECK IN FIRST
            ], REST_Controller::HTTP_OK);
                
      }
          
      }
        
    function checkout_post(){
        
            $data['status']=1;
        
            //Where Condition
            $uid = $this->input->post('user_id');
            $date=date("Y-m-d");
            
            $data['checkout_verify']= $this->input->post('checkout_verify');
            $data['out_location'] = $this->input->post('out_location'); 
            $data['out_time'] = date("H:i:s");
            
            
            //Working hour interval Calculation
            $in_time= $this->db->get_where('tbl_attendance',array('user_id'=>$uid,'date'=>$date))->row();
            if($in_time){
            $get_work_hour=$this->gettime(strtotime($data['out_time']) - strtotime($in_time->in_time)); 
            $data['work_hour']="$get_work_hour[0]:$get_work_hour[1]:$get_work_hour[2]";
            
            
            // Over time and Down time Calculation
            $working_details=$this->db->get_where('tbl_working_hour',array('id'=>1))->row();
            $get_over_time=$this->gettime(strtotime($data['work_hour']) - strtotime($working_details->total_working_hour)); 
            
            if($get_over_time[0]>8){
                $data['over_time']="$get_over_time[0]:$get_over_time[1]:$get_over_time[2]";
            }
            
            else
            {
                $get_down_time=$this->gettime(strtotime($working_details->total_working_hour) - strtotime($data['work_hour'])); 
                $data['down_time']="$get_down_time[0]:$get_down_time[1]:$get_down_time[2]";
            }
            
            //early out
            
            $get_early_out=$this->gettime(strtotime($working_details->out_time) - strtotime($data['out_time'])); 
            if($get_early_out[0] > 0 )
            {
                $data['early_out_time']="$get_early_out[0]:$get_early_out[1]:$get_early_out[2]";
            }
        
          
    
            
            
            
            $this->db->where(array('date' => $date, 'user_id' => $uid));
            $this->db->update('tbl_attendance',$data);
            $no_of_affected_rows=$this->db->affected_rows();
             if ($no_of_affected_rows==1) {
                    $this->response([
                        'success' => true,
                        'status_code' => 200,
                        'message' => 'checkout',
                        
                  ],

                        REST_Controller::HTTP_OK);
               
                
            }
    
           

             else {
                $this->response([
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'Attendance Error.'],
                    REST_Controller::HTTP_NOT_FOUND);
            }
            }
            
            else
            {
                $this->response([
                            'success' => true,
                            'status_code' => 200,
                            'message' => 'notentry',],
                            REST_Controller::HTTP_NOT_FOUND);
            }
    }
    
      //Get time function
    function gettime ($total){
        $hours = intval($total / 3600);
        $seconds_remain = ($total - ($hours * 3600));
        $minutes = intval($seconds_remain / 60);

        $seconds = ($seconds_remain - ($minutes * 60));
        return array($hours,$minutes,$seconds);
    }
    
    function checkMac_get()
    {
        
             if ($data= $this->db->get('tbl_mac')->row()) {
                 
                    $this->response([
                        'success' => true,
                        'status_code' => 200,
                        'mac' => $data->mac,
                  ],

                        REST_Controller::HTTP_OK);
               
                
            }

             else {
                $this->response([
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'Attendance Error.'],
                    REST_Controller::HTTP_NOT_FOUND);
            }
    }
    
    
      function getTotalOverTime_get()
    {
        
       $emp_id=  $this->input->get('emp_id');
       $date=  $this->input->get('date');
       
       
    $this->db->select('*');
    $this->db->where('user_id', $emp_id);
    $this->db->like('date', $date);
    $data= $this->db->get('tbl_attendance')->result();
   
   $time="0";
   
   foreach($data as $d){
       $time +=$this->explode_time($d->over_time);
       
   }
   
    $total_over_time=$this->gettime($time);
$overtime =  $total_over_time[0] + $total_over_time[1]/60; 

 
   
   
   
   
     
             if ($data= $this->db->get('tbl_mac')->row()) {
                 
                    $this->response([
                        'success' => true,
                        'status_code' => 200,
                        'total_over_time' => $overtime,
                  ],

                        REST_Controller::HTTP_OK);
               
                
            }

             else {
                $this->response([
                    'success' => false,
                    'status_code' => 403,
                    'message' => 'Attendance Error.'],
                    REST_Controller::HTTP_NOT_FOUND);
            }
    }
    
    function explode_time($time) { //explode time and convert into seconds
        $time = explode(':', $time);
        $time = $time[0] * 3600 + $time[1] * 60;
        return $time;
}

function second_to_hhmm($time) { //convert seconds to hh:mm
        $hour = floor($time / 3600);
        $minute = strval(floor(($time % 3600) / 60));
        if ($minute == 0) {
            $minute = "00";
        } else {
            $minute = $minute;
        }
        $time = $hour . ":" . $minute;
        return $time;
}




}
?>