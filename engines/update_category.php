<?php
require '../db/dbapi.php';
$id = $_GET["id"];
$category_name = $_POST["category_name"];
$category_description = $_POST["category_description"];
 $cat_det = get_category($id);

    
    if($category_name==""){
        $category_name=$cat_det[0]["category_name"];
    }
    
      if($category_description==""){
        $category_description=$cat_det[0]["category_description"];
    }
    
        
$edit_category = edit_category($category_name, $category_description, $id);
if($edit_category["status"]=="ok"){
    $rslt["msg"] = "Category ($category_name) has been successfully updated in the system";
    $rslt["log"]="ok";
}
else{
    $rslt["msg"] = "Failed to edit category. Error: ".$edit_category["status"];
    $rslt["log"]="failed";
}



echo json_encode($rslt);