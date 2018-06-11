<?php
require '../db/dbapi.php';
$products_array = $_POST["allproducts"]; // array of all products
$paymentMode = $_POST["payment_mode"];
$due_date = date("Y-m-d H:i:s", strtotime($_POST["due_date"]));
$grand_total = $_POST["grand_total"];
$discount_amnt = $_POST["discount_amount"];
$payable_amount = $_POST["payable_amount"];
$actual_payment = $_POST["amnt_paid"];
$oustanding_bal = $_POST["oustanding"];
//$rec_no = $_POST["receipt_NO"];
$transactionDate = date("Y-m-d H:i:s");
$type = "Receipt";
$status = "Sold";
$customer = $_POST["customer"];
$transClass = "Sale";
$contact = $_POST["contact"];


  $cop_det = get_co_details();
  echo $rec_no = substr($cop_det[0]["name"],0,3).date("YmdHis");
  

 

//check customer exists -  procedure not an issues to receipting though
$all_customers = get_all_customers();
$customers = array();
$customerMobiles = array();
foreach($all_customers as $cst){
    $custName = $cst["customer_name"];
    array_push($customers, $custName);
    
    $phone = $cst["customer_contact1"];
    array_push($customerMobiles, $phone);
}

if(in_array($contact, $customerMobiles))
{
    
}
else{
    $address = $_POST["address"];
    new_customer($customer,$address,$contact);
}

if($paymentMode=="cash")
{
    $oustanding_bal=0.00;
    
    
}elseif($paymentMode=="partly_cr"){
    $oustanding_bal = $payable_amount-$actual_payment;
            
}
elseif($paymentMode=="credit")
{
    $actual_payment==0.00;
}
// check if mode is set
// check if invoice number exists
$inv_array = array();
$sales = get_all_sales();
foreach($sales as $sale){
    $inv_num = $sale["Receipt_no"];
    array_push($inv_array, $inv_num);
}

if(in_array($rec_no, $inv_array))
{
     $rslt["msg"]="Invoice Number $rec_no already exists. ";
    $rslt["status"]="fail";
}
else{
    if($paymentMode==""){
    $rslt["msg"]="Please select payment type or mode.";
    $rslt["status"]="fail";
}
else{
    $taxArray = array();
    foreach($products_array as $Product){
         $stock_id = $Product["product_code"];
            $qty = $Product["qty"];
            $price = $Product["price"];
            $line_total = $Product["line_total"];
            $StkDet = get_prod_details($stock_id);
            $prodID = $StkDet[0]["id"];
            $stock_name = $StkDet[0]["stock_name"];
            $category = $StkDet[0]["category"];
            $tax_code = $StkDet[0]["Tax_Code"];
            if($tax_code == "A"){
                $tax = 0.15 * $line_total;
                array_push($taxArray, $tax);
            }
  $NewSale = create_sale($rec_no,$customer,$stock_id,$stock_name,$category,$tax_code,$price,$qty,$line_total,$grand_total,$discount_amnt,$payable_amount,$actual_payment,$oustanding_bal,$due_date,$paymentMode,$status);

 if($NewSale["status"]=="ok"){
 $stockLog = stock_log($stock_id,$qty,$transClass);
 // get quantity in stock first
 // now update final stock record for the products
 if($stockLog["status"]=="ok"){
        $desc = "Sale of $qty units for $stock_name";
     $stock_update = reduce_stock_held($stock_id,$qty);
  
    $audit_rep = create_prod_audit($desc, $prodID);
 }
 else{
  $rslt["msg"]="Could not upload stocks. ERROR : ".$stockLog["status"];
    $rslt["status"]="fail";      
 }
 
 }
   else{
     $rslt["msg"]="Upload failed. ERROR : ".$NewSale["status"];
    $rslt["status"]="fail";  
  }
  
    }
    
   
if($stock_update["status"]=="ok"){

if($paymentMode=="cash")
{
    $type_paymennt = "Payment";

    $set_trans_payment = set_transaction_debtor_age_data($customer,$rec_no,$type_paymennt,$transactionDate,$payable_amount,$transClass);
     $set_trans = set_transaction_debtor_age_data($customer,$rec_no,$type,$transactionDate,$payable_amount,$transClass);
    
    
}elseif($paymentMode=="partly_cr"){
     $type_paymennt = "Payment";

   $set_trans_receipt = set_transaction_debtor_age_data($customer,$rec_no,$type_paymennt,$transactionDate,$actual_payment,$transClass);
     $set_trans = set_transaction_debtor_age_data($customer,$rec_no,$type,$transactionDate,$payable_amount,$transClass);
            
}
elseif($paymentMode=="credit")
{
   $set_trans = set_transaction_debtor_age_data($customer,$rec_no,$type,$transactionDate,$payable_amount,$transClass);
}    
    
    

 
 
 
 if($set_trans["status"]=="ok"){
     $receipt = create_receipt_header($rec_no,$customer,$grand_total,$discount_amnt,$payable_amount,$actual_payment,$oustanding_bal,$paymentMode,$status);
     $sup_acc = update_debtor_balance($oustanding_bal,$customer);
    $rslt["msg"]="Sales for Receipt Number $rec_no has been successfully processed. Click <a href='add_sales_print.php?sid=$rec_no'>here</a> to print receipt.";
    $rslt["status"]="ok";
 }
  else{
      $rslt["msg"]="Sales failed. ERROR : ".$set_trans["status"];
    $rslt["status"]="fail";
  }
  }
  else{
     $rslt["msg"]="Stock Quantity log not set failed. ERROR : ".$stock_update["status"];
    $rslt["status"]="fail";  
  }
  
 
}
}



