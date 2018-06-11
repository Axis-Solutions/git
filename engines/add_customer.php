<?php
require '../db/dbapi.php';
$cust_name = $_POST["name"];
$cust_address = $_POST["address"];
$cust_contact = $_POST["contact"];

$sups = get_all_customers();
$nums = array();
$names = array();
foreach($sups as $data){
    $contacts = $data["customer_contact1"];
    $nam = $data["customer_name"];
    array_push($nums, $contacts);
    array_push($names, $nam);
    
}

if(!empty($cust_name) && !empty($cust_address) && !empty($cust_contact))
{
if(in_array($cust_contact, $nums)  ||  in_array($cust_name, $names)){
    $rslt["msg"] = "Customer already exists in the system";
    $rslt["log"]="failed"; 
}
else{
$new_customer = new_customer($cust_name,$cust_address,$cust_contact);
if($new_customer["status"]=="ok"){
    $rslt["msg"] = "New customer ($cust_name) has been successfully added in the system";
    $rslt["log"]="ok";
}

else{
    $rslt["msg"] = "Failed to create customer. Error: ".$new_customer["status"];
    $rslt["log"]="failed";
}
}
}
else{
     $rslt["msg"] = "Customer name, address , contact  not be empty";
    $rslt["log"]="failed";
}


echo json_encode($rslt);