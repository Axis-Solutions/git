<?php
require '../db/dbapi.php';
$code = $_POST["stockid"];
$name = $_POST["name"];
$qty = $_POST["qty"];
$tax_code = $_POST["tax_code"];
$cost_price = $_POST["cost"];
$selling_price = $_POST["sell"];
$category = $_POST["category"];
$expiry_date = $_POST["expiry_date"];
$uom = $_POST["UOM"];



if(!empty($code) && !empty($name) && !empty($tax_code) && !empty($cost_price) && !empty($selling_price) && !empty($category)  && !empty($uom))
{
    //check if code exists
    $codes = array();
    $prods = get_all_prods();
    foreach($prods as $prod){
        $cod2 = $prod["stock_id"];
        array_push($codes, $cod2);
    }
    if(in_array($code, $codes)){
      $rslt["msg"] = "Product with code $code already exist in the system. No duplicate codes required!";
    $rslt["log"]="failed";   
    }
    else{
    if($expiry_date==""){
    $expiry_date = date("Y-m-d H:i:s",strtotime("1970/01/01"));
    }else{
         $expiry_date = date("Y-m-d H:i:s",strtotime($expiry_date));
    }
$new_st = create_stock($code,$name,$qty,$tax_code,$cost_price,$selling_price,$category,$expiry_date,$uom);
if($new_st["status"]=="ok"){
    $rslt["msg"] = "New stock ($code) has been successfully added in the system";
    $rslt["log"]="ok";
}else{
    $rslt["msg"] = "Failed to create stock. Error: ".$new_st["status"];
    $rslt["log"]="failed";
}
}
}
else{
     $rslt["msg"] = "Product code, name, tax code, cost and selling price, category and product unit of measure can not be empty";
    $rslt["log"]="failed";
}

echo json_encode($rslt);