/******************8FP2000 RECEIPT********************/
if($rslt["status"]=="ok"){
    $storeDetails = get_co_details();
$bpn = $storeDetails[0]["bpn"];
$name = $storeDetails[0]["name"];
$VAT = $storeDetails[0]["vat"];
$addr = $storeDetails[0]["address"];
$store_contact = $storeDetails[0]["phone"];
$receipt_date = date("Ymd");
$start_time =  date("YmdHis");
$zita = $_SESSION["username"];
$invoice_num = $rec_no;
 $machnum = substr($invoice_num,5,16);
 
 $Inv_detail = get_trans_products($invoice_num);
 $payable_amnt = $Inv_detail[0]["payable_amount"];
 $tax_val =  array_sum($taxArray);
 $invqty = get_inv_qty($invoice_num);
 $ttlqty = $invqty[0]["ttl_qty"];
 $type = "sale";
    
    $zimra_XML = "<?xml version='1.0' encoding='utf-8'?>
    <ZimraSubmitInvoices xmlns='http://tempuri.org/'>
      <INVOICE xmlns='http://ZIMRA/FISC'>
        <BPN>$bpn</BPN>
        <CODE>$bpn</CODE>
        <MACNUM>$machnum</MACNUM>
        <DECSTARTDATE>$receipt_date</DECSTARTDATE>
        <DECENDDATE>$receipt_date</DECENDDATE>
        <DETSTARTDATE>$start_time</DETSTARTDATE>
        <DETENDDATE>$start_time</DETENDDATE>
        <CPY>$ttlqty</CPY>
        <IND>0</IND>
        <INVOICES>
          <RECORD>
            <ITYPE>$type</ITYPE>
            <ICODE>$machnum</ICODE>
            <INUM>$invoice_num</INUM>
            <IBPN>$bpn</IBPN>
            <INAME>$name</INAME>
            <ITAXCODE>$VAT</ITAXCODE>
            <VAT>$VAT</VAT>
            <IADDRESS>$addr</IADDRESS>
            <ICONTACT>$store_contact</ICONTACT>
            <ISHORTNAME>$zita</ISHORTNAME>
            <IPAYER>$customer</IPAYER>
            <IPVAT>$VAT</IPVAT>
            <IPADDRESS>$addr</IPADDRESS>
            <IPTEL>$store_contact</IPTEL>
            <IPBPN>ip$bpn</IPBPN>
            <IAMT>$payable_amnt</IAMT>
            <ITAX>$tax_val</ITAX>
            <ISTATUS>01</ISTATUS>
            <IISSUER>$zita</IISSUER>
            <IDATE>$receipt_date</IDATE>
            <ITAXCTRL>control</ITAXCTRL>
            <IOCODE>01</IOCODE>
            <IONUM>01</IONUM>
            <Lattitude>12012</Lattitude>
            <Longitude>-88812</Longitude>
            <IREMARK>An Invoice $invoice_num</IREMARK>
			<AMOUNTTENDERED>$actual_payment</AMOUNTTENDERED>
          <ITEMS>";
$i = 1;
foreach ($Inv_detail as $Product) {
        $stock_code = substr($Product["stock_id"],0,10);
        $stock_id = $Product["stock_id"];
        $qty = $Product["quantity"];
        $price = $Product["selling_price"];
        $line_total = $Product["payable_amount"];
        $StkDet = get_prod_details($stock_id);
        $stock_name = $StkDet[0]["stock_name"];
        $category = $StkDet[0]["category"];
        $tax_code = $StkDet[0]["Tax_Code"];
        if($tax_code=="A"){
         $line_tax = 0.15*$line_total;   
         $taxPerc = 0.15;
        }
        else{
            $line_tax = 0;
             $taxPerc = 0.0;
        }
        
	$zimra_XML.="<ITEM>
						<HH>$i</HH>
						<ITEMCODE>$stock_code</ITEMCODE>
						<ITEMNAME1>$stock_name</ITEMNAME1>
						<ITEMNAME2>$stock_name</ITEMNAME2>
						<QTY>$qty</QTY>
						<PRICE>$price</PRICE>
						<AMT>$line_total</AMT>
						<TAX>$line_tax</TAX>
						<TAXR>$taxPerc</TAXR>
					</ITEM>";
        $i++;
}
			$zimra_XML.="	</ITEMS>

          </RECORD>
        </INVOICES>
      </INVOICE>
    </ZimraSubmitInvoices>";
                        
                        
/*$myfile = fopen("C:/Receipts/receipt.txt", "w") or die("Unable to open file!");
fwrite($myfile, $zimra_XML);
fclose($myfile);
*/
$filename = "C:/Receipts/receipt.txt";
   file_put_contents($filename, $zimra_XML, FILE_APPEND | LOCK_EX);

/*
$ZimraXml = simplexml_load_string($zimra_XML) or die("Error: Cannot create object");

$ZimraXml->asXml('C:\Receipts\zimsend.xml');
*/
}

echo json_encode($rslt);
