<?php

// Parameters
 $type = $_GET['type'];
 $CKEditor = 4;
 $funcNum = 5;
 $message = "Successfully";
// exit;
// Image upload
if($type == 'image'){

    $allowed_extension = array(
      "png","jpg","jpeg"
    );

    // Get image file extension
    $file_extension = pathinfo($_FILES["upload"]["name"], PATHINFO_EXTENSION);

    if(in_array(strtolower($file_extension),$allowed_extension)){
       
       if(move_uploaded_file($_FILES['upload']['tmp_name'], "uploads/".$_FILES['upload']['name'])){
        $url = "http://localhost/vcn/assets/ckeditor/uploads/".$_FILES['upload']['name'];
        // //   echo '<script>window.parent.CKEDITOR.tools.callFunction('.$funcNum.', "'.$url.'", "'.$message.'")</script>';
        
        // $returnStr = '<script type="text/javascript">';
        // $returnStr .= 'window.parent.CKEDITOR.tools.callFunction( ';
        // $returnStr .= $funcNum . ', ' . $url . ', ' . $message . ');</script>';
        // echo '<script>window.parent.CKEDITOR.tools.callFunction('.$funcNum.', "'.$url.'", "'.$message.'")</script>';


        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
    
    }

    }

    exit;
}

// File upload
if($type == 'file'){

    $allowed_extension = array(
       "doc","pdf","docx"
    );

    // Get image file extension
    $file_extension = pathinfo($_FILES["upload"]["name"], PATHINFO_EXTENSION);

    if(in_array(strtolower($file_extension),$allowed_extension)){

       if(move_uploaded_file($_FILES['upload']['tmp_name'], "uploads/".$_FILES['upload']['name'])){
          // File path
          if(isset($_SERVER['HTTPS'])){
              $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
          }
          else{
              $protocol = 'http';
          }

          $url = $protocol."://".'localhost' ."/assets/ckeditor/uploads/".$_FILES['upload']['name'];
         
          echo '<script>window.parent.CKEDITOR.tools.callFunction('.$funcNum.', "'.$url.'", "'.$message.'")</script>';
       }

    }

    exit;
}