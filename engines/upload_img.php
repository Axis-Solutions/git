<?php
require '../db/dbapi.php';

  $target_dir = "../upload/";

@$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
$act_file = basename($_FILES["fileToUpload"]["name"]);


$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  
// Check if image file is a actual image or fake image

     $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
     
    
    // Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "JPG" && $imageFileType != "GIF") {
    $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
     $picture_path = $error;
    $uploadOk = 0;
}

 elseif (file_exists($target_file)) {
    $error = "Sorry, file already exists.";
     $picture_path = $target_file ;
    $uploadOk = 0;
}

 // Check file size
elseif ($_FILES["fileToUpload"]["size"] > 5120000) {
    $error = "Sorry, your file is too large.";
     $picture_path = $target_file ;
    $uploadOk = 0;
}
elseif($check == false) {
        $error = "File is not an image.";
         $picture_path = $target_file ;
        $uploadOk = 0;
    }
   
    else {
        
    
    // Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $error = "Sorry, your file was not uploaded.";
    $picture_path = $target_file ;
// if everything is ok, try to upload file
} else {
     
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $picture_path = $target_file;
     
       
    } else {
       $picture_path =  "NULL";
    }
}
   
}
$str = get_store_details();
$id = $str[0]["id"];
$customer_image = update_store_logo($act_file,$id);
  
    if ($customer_image['status'] == 'ok') {
       $result['log']='ok'; 
        $result['msg'] = 'Image Upload successfully';
    } else {
        $result['msg'] = 'Image failed to upload. Please consult developer for rectification. ERROR: '.$customer_image['status'];
        $result['log']='fail';
    }

    echo json_encode($result);