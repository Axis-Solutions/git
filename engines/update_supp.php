<?php
require '../db/dbapi.php';
$id = $_GET['myID'];
$supplier_name = $_POST["name"];
$supplier_address = $_POST["address"];
$supplier_contact = $_POST["contact1"];

$sups = get_suppliers_except_($id);
$nums = array();
foreach($sups as $data){
    $contacts = $data["supplier_contact1"];
    array_push($nums, $contacts);
    
}

if(!empty($supplier_name) && !empty($supplier_address) && !empty($supplier_contact))
{
if(in_array($supplier_contact, $nums)){
    $rslt["msg"] = "Phone number $supplier_contact already exists in the system";
    $rslt["log"]="failed"; 
}
else{           
$edit_sup = edit_supplier($supplier_name,$supplier_address,$supplier_contact,$id);
if($edit_sup["status"]=="ok"){
    $rslt["msg"] = " Supplier ($supplier_name) has been successfully edited in the system";
    $rslt["log"]="ok";
}

else{
    $rslt["msg"] = "Failed to edit supplier. Error: ".$edit_sup["status"];
    $rslt["log"]="failed";
}
}
}
else{
     $rslt["msg"] = "Supplier name, address , contact  not be empty";
    $rslt["log"]="failed";
}


echo json_encode($rslt);