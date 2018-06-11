<?php
require '../db/dbapi.php';

	$name = $_POST['name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $phone= $_POST['phone'];
    $email = $_POST['email'];
    $tax_condition = "VAT_REGISTERED";
    $vat = $_POST['vat'];
    $bpn = $_POST['bpn'];


    
    if($name==""){
        $name=$store_det[0]["name"];
    }
	if($address==""){
        $address=$store_det[0]["address"];
    }
	if($city==""){
        $city=$store_det[0]["city"];
    }
	if($phone==""){
        $phone=$store_det[0]["phone"];
    }
	if($email==""){
        $email=$store_det[0]["email"];
    }
	if($tax_condition==""){
        $tax_condition=$store_det[0]["tax_condition"];
    }
	if($vat==""){
        $vat=$store_det[0]["vat"];
    }
	if($bpn==""){
        $bpn=$store_det[0]["bpn"];
    }
   
    $det = get_store_details();
    $id = $det[0]["id"];
     
        
$edit_details = edit_store_details($name,$address,$city,$phone,$email,$tax_condition,$vat,$bpn,$id);
if($edit_details["status"]=="ok"){
    $rslt["msg"] = "Store($name) has been successfully updated in the system";
    $rslt["log"]="ok";
}
else{
    $rslt["msg"] = "Failed to edit store details. No updates made or data changed.  Error: ".$edit_details["status"];
    $rslt["log"]="failed";
}



echo json_encode($rslt);