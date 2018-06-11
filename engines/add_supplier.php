<?php
require '../db/dbapi.php';
$supplier_name = $_POST["supplier_name"];
$supplier_address = $_POST["supplier_address"];
$supplier_contact = $_POST["supplier_contact1"];

$sups = get_all_suppliers();
$nums = array();
$names = array();
foreach($sups as $data){
    $contacts = $data["supplier_contact1"];
    array_push($nums, $contacts);
    
    $name = $data["supplier_name"];
    array_push($names, $name);
    
}

if(!empty($supplier_name) && !empty($supplier_address) && !empty($supplier_contact))
{
if(in_array($supplier_contact, $nums) || in_array($supplier_name, $names)){
    $rslt["msg"] = "Supplier already exists in the system";
    $rslt["log"]="failed"; 
}
else{
$new_supplier = create_supplier($supplier_name,$supplier_address,$supplier_contact);
if($new_supplier["status"]=="ok"){
    $rslt["msg"] = "New supplier ($supplier_name) has been successfully added in the system";
    $rslt["log"]="ok";
}

else{
    $rslt["msg"] = "Failed to create supplier. Error: ".$new_supplier["status"];
    $rslt["log"]="failed";
}
}
}
else{
     $rslt["msg"] = "Supplier name, address , contact  not be empty";
    $rslt["log"]="failed";
}


echo json_encode($rslt);