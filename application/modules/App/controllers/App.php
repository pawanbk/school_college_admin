<?php defined('BASEPATH') OR exit('No direct script access allowed');

class App extends OAS_Controller{
  public $data = array();

  function __construct(){
    parent::__construct();
  }

  function index(){
    $this->data['main_title'] = "Dashboard Page";
    $this->data['title_small'] = "";
    $this->data['inner_template'] = 'Dashboard/DashboardViewPage';
    $this->load->view('Common/common', $this->data);
  }

  function _example_output($output = null ,$data){
    $final_output['data']=$data;
    $final_output['output']=(array)$output;
    $this->load->view('Common/common',$final_output);
  }

  function aboutUs(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "About Us";
      $data['title_small'] = "";
      $crud = new grocery_CRUD();

      $crud->set_table('about_us_master');

      $crud->set_field_upload('featured_image','uploads/about');

      $crud->columns(['title','description']);
      
      $crud->required_fields('title','description', 'featured_image');

      $output = $crud->render();
      $this->_example_output($output,$data);  
    }
  }

  function notices(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "Notice Management";
      $data['title_small'] = "Notices";
      $crud = new grocery_CRUD();

      $crud->set_table('notice');
      $crud->set_field_upload('featured_image','uploads/notice');
      $crud->columns(['title','featured_image','is_active']);
      $crud->required_fields('title','featured_image','is_active');
      $crud->display_as('is_active','Status');
      $crud->display_as('featured_image','Image');

      $output = $crud->render();
      $this->_example_output($output,$data);  
    }
  }

  function scholarship(){
    $data['main_title'] = "About Us";
    $data['title_small'] = "Scholarship";

    $crud = new grocery_CRUD();
    $crud->set_table('scholarship');
    $crud->set_field_upload('file','uploads/scholarship','pdf');
    $crud->columns(['name','file','is_active']);
    $crud->required_fields('name','file','is_active');
    $crud->display_as('is_active','Status');

    $output = $crud->render();
    $this->_example_output($output,$data); 
  } 

  function academicPartner(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "About Us";
      $data['title_small'] = "Academic Partners";

      $crud = new grocery_CRUD();
      $crud->set_table('academic_partner');
      $crud->set_field_upload('logo','uploads/partner');
      $crud->columns(['partner_name','logo']);
      $crud->required_fields('partner_name','logo');
      $crud->display_as('partner_name','Organisation');

      $output = $crud->render();
      $this->_example_output($output,$data);  
    }
  }

  function userManagement(){
    $data['main_title'] = "User";
    $data['title_small'] = "Management";
    $crud = new grocery_CRUD();
    
    $crud->set_table('user_auth');
    
    $crud->columns(['full_name','email','is_active']);
    $crud->required_fields('full_name','email','pass','is_active','is_locked_flag');
    $crud->callback_before_insert(array($this,'encrypt_password_callback'));
    $crud->callback_before_update(array($this, 'encrypt_password_callback'));

    $crud->display_as('pass','Password');
    
    $output = $crud->render();
    $this->_example_output($output,$data);  
  }
  
  function encrypt_password_callback($post_array) {
    $post_array['pass'] = md5($post_array['pass']);
    
    return $post_array;
  }  

  function faculty(){
    $data['main_title'] = "Faculty & Programs";
    $data['title_small'] = "Faculties";

    $crud = new grocery_CRUD();
    $crud->set_table('faculty');
    $crud->set_field_upload('featured_image','uploads/faculty');
    $crud->columns(['name','featured_image','is_active']);
    $crud->required_fields('name','email','featured_image','is_active');
    $crud->display_as('featured_image','Image');
    $output = $crud->render();
    $this->_example_output($output,$data);  
  }

  function programList(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "Faculty & Programs";
      $data['title_small'] = "Programs";

      $crud = new grocery_CRUD();
      $crud->set_table('programs');
      $crud->set_relation('faculty_id','faculty','name');
      $crud->set_field_upload('featured_image','uploads/program/images');
      $crud->columns(['featured_image','name', 'faculty_id']);
      $crud->required_fields(['name', 'featured_image', 'faculty_id']);
      $crud->display_as('featured_image', 'Image');
      $crud->display_as('faculty_id', 'Faculty');
      $output = $crud->render();
      $this->_example_output($output,$data);
    }
  }

  function programVideos(){
    $data['main_title'] = "Faculty & Programs";
    $data['title_small'] = "Program Videos";

    $crud = new grocery_CRUD();
    $crud->set_table('program_video');
    $crud->set_relation('program_id','programs','name');
    $crud->columns(['program_id','url','is_active']);
    $crud->required_fields(['program_id', 'url','is_active']);
    $crud->display_as('program_id', 'Program');
    $crud->display_as('is_active', 'Status');
    $output = $crud->render();
    $this->_example_output($output,$data);
  }

  function programLecturer(){
    $data['main_title'] = "Faculty & Programs";
    $data['title_small'] = "Assign Program Lecturer";

    $crud = new grocery_CRUD();
    $crud->set_table('program_lecturer');
    $crud->set_relation('lecturer_id','lecturers','full_name');
    $crud->set_relation('program_id','programs','name');
    $crud->required_fields(['program_id', 'lecturer_id']);
    $crud->display_as('lecturer_id', 'Lecturer');
    $crud->display_as('program_id', 'Program');
    $output = $crud->render();
    $this->_example_output($output,$data);
  }

  function eventCategoryList(){
    $data['main_title'] = "Category Management";
    $data['title_small'] = "";
    
    $crud = new grocery_CRUD();
    $crud->set_table('event_category');
    $crud->columns(['category_name']);
    $crud->required_fields('category_name');
    $output = $crud->render();
    $this->_example_output($output,$data);
  }

  function eventList(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "Event Management";
      $data['title_small'] = "";

      $crud = new grocery_CRUD();
      $crud->set_table('events');
      $crud->set_relation('event_category_id','event_category','category_name');
      $crud->set_field_upload('featured_image','uploads/event');
      $crud->columns(['featured_image','title', 'event_category_id']);
      $crud->required_fields(['title', 'featured_image', 'event_category_id']);
      $crud->display_as('featured', 'Image');
      $crud->display_as('event_category_id', 'Category');
      $output = $crud->render();
      $this->_example_output($output,$data);
    }
  }

  function researchList(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "Research Management";
      $data['title_small'] = "";

      $crud = new grocery_CRUD();
      $crud->set_table('research');
      $crud->set_field_upload('featured_image','uploads/research');
      $crud->columns(['featured_image','title']);
      $crud->required_fields(['title', 'featured_image']);
      $crud->display_as('featured_image', 'Image');
      $output = $crud->render();
      $this->_example_output($output,$data);
    }
  }

  function sliderList(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "Slider Management";
      $data['title_small'] = "";

      $crud = new grocery_CRUD();
      $crud->set_table('slider');
      $crud->set_field_upload('featured_image','uploads/slider');
      $crud->columns(['featured_image','title']);
      $crud->required_fields(['title', 'featured_image','link','description']);
      $crud->display_as('featured_image', 'Image');
      $output = $crud->render();
      $this->_example_output($output,$data);
    }
  }

  function enquiries(){
      $data['main_title'] = "Enquiry Management";
      $data['title_small'] = "";

      $crud = new grocery_CRUD();
      $crud->set_table('admission');
      $crud->set_relation('program_id','programs','name');
      $crud->set_relation('faculty_id','faculty','name');
      $crud->columns(['name','contact','email','faculty_id','program_id']);
      $crud->display_as('faculty_id', 'Faculty');
      $crud->display_as('program_id', 'Program');
      $crud->unset_add();
      $crud->unset_edit();
      $output = $crud->render();
      $this->_example_output($output,$data);
  }

  function students(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "User Management";
      $data['title_small'] = "Student Lists";

      $crud = new grocery_CRUD();
      $crud->set_table('students');
      $crud->set_field_upload('featured_image','uploads/student');
      $crud->columns(['student_id','featured_image','full_name','email_address','phone_number']);
      $crud->required_fields(['full_name','email_address','phone_number']);
      $crud->display_as('featured_image', 'Image');
      $crud->display_as('email_address', 'Email');
      $crud->display_as('phone_number', 'Phone');
      $output = $crud->render();
      $this->_example_output($output,$data);
    }
  }

  function lecturers(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "User Management";
      $data['title_small'] = "Lecturer Lists";

      $crud = new grocery_CRUD();
      $crud->set_table('lecturers');
      $crud->set_field_upload('featured_image','uploads/lecturer');
      $crud->columns(['lecturer_id','featured_image','full_name','email_address','phone_number']);
      $crud->required_fields(['full_name','email_address','phone_number','qualification']);
      $crud->display_as('featured_image', 'Image');
      $crud->display_as('email_address', 'Email');
      $crud->display_as('phone_number', 'Phone');
      $output = $crud->render();
      $this->_example_output($output,$data);
    }
  }

  function counselors(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "Counselor Management";
      $data['title_small'] = "Counselor List";

      $crud = new grocery_CRUD();
      $crud->set_table('counsellors');
      $crud->set_field_upload('featured_image','uploads/counsellor');
      $crud->columns(['featured_image','name','designation','contact']);
      $crud->required_fields(['name','contact','designation']);
      $crud->display_as('featured_image', 'Image');
      $output = $crud->render();
      $this->_example_output($output,$data);
    }
  }
  
  function admissionInfo(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "About Us";
      $data['title_small'] = "Admission Info";

      $crud = new grocery_CRUD();
      $crud->set_table('admission_info');
      $crud->set_field_upload('featured_image','uploads/admission');
      $crud->columns(['featured_image','description']);
      $crud->required_fields(['featured_image','description']);
      $crud->display_as('featured_image', 'Image');
      $output = $crud->render();
      $this->_example_output($output,$data);
    }
  }

  function certificates(){
      $data['main_title'] = "About Us";
      $data['title_small'] = "Certificates";

      $crud = new grocery_CRUD();
      $crud->set_table('certificates');
      $crud->set_field_upload('featured_image','uploads/certificate');
      $crud->columns(['featured_image','name','is_active']);
      $crud->required_fields(['featured_image','name','is_active']);
      $crud->display_as('featured_image', 'Image');
      $crud->display_as('is_active', 'Status');
      $output = $crud->render();
      $this->_example_output($output,$data);
  }

  function siteSetting(){
    $data['main_title'] = "Site Management";
    $data['title_small'] = "";
    
    $crud = new grocery_CRUD();
    
    $crud->set_table('site_setting');
    $crud->set_field_upload('site_logo','uploads/site');
    $crud->set_field_upload('fav_icon','uploads/site');
    $crud->set_field_upload('welcome_image','uploads/site');
    $crud->unset_back_to_list();

    $crud->set_rules('email_address','Email Address','valid_email');
    $crud->set_rules('phone_number','Contact Number','numeric|exact_length[10]');
    $crud->required_fields('site_logo','welcome_img', 'fav_icon ', 'site_name', 'phone_number', 'email_address', 'address');
    $output = $crud->render();
    $this->_example_output($output,$data);
  }

  function emailConfig() {
    $data['main_title'] = "Email Configuration Management";
    $data['title_small'] = "";
    
    $crud = new grocery_CRUD();
    $crud->set_table('email_config_setting');

    $crud->set_rules('email_from','Mail From','valid_email');
    $crud->set_rules('username','Username');
    $crud->required_fields(['host_name','port','username','password','email_from']);
    $crud->unset_back_to_list();
    $output = $crud->render();
    $this->_example_output($output,$data);  
  }

  function mailList(){
    $data['main_title'] = "Mail Management";
    $data['title_small'] = "";
    $crud = new grocery_CRUD();
    $crud->set_table('mails');
    $crud->unset_add();
    $crud->unset_edit();
    $crud->display_as('sender_full_name', 'Sender Name');
    $crud->display_as('sender_email_address', 'Sender email');
    $output = $crud->render();
    $this->_example_output($output,$data);  
  }

  function socialSite(){
    $data['main_title'] = "Social Site Management";
    $data['title_small'] = "";
    
    $crud = new grocery_CRUD();
    $crud->set_table('site_social_link');

    $crud->required_fields('link_icon', 'social_link');
    $crud->display_as('social_link','Link');
    $crud->display_as('link_icon','Icon');
    $output = $crud->render();
    $this->_example_output($output,$data);  
  }
  

  function testimonialList(){
    $data['main_title'] = "Testimonial Management";
    $data['title_small'] = "";

    $crud = new grocery_CRUD();
    $crud->set_table('testimonials');
    $crud->columns(['name','featured_image','description']);
    $crud->set_field_upload('featured_image','uploads/testinomials');
    $crud->display_as('featured_image', 'Image');
    $crud->display_as('description','Comment');
    
    //$crud->unset_add();
    // $crud->unset_edit();
    $output = $crud->render();
    $this->_example_output($output,$data);
  }


  function upload(){
    $CKEditor = $_GET['CKEditor'];
    $funcNum = $_GET['CKEditorFuncNum'];
    $url_image = FCPATH.'uploads/media/'; 
    
    $allowed_extension = array(
      "png","jpg","jpeg", "JPG", "JPEG"
    );
    
    $file_extension = pathinfo($_FILES["upload"]["name"], PATHINFO_EXTENSION);
    
    if(in_array(strtolower($file_extension),$allowed_extension)){
      $filename = $_FILES["upload"]["name"];
      $file_basename = substr($filename, 0, strripos($filename, '.'));
      $file_ext = substr($filename, strripos($filename, '.')); 
      $newfilename = $file_basename.time(). $file_ext;

      if(move_uploaded_file($_FILES['upload']['tmp_name'], $url_image.$newfilename)){

        if(isset($_SERVER['HTTPS'])){
          $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        }
        else{
          $protocol = 'http';
        }

        $url = base_url('uploads/media/').$newfilename;
        $data['url'] = $newfilename;

        $this->db->insert('media_gallery',$data);
        echo '<script>window.parent.CKEDITOR.tools.callFunction('.$funcNum.', "'.$url.'", "'.$message.'")</script>';
      }
      exit;
    }

  }

}



?>