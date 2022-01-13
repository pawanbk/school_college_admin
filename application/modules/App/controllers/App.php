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

  function _example_output($output = null,$data){
    $final_output['data']=$data;
    $final_output['output']=(array)$output;
    $this->load->view('Common/common',$final_output);
  }

  function aboutUs(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "About Us Only asdf";
      $data['title_small'] = "";
      $crud = new grocery_CRUD();

      $crud->set_table('tbl_about_us_master');

      $crud->set_field_upload('featured_image','uploads/about');

      $crud->columns(['title','description']);
      
      $crud->required_fields('title','description', 'featured_image');

      $output = $crud->render();
      $this->_example_output($output,$data);  
    }
  }

  function academicPartner(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "Academic Partners";
      $data['title_small'] = "";
      $crud = new grocery_CRUD();

      $crud->set_table('tbl_academic_partner');

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
    
    $crud->set_table('tbl_user_auth');
    
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

  function courseCategoryList(){
    $data['main_title'] = "Category Management";
    $data['title_small'] = "";
    
    $crud = new grocery_CRUD();
    
    $crud->set_table('tbl_course_category');
    
    $crud->columns(['category_name']);
    
    $crud->required_fields('category_name');
    $output = $crud->render();
    $this->_example_output($output,$data);
  }

  function courseList(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "Course Management";
      $data['title_small'] = "";

      $crud = new grocery_CRUD();
      $crud->set_table('tbl_courses');
      $crud->set_relation('course_category_id','tbl_course_category','category_name');
      $crud->set_field_upload('featured_image','uploads/course');

      $crud->columns(['featured_image','name', 'seats_available','total_classes','course_category_id']);
      $crud->required_fields(['name', 'featured_image', 'course_category_id']);
      $crud->display_as('featured', 'Image');
      $crud->display_as('course_category_id', 'Category');
      $output = $crud->render();
      $this->_example_output($output,$data);
    }
  }

  function eventCategoryList(){
    $data['main_title'] = "Category Management";
    $data['title_small'] = "";
    
    $crud = new grocery_CRUD();
    $crud->set_table('tbl_event_category');
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
      $crud->set_table('tbl_events');
      $crud->set_relation('event_category_id','tbl_event_category','category_name');
      $crud->set_field_upload('featured_image','uploads/event');
      $crud->columns(['featured_image','title', 'event_category_id']);
      $crud->required_fields(['title', 'featured_image', 'event_category_id']);
      $crud->display_as('featured', 'Image');
      $crud->display_as('event_category_id', 'Category');
      $output = $crud->render();
      $this->_example_output($output,$data);
    }
  }

  function newsCategoryList(){
    $data['main_title'] = "News Category Management";
    $data['title_small'] = "";
    
    $crud = new grocery_CRUD();
    $crud->set_table('tbl_news_category');
    $crud->columns(['category_name']);
    $crud->required_fields('category_name');
    $output = $crud->render();
    $this->_example_output($output,$data);
  }

  function news(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "News Management";
      $data['title_small'] = "";

      $crud = new grocery_CRUD();
      $crud->set_table('tbl_news');
      $crud->set_relation('news_category_id','tbl_news_category','category_name');
      $crud->set_field_upload('featured_image','uploads/news');
      $crud->columns(['featured_image','title', 'news_category_id','published_date']);
      $crud->required_fields(['title', 'featured_image', 'news_category_id','published_date']);
      $crud->display_as('featured_image', 'Image');
      $crud->display_as('news_category_id', 'Category');
      $crud->display_as('published_date', 'Published on');
      $output = $crud->render();
      $this->_example_output($output,$data);
    }
  }

  function reseachCategoryList(){
    $data['main_title'] = "Research Category Management";
    $data['title_small'] = "";
    
    $crud = new grocery_CRUD();
    $crud->set_table('tbl_research_category');
    $crud->columns(['title']);
    $crud->required_fields('title');
    $output = $crud->render();
    $this->_example_output($output,$data);
  }

  function researchList(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "Research Management";
      $data['title_small'] = "";

      $crud = new grocery_CRUD();
      $crud->set_table('tbl_research');
      $crud->set_relation('research_category_id','tbl_research_category','title');
      $crud->set_field_upload('featured_image','uploads/research');
      $crud->columns(['featured_image','title', 'research_category_id']);
      $crud->required_fields(['title', 'featured_image', 'research_category_id','published_date']);
      $crud->display_as('featured_image', 'Image');
      $crud->display_as('research_category_id', 'Category');
      $output = $crud->render();
      $this->_example_output($output,$data);
    }
  }

  function bannerList(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "Banner Management";
      $data['title_small'] = "";

      $crud = new grocery_CRUD();
      $crud->set_table('tbl_site_banner');
      $crud->set_field_upload('featured_image','uploads/banner');
      $crud->columns(['featured_image','banner_title']);
      $crud->required_fields(['banner_title', 'featured_image']);
      $crud->display_as('featured_image', 'Image');
      $crud->display_as('banner_title', 'Title');
      $output = $crud->render();
      $this->_example_output($output,$data);
    }
  }

  function students(){
    if($this->uri->segment(3)=="upload" || $this->uri->segment(4)=="upload"){
      $this->upload();
    }
    else{
      $data['main_title'] = "User Management";
      $data['title_small'] = "Student Lists";

      $crud = new grocery_CRUD();
      $crud->set_table('tbl_students');
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
      $crud->set_table('tbl_lecturers');
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

  function lecturerSocialLinks(){
    $data['main_title'] = "Lecturer Social Link";
    $data['title_small'] = "";

    $crud = new grocery_CRUD();
    $crud->set_table('tbl_lecturer_social_link');
    $crud->set_relation('lecturer_id','tbl_lecturers','full_name');
    $crud->required_fields(['link_icon','social_link','lecturer_id']);
    $crud->display_as('lecturer_id', 'Lecturer');
    $output = $crud->render();
    $this->_example_output($output,$data);
  }
  function courseLecturer(){
    $data['main_title'] = "Assign Lecturer";
    $data['title_small'] = "";

    $crud = new grocery_CRUD();
    $crud->set_table('tbl_course_lecturer');
    $crud->set_relation('lecturer_id','tbl_lecturers','full_name');
    $crud->set_relation('course_id','tbl_courses','name');
    $crud->required_fields(['course_id', 'lecturer_id']);
    $crud->display_as('lecturer_id', 'Lecturer');
    $crud->display_as('course_id', 'Course');
    $output = $crud->render();
    $this->_example_output($output,$data);
  }

  function siteSetting(){
    $data['main_title'] = "Site Management";
    $data['title_small'] = "";
    
    $crud = new grocery_CRUD();
    
    $crud->set_table('tbl_site_setting');
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
    $crud->set_table('tbl_email_config_setting');

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
    $crud->set_table('tbl_mails');
    $crud->unset_add();
    $crud->unset_edit();
    $crud->display_as('sender_full_name', 'Sender Name');
    $crud->display_as('sender_email_address', 'Sender email');
    $output = $crud->render();
    $this->_example_output($output,$data);  
  }

  function slider(){
    $data['main_title'] = "Slider Management";
    $data['title_small'] = "";

    $crud = new grocery_CRUD();
    $crud->set_table('slider');

    $crud->set_field_upload('slider_image','uploads/slider');

    $crud->columns(['title', 'slider_image']);
    $crud->required_fields('slider_image', 'title');

    $crud->display_as('slider_image','Image');

    $output = $crud->render();
    $this->_example_output($output,$data);  
  }
  
  function socialSite(){
    $data['main_title'] = "Social Site Management";
    $data['title_small'] = "";
    
    $crud = new grocery_CRUD();
    $crud->set_table('tbl_site_social_link');

    $crud->required_fields('link_icon', 'social_link');
    $crud->display_as('social_link','Link');
    $crud->display_as('link_icon','Icon');
    $output = $crud->render();
    $this->_example_output($output,$data);  
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
      $crud->set_field_upload('slider_image','uploads/slider');

      $crud->columns(['slider_image','title', 'position',]);
      $crud->required_fields(['title', 'slider_image', 'position']);

      $crud->display_as('slider_image', 'Image');
     

      $output = $crud->render();
      $this->_example_output($output,$data);
    }
  }

  function gallery(){
    $data['main_title'] = "Gallery Management";
    $data['title_small'] = "";
    
    $this->load->library('Image_CRUD');
    $image_crud = new Image_CRUD();
    
    $image_crud->set_primary_key_field('gallery_id');
    $image_crud->set_url_field('featured_image');
    
    $image_crud->set_table('tbl_gallery_master')
    ->set_ordering_field('priority')
    ->set_title_field('title')
    ->set_image_path('uploads/gallery');
    
    $output = $image_crud->render();
    $this->_example_output($output,$data);
  }

  function testimonialList(){
    $data['main_title'] = "Testimonial Management";
    $data['title_small'] = "";

    $crud = new grocery_CRUD();
    $crud->set_table('tbl_testimonials');
    $crud->columns(['name','featured_image','description']);
    $crud->set_field_upload('featured_image','uploads/testinomials');
    $crud->display_as('featured_image', 'Image');
    $crud->display_as('description','Comment');
    
    //$crud->unset_add();
    $crud->unset_edit();
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