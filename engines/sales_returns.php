<?php
require '../db/dbapi.php';

$rec_no = $_POST["rec_no"];
$canc_rsn = $_POST["cancelation_reason"];
$canc_type = $_POST["cancel_type"];
$fin_canc_reason = $canc_type." - ".$canc_rsn;

       



$get_prod = get_trans_products($rec_no);
//$payment_type = $get_prod[0]["payment_mode"];
$payable_amount = $get_prod[0]["payable_amount"];
$custName = $get_prod[0]["customer"];
$transDate = $get_prod[0]["CreatedDate"]; 
foreach($get_prod as $prod){
    $prodCode = $prod["stock_id"];
    $Qty = $prod["quantity"];
    
    if($canc_type=="CRN")
{
    // stocks cant be used again - 
        $type = "Returns Inwards - Obsolete";
     $stocklog = stock_log($prodCode,$Qty,$type);
     $stock_held["status"]="ok";
}
else{
    //stocks can be used again
    $type = "Returns Inwards - Valid";
  $stock_held = update_stock_held($prodCode,$Qty); //inside for
   $stocklog = stock_log($prodCode,$Qty,$type);
}

}

if($stock_held["status"]=="ok" && $stocklog["status"]=="ok")
{
    $transClass = "Return";
    $status = "return";
   $update_sales_items = update_salesitems_on_return($status,$rec_no);
    $update_header = update_salesheader_on_return($status,$fin_canc_reason,$rec_no);
    $reduce_bal = reduce_debtor_bal($payable_amount,$custName); //outside for
    $trans_debt = set_transaction_debtor_age_data($custName,$rec_no,$canc_type,$transDate,$payable_amount,$transClass); //outside for 

    if($update_sales_items["status"]=="ok" && $update_header["status"]=="ok" && $reduce_bal["status"]=="ok" &&  $trans_debt["status"]=="ok")
        {
          $rslt["msg"] = "All updates successfully done.";
    $rslt["log"]="ok";
    }
    else
    {
         $rslt["msg"] = "Sales items update error: ".$update_sales_items["status"].", Header update error: ".$update_header["status"].", Debtor reduction balance error: ".$reduce_bal." And transaction debtor age data error: ".$trans_debt["status"];
    $rslt["log"]="fail";
    }
    
    
    
}

else{
    $rslt["msg"] = "Stock held error: ".$stock_held["status"]." and stock log error: ".$stocklog["status"];
    $rslt["log"]="fail";
}



echo json_encode($rslt);