<?php
require '../db/dbapi.php';
$products_array = $_POST["allproducts"]; // array of all products
$paymentMode = $_POST["payment_mode"];
$due_date = date("Y-m-d H:i:s", strtotime($_POST["due_date"]));
$total_cost = $_POST["grand_total"];
$actual_payment = $_POST["amnt_paid"];
$oustanding_bal = $_POST["oustanding"];
$REFID = $_POST["TransID"];
$transactionDate = date("Y-m-d H:i:s", strtotime($_POST["transDate"]));
$type = "Invoice";
$status = "Purchased";
$ult_supplier = $_POST["supplier"];
$transClass = "Purchase";
$sup_phone = $_POST["contact"];
//check if supplier exist
//
//check supplier exists -  procedure not an issues to receipting though
$all_suppliers = get_all_suppliers();
$suppliers = array();
$SupplierMobiles = array();
foreach($all_suppliers as $sup){
    $SupName = $sup["supplier_name"];
    array_push($suppliers, $SupName);
    
    $phone = $sup["supplier_contact1"];
    array_push($SupplierMobiles, $phone);
}

if(in_array($sup_phone, $SupplierMobiles))
{
    
}
else{
    $address = $_POST["address"];
    create_supplier($ult_supplier,$address,$sup_phone);
}





if($paymentMode=="cash")
{
    $oustanding_bal=0.00;
    
    
}elseif($paymentMode=="partly_cr"){
    $oustanding_bal = $total_cost-$actual_payment;
            
}
elseif($paymentMode=="credit")
{
    $actual_payment==0.00;
}
// check if mode is set
if($paymentMode==""){
    $rslt["msg"]="Please select payment type or mode.";
    $rslt["status"]="fail";
}
else{
    foreach($products_array as $Product){
         $stock_id = $Product["product_code"];
            $supplier = $Product["supplier"];
            $qty = $Product["stock_in_qty"];
            $opening_stock = $Product["avail"];
            $closing_stock = $opening_stock+$qty;
            $companyPrice = $Product["cost"];
            $sellingPrice = $Product["sell"];
            $line_total = $Product["line_total"];
            $StkDet = get_prod_details($stock_id);
             $prodID = $StkDet[0]["id"];
            $stock_name = $StkDet[0]["stock_name"];
            $category = $StkDet[0]["category"];
  $NewPurchase = create_purchase($stock_id,$stock_name,$supplier,$category,$qty,$opening_stock,$closing_stock,$companyPrice,$sellingPrice,$line_total,$paymentMode,$actual_payment,$oustanding_bal,$status,$due_date,$type,$REFID);
 if($NewPurchase["status"]=="ok"){
 $stockLog = stock_log($stock_id,$qty,$transClass);
 // now update final stock record for the products
 if($stockLog["status"]=="ok"){
     $desc = "Purchase of $qty units for $stock_name @ a cost of $companyPrice.";
     $stock_update = update_stock_held($stock_id,$qty);
      $audit_rep = create_prod_audit($desc, $prodID);
 }
 else{
  $rslt["msg"]="Could not upload stocks. ERROR : ".$stockLog["status"];
    $rslt["status"]="fail";      
 }
 
 }
   else{
     $rslt["msg"]="Upload failed. ERROR : ".$NewPurchase["status"];
    $rslt["status"]="fail";  
  }
  
    }
    
   
if($stock_update["status"]=="ok"){

if($paymentMode=="cash")
{
    $type_paymennt = "Payment";
    $set_trans_payment = set_transaction($ult_supplier,$REFID,$type_paymennt,$transactionDate,$total_cost,$transClass);
     $set_trans = set_transaction($ult_supplier,$REFID,$type,$transactionDate,$total_cost,$transClass);
    
    
}elseif($paymentMode=="partly_cr"){
     $type_paymennt = "Payment";
   $set_trans_payment = set_transaction($ult_supplier,$REFID,$type_paymennt,$transactionDate,$actual_payment,$transClass);
     $set_trans = set_transaction($ult_supplier,$REFID,$type,$transactionDate,$total_cost,$transClass);
            
}
elseif($paymentMode=="credit")
{
   $set_trans = set_transaction($ult_supplier,$REFID,$type,$transactionDate,$total_cost,$transClass);
}    
    
    

 
 
 
 if($set_trans["status"]=="ok"){
    $sup_acc = update_supplier_balance($oustanding_bal,$ult_supplier);
    $rslt["msg"]="New Stock has been added successfully. Check products set quantity in stock.";
    $rslt["status"]="ok";
 }
  else{
      $rslt["msg"]="Upload failed. ERROR : ".$set_trans["status"];
    $rslt["status"]="fail";
  }
  }
  else{
     $rslt["msg"]="Stock Qusntity log not set failed. ERROR : ".$stock_update["status"];
    $rslt["status"]="fail";  
  }
}

echo json_encode($rslt);




