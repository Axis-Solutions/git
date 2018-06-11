<?php
require '../db/dbapi.php';
$id = $_GET['myID'];
$customer_name = $_POST["name"];
$customer_address = $_POST["address"];
$customer_contact = $_POST["contact1"];

$sups = get_customers_except_($id);
$nums = array();
foreach($sups as $data){
    $contacts = $data["customer_contact1"];
    array_push($nums, $contacts);
    
}

if(!empty($customer_name) && !empty($customer_address) && !empty($customer_contact))
{
if(in_array($customer_contact, $nums)){
    $rslt["msg"] = "Phone number $customer_contact already exists in the system";
    $rslt["log"]="failed"; 
}
else{        
$edit_sup = edit_customer($customer_name,$customer_address,$customer_contact,$id);
if($edit_sup["status"]=="ok"){
    $rslt["msg"] = " Customer ($customer_name) has been successfully edited in the system";
    $rslt["log"]="ok";
}

else{
    $rslt["msg"] = "Failed to edit customer. Error: ".$edit_sup["status"];
    $rslt["log"]="failed";
}
}
}
else{
     $rslt["msg"] = "Supplier name, address , contact  not be empty";
    $rslt["log"]="failed";
}


echo json_encode($rslt);