<?php
require '../db/dbapi.php';
$code = $_POST["stockid"];
$name = $_POST["name"];

$tax_code = $_POST["tax_code"];
$cost_price = $_POST["cost"];
$selling_price = $_POST["sell"];
$category = $_POST["category"];
$expiry_date = $_POST["expiry_date"];
$uom = $_POST["UOM"];
$SID = $_GET["id"];
 $prod_det = get_prod_details($SID);
if(!empty($code) && !empty($name) && !empty($cost_price) && !empty($selling_price))
{
    //check if code exists
    $codes = array();
    $prods =  get_all_prods_excl_this($SID);
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
    $expiry_date =  $prod_det[0]["expire_date"];
   
    }else{
         $expiry_date = date("Y-m-d H:i:s",strtotime($expiry_date));
    }
    
    if($tax_code==""){
        $tax_code=$prod_det[0]["Tax_Code"];
    }
    
      if($category==""){
        $category=$prod_det[0]["category"];
    }
    
       if($uom==""){
        $category=$prod_det[0]["uom"];
    }
    
          
$edit_st = edit_stock($code,$name,$tax_code,$cost_price,$selling_price,$category,$expiry_date,$uom,$SID);
if($edit_st["status"]=="ok"){
    $rslt["msg"] = "Product ($name) has been successfully updated in the system";
    $rslt["log"]="ok";
}else{
    $rslt["msg"] = "Failed to edit stock. No updates done. Error: ".$edit_st["status"];
    $rslt["log"]="failed";
}
}
}else{
     $rslt["msg"] = "Product code, name, tax code, cost and selling price, category and product unit of measure can not be empty";
    $rslt["log"]="failed";
}


echo json_encode($rslt);