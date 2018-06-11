<?php 
require '../db/dbapi.php';

    $storeDetails = get_co_details();
$bpn = $storeDetails[0]["bpn"];
$name = $storeDetails[0]["name"];
$VAT = $storeDetails[0]["vat"];
$addr = $storeDetails[0]["address"];
$store_contact = $storeDetails[0]["phone"];
$receipt_date = date("Ymd");
$start_time =  date("YmdHis");
$zita = $_SESSION["username"];
 $machnum = substr($invoice_num,5,16);
 
 $Inv_detail = get_trans_products($invoice_num);
 $payable_amnt = $Inv_detail[0]["payable_amount"];
 $tax_val = 0.15*$payable_amnt;
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
        $line_tax = 0.15*$line_total;
	$zimra_XML.="<ITEM>
						<HH>$i</HH>
						<ITEMCODE>$stock_code</ITEMCODE>
						<ITEMNAME1>$stock_name</ITEMNAME1>
						<ITEMNAME2>$stock_name</ITEMNAME2>
						<QTY>$qty</QTY>
						<PRICE>$price</PRICE>
						<AMT>$line_total</AMT>
						<TAX>1.2</TAX>
						<TAXR>$tax_code</TAXR>
					</ITEM>";
        $i++;
}
			$zimra_XML.="	</ITEMS>

          </RECORD>
        </INVOICES>
      </INVOICE>
    </ZimraSubmitInvoices>";

$ZimraXml = simplexml_load_string($zimra_XML) or die("Error: Cannot create object");

$ZimraXml->asXml('C:\Receipts\zimsend.xml');

    $rslt["msg"]="Receipt created successfully and signature has been appended on the receipt. Click <a href='add_sales_print.php?sid=$invoice_num'>here</a> to print receipt.";
$rslt["status"]="ok";



echo json_encode($rslt);