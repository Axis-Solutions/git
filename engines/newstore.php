<?php
require '../db/dbapi.php';


$name = $_POST["name"];
$address = $_POST["address"];
$city = $_POST["city"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$tax_condition = "VAT_REGISTERED";
$vat = $_POST["vat"];
$bpn = $_POST["bpn"];

if(empty($name) || empty($address)|| empty($phone))
{
    $rslt["msg"] = "Name, address and phone can not be empty.";
    $rslt["status"]="fail";
}
else{
    
$newstore = create_store($name,$address,$city,$phone,$email,$tax_condition,$vat,$bpn);
if($newstore["status"]=="ok")
{
 $rslt["msg"] = "Store details have been successfully uploaded.";
    $rslt["status"]="ok";
}
else{
    $rslt["msg"] = "Failed to upload details. ERROR: ".$newstore["status"];
    $rslt["status"]="fail";
}
}


echo json_encode($rslt);