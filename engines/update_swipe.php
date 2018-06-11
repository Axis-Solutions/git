<?php
require '../db/dbapi.php';
	$seconds = $_POST['seconds'];
   

    
   // if($seconds==""){
     //   $seconds=$swipe_det[0]["seconds"];
   // }

   
    //$swipe_det = get_swipe_details($id);
    //$id = $swipe_det[0]["id"];
     
        
$edit_swipe_details = edit_swipe_details($seconds);
if($edit_swipe_details["status"]=="ok"){
    $rslt["msg"] = "Swipe countdown($seconds) has been successfully updated in the system";
    $rslt["log"]="ok";
}
else{
    $rslt["msg"] = "Failed to update swipe count details. No updates made or data changed.  Error: ".$edit_swipe_details["status"];
    $rslt["log"]="failed";
}



echo json_encode($rslt);