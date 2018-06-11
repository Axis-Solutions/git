<?php
include_once("userinit.php");  // Use session variable on this page. This function must put on the top of page.
if(!isset($_SESSION['username'])){ // if session variable "username" does not exist.
    header("location: index.php?msg=Please%20login%20to%20access%20admin%20area%20!"); // Re-direct to index.php
}
else
{


if(isset($_GET['sid']))
{

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Sales Print</title>
    <style type="text/css" media="print">
        .hide {
            display: none
        }

    </style>
    <script type="text/javascript">
        function printpage() {
            document.getElementById('printButton').style.visibility = "hidden";
            window.print();
            document.getElementById('printButton').style.visibility = "visible";
        }
    </script>
    <style type="text/css">
        <!--
        .style1 {
            font-size: 10px
        }

        -->
    </style>
     <?php include_once("tpl/common_js.php"); ?>
    <script>
        $(document).ready(function(){
           jQuery(document).bind('keydown', 'return',function() {
			  window.close();
	    }); 
        });
     </script>
</head>

    <body onload="window.print();">
    <input name="print" type="button" class="hide" value="Print" id="printButton" onClick="printpage()">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center" valign="top">

            <table width="595" cellspacing="0" cellpadding="0" id="bordertable" border="1">
                <tr>
                    <td align="center"><strong>Sales Receipt <br/>
                        </strong>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="67%" align="left" valign="top">&nbsp;&nbsp;&nbsp;Date: <?php
                                    $sid = $_GET['sid'];
                                    $line = $db_sec->queryUniqueObject("SELECT * FROM stock_sales WHERE rec_no='$sid' ");

                                    $mysqldate = $line->CreatedDate;

                                    $phpdate = strtotime($mysqldate);

                                    $phpdate = date("d/m/Y", $phpdate);
                                    echo $phpdate;
                                    ?> <br/>
                                    <br/>
                                    <strong><br/>
                                        &nbsp;&nbsp;&nbsp;Receipt No: <?php echo $sid;

                                        ?> </strong><br/></td>
                                <td width="33%">
                                     <div align="right">
                         <img style="height:150px;width:150px;" src="<?php if (isset($_SESSION['logo'])) {
                echo "upload/" . $_SESSION['logo'];
            } else {
                echo "upload/posnic.png";
                } ?>" alt="Point of Sale"/><br><br>
                        <?php $line4 = $db_sec->queryUniqueObject("SELECT * FROM store_details ");
                         $sig = $db_sec->queryUniqueObject("SELECT * FROM receipt_header_info where Receipt_no='$sid' ");
                        ?>
                       
                        <strong><?php echo $line4->name; ?></strong><br/>
                        <?php echo $line4->address; ?><br/>
                        <?php echo $line4->city; ?><br/>
                       <br>Email<strong>:  <?php echo $line4->email; ?></strong><br/>Phone
                        <strong>:<?php echo $line4->phone; ?></strong>
                        <br/><br>
                        VAT NO: <strong>:<?php echo $line4->vat; ?><br></strong>
                             BPN: <strong>:<?php echo $line4->bpn; ?></strong>
                                 
                             
                       
                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="90" align="left" valign="top"><br/>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                           
                            <tr>
                                <td width="5%" align="left" valign="top"><strong>&nbsp;&nbsp;TO:</strong></td>
                                <td width="95%" align="left" valign="top"><br/>
                                    <?php
                                    echo "Customer: ".$line->customer."<br>";
                                    $cname = $line->customer;

                                    $line2 = $db_sec->queryUniqueObject("SELECT * FROM customer_details WHERE customer_name='$cname' ");
                                       if(empty($line2)){
                                           echo "Address: No Address<br>"; 
                                           echo "Contact: No Cell Number";
                                       }else{
                                    echo "Address: ".$line2->customer_address;
                                    
                                    ?>
                                    <br/>
                                    <?php
                                    
                                    echo "Contact: " . $line2->customer_contact1 . "<br>";
                                    
                                       }

                                    ?></td>
                            </tr>
                                   
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                               
                                <td width="35%" bgcolor="#CCCCCC"><strong>Stock</strong></td>
                                <td width="18%" bgcolor="#CCCCCC"><strong>Quantity</strong></td>
                                <td width="19%" bgcolor="#CCCCCC"><strong>Price</strong></td>
                                <td width="9%" bgcolor="#CCCCCC"><strong>Tax</strong></td>
                               
                                <td width="18%" align="center" bgcolor="#CCCCCC"><strong>Total</strong></td>
                            </tr>

                            <tr>
                                <td align="center">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                
                            </tr>
                            <?php
                            $i = 1;
                            $db_sec->query("SELECT * FROM stock_sales where rec_no='$sid'");
                            $total_tax = 0;
                            while ($line3 = $db_sec->fetchNextObject()) {
                                $taxCode =  $line3->Tax_Code;
                                if($taxCode == "A")
                                {
                                    $perc = "15.00%";
                                    $taxCredit = 0.15 * $line3->subtotal;
                                }
                                else{
                                   $perc = "0.00%"; 
                                   $taxCredit = 0;
                                }
                                $total_tax = $total_tax + $taxCredit;
                                ?>
                                <tr>
                                   
                                    <td><?php echo $line3->stock_name; ?></td>
                                    <td><?php echo $line3->quantity; ?></td>
                                    <td><?php echo $line3->selling_price; ?></td>
                                    <td><?php echo $perc; ?></td>
                                    
                                    <td align="center"><?php echo $line3->subtotal; ?></td>
                                </tr>

                                <?php
                                $i++;
                                $subtotal = $line3->subtotal;
                                $payment = $line3->payment;
                                $balance = $line3->balance;
                                $date = $line->due_date;
                                $discount = $line3->dis_amount;
                                $amount_payable = $line3->payable_amount;
                                $actual_payment = $line3->payment;
                             
                                $grand_total = $line3->grand_total;
                                $paymentMode = $line3->payment_mode;
                            }
                            
                            ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                             <tr>
                                <td width="82%" align="right" bgcolor="#CCCCCC"><strong>Sub Total:&nbsp;&nbsp;</strong>
                                </td>
                                 <td width="18%" align="right" bgcolor="#CCCCCC"><?php  $grnd = round($grand_total-$total_tax,2); 
                                 if(strlen(substr(strrchr($grnd, "."), 1)) == 0){
                                     echo $grnd.".00";
                                 }else{
                                     echo $grnd;
                                 }
                                 ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                             <tr>
                                <td width="82%" align="right" bgcolor="#CCCCCC"><strong> VAT:&nbsp;&nbsp;</strong>
                                </td>
                                <td width="18%" align="right" bgcolor="#CCCCCC"><?php $tot_tx = round($total_tax,2);
                                if(strlen(substr(strrchr($tot_tx, "."), 1)) == 0){
                                     echo $tot_tx.".00";
                                 }elseif(strlen(substr(strrchr($tot_tx, "."), 1)) == 1) {
                                           echo $tot_tx."0";     
                                            }else{
                                     echo $tot_tx;
                                 }
                                ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                             <tr>
                                <td width="82%" align="right" bgcolor="#CCCCCC"><strong>Total Inc VAT:&nbsp;&nbsp;</strong>
                                </td>
                                <td width="18%" align="right" bgcolor="#CCCCCC"><?php $amnt_pay = round($grand_total,2);
                                if(strlen(substr(strrchr($amnt_pay, "."), 1)) == 0){
                                     echo $amnt_pay.".00";
                                 }
                                 elseif(strlen(substr(strrchr($amnt_pay, "."), 1)) == 1) {
                                           echo $amnt_pay."0";     
                                            }
                                 else{
                                     echo $amnt_pay;
                                 } 
                                
                                ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                             
                            <tr>
                                <td width="82%" align="right" bgcolor="#CCCCCC"><strong>Discount:&nbsp;&nbsp;</strong>
                                </td>
                                <td width="18%" align="right" bgcolor="#CCCCCC"><?php if(strlen(substr(strrchr($discount, "."), 1)) == 0){
                                     echo $discount.".00";
                                 }
                                 elseif(strlen(substr(strrchr($discount, "."), 1)) == 1) {
                                           echo $discount."0";     
                                            }
                                 else{
                                     echo $discount;
                                 } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                           
                              <tr>
                                <td width="82%" align="right" bgcolor="#CCCCCC"><strong> TOTAL:&nbsp;&nbsp;</strong>
                                </td>
                                <td width="18%" align="right" bgcolor="#CCCCCC"><?php $aftr_tx = round($amount_payable,2); 
                                 if(strlen(substr(strrchr($aftr_tx, "."), 1)) == 0){
                                     echo $aftr_tx.".00";
                                 }elseif(strlen(substr(strrchr($aftr_tx, "."), 1)) == 1) {
                                           echo $aftr_tx."0";     
                                            }else{
                                     echo $aftr_tx;
                                 }
                                ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                            <?php if($paymentMode=="cash") { ?>
                            <tr>
                                <td width="82%" align="right" bgcolor="#CCCCCC"><strong> AMOUNT TENDERED:&nbsp;&nbsp;</strong>
                                </td>
                                <td width="18%" align="right" bgcolor="#CCCCCC"><?php $paid = round($actual_payment,2); 
                                 if(strlen(substr(strrchr($paid, "."), 1)) == 0){
                                     echo $paid.".00";
                                 }elseif(strlen(substr(strrchr($paid, "."), 1)) == 1) {
                                           echo $paid."0";     
                                            }else{
                                     echo $paid;
                                 }
                                ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                             <tr>
                                <td width="82%" align="right" bgcolor="#CCCCCC"><strong> CHANGE:&nbsp;&nbsp;</strong>
                                </td>
                                <td width="18%" align="right" bgcolor="#CCCCCC"><?php $change = round($actual_payment - $aftr_tx,2); 
                                 if(strlen(substr(strrchr($change, "."), 1)) == 0){
                                     echo $change.".00";
                                 }elseif(strlen(substr(strrchr($change, "."), 1)) == 1) {
                                           echo $change."0";     
                                            }else{
                                     echo $change;
                                 }
                                ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="33%" align="left" valign="top"><br/>
                                    <strong>&nbsp;&nbsp;Paid Amount :&nbsp;&nbsp;<?php echo $payment; ?><br/>
                                        &nbsp;&nbsp;Balance &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;:&nbsp;&nbsp;<?php echo $balance; ?><br/>
                                        &nbsp;&nbsp;Due Date&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;: <?php if ($balance == 0) {
                                            $mysqldate = $date;

                                            $phpdate = strtotime($mysqldate);

                                            $phpdate = date("d/m/Y", $phpdate);
                                        }
                                        echo $phpdate; ?> <br/>
                                    </strong></td>
                               
                            </tr>
                            <br><br>
                            <tr>
                                 <td  align="left">
                                    <?php echo $sig->fiscal_signature; ?>  </td>
                                
                            </tr>
                        </table>
                    </td>
                    
                </tr>
                <tr>
                    <td align="left" bgcolor="#CCCCCC">Thank you for Business with <?php echo $line4->name; ?></td>
                     
                                      
                                      
                </tr>
            </table>
        </td>
    </tr>
</table>


</body>
</html>
<?php
}
else "Error in processing and printing the sales receipt";
}
?>