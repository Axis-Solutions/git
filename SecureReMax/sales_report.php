<?php
include("lib/db.class.php");
if (!include_once "config.php") {
    header("location: install.php");
}

// Open the base (construct the object):
$db_sec = new DB($config['database'], $config['host'], $config['username'], $config['password']);
require "db/dbapi.php";// Use session variable on this page. This function must put on the top of page.

    if (isset($_GET['from_sales_date']) && isset($_GET['to_sales_date']) && $_GET['from_sales_date'] != '' && $_GET['to_sales_date'] != '') {

        $salesman = $_GET['salesman'];
        $fromDate = $_GET['from_sales_date'];
        $DateFrom = date('Y-m-d H:i:s', strtotime($fromDate));
        $toDate = $_GET['to_sales_date'];
        $DateTo = date('Y-m-d H:i:s', strtotime($toDate));
        if(date("Y-m-d",strtotime($DateTo))== date("Y-m-d")){
            $DateTo = date("Y-m-d 23:59:59");
        }

        if ($salesman == "") {
            $salesman = "ALL";
        }
        ?>
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/html4/loose.dtd">
        <html>
            <head>
                <title>Sale Report</title>
                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            </head>
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
            <body>
                <input name="print" type="button" value="Print" id="printButton" onClick="printpage()">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center">
                            <div align="right">
                                <img style="height:150px;width:150px;" src="<?php
        if (isset($_SESSION['logo'])) {
            echo "upload/" . $_SESSION['logo'];
        } else {
            echo "upload/posnic.png";
        }
        ?>" alt="Point of Sale"/><br><br>
                                     <?php $line4 = $db_sec->queryUniqueObject("SELECT * FROM store_details ");
                                     ?>

                                <strong><?php echo $line4->name; ?></strong><br/>
                                <?php echo $line4->address; ?>,<br/>
                                <?php echo $line4->city; ?><br/>
                                <br>Email<strong>:  <?php echo $line4->email; ?></strong><br/>Phone
                                <strong>:<?php echo $line4->phone; ?></strong>
                                <br/><br><br>
                                VAT NO: <strong>:<?php echo $line4->vat; ?><br>
                                    BPN: <strong><?php echo $line4->bpn; ?>

                                        </div>
                                        <table width="595" border="0" cellspacing="0" cellpadding="0">

                                            <tr>
                                                <td height="30" align="center"><strong>Sales  for User <?php $salsmn =  get_user_det($salesman); echo $salsmn[0]["username"]; ?> </strong></td>
                                            </tr>
                                            <tr>
                                                <td height="30" align="center">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td align="right">
                                                    <table width="300" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td width="150"><strong>Total Sales </strong></td>
                                                            <td width="150">
                                                                &nbsp;<?php echo "$ ".$paybleamt = $db_sec->queryUniqueValue("SELECT sum(Payable_amount) FROM receipt_header_info where status ='Sold' and  CreatedDate >= '$DateFrom' AND CreatedDate <=  '$DateTo' and CreatedBy = $salesman "); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Cash Received</strong></td>
                                                            <td>
                                                                &nbsp;<?php $age = $db_sec->queryUniqueValue("SELECT sum(Actual_Payment) FROM receipt_header_info where status ='Sold' AND CreatedDate BETWEEN '$DateFrom' AND '$DateTo'  and  CreatedDate BETWEEN '$DateFrom' AND '$DateTo' and CreatedBy = $salesman and payment_mode = 'cash'");
                                                                if($age>$paybleamt){
                                                                    $age = $paybleamt;
                                                                    
                                                                }
                                                                echo "$ ".$age;
                                                                ?></td>
                                                        </tr>
                                                         <tr>
                                                            <td><strong>Credit Sales</strong></td>
                                                            <td>
                                                                &nbsp;<?php $crsale = $db_sec->queryUniqueValue("SELECT sum(Actual_Payment) FROM receipt_header_info where status ='Sold' AND CreatedDate BETWEEN '$DateFrom' AND '$DateTo'  and  CreatedDate BETWEEN '$DateFrom' AND '$DateTo' and CreatedBy = $salesman and payment_mode = 'credit'");
                                                               if($crsale == "" or $crsale==null ){
                                                                   $crsale = round(0.0000,2);
                                                               }
                                                                echo "$ ".$crsale;
                                                                ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="150"><strong>To Collect </strong></td>
                                                            <td width="150">
                                                                &nbsp;<?php echo "$ ".$age = $db_sec->queryUniqueValue("SELECT sum(Outstanding_balance) FROM receipt_header_info where status ='Sold'  AND CreatedDate BETWEEN '$DateFrom' AND '$DateTo'  and  CreatedDate BETWEEN '$DateFrom' AND '$DateTo' and CreatedBy = $salesman "); ?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="45">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="20">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td width="45"><strong>From</strong></td>
                                                            <td width="393">&nbsp;<?php echo date( "d M y",strtotime($DateFrom)); ?></td>
                                                            <td width="41"><strong>To</strong></td>
                                                            <td width="116">&nbsp;<?php echo date( "d M y",strtotime($DateTo)) ; ?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="60">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <thead>
                                                        <th align="left"><strong>Date</strong></td>
                                                        <th align="left"><strong>Rec Num </strong></td>
                                                        <th align="left"><strong>Customer</strong></td>
                                                        <th align="left"><strong>Total</strong></td>
                                                        <th align="left"><strong>Discount</strong></td>

                                                        <th align="left"><strong>Received</strong></td>

                                                            </thead>
                                                            <tr>
                                                <td width="60">
                                                    <hr>
                                                </td>
                                            </tr>
                                                        <tbody>
                                                            <?php
                                                            $result = $db_sec->query("SELECT * FROM receipt_header_info where status ='Sold' AND CreatedDate BETWEEN '$DateFrom' AND '$DateTo' and Createdby = $salesman ");
                                                            while ($line = $db_sec->fetchNextObject($result)) {
                                                                
                                                                ?>

                                                                <tr>
                                                                    <td align="left" style="width:15%;"><?php
                                                                        $mysqldate = $line->CreatedDate;
                                                                        $phpdate = date("d M y", strtotime($mysqldate));
                                                                        echo $phpdate;
                                                                        ?></td>
                                                                    <td style="width:25%;" align="left"><?php echo $line->Receipt_no; ?></td>
                                                                    <td style="width:20%;" align="left"><?php echo $line->Customer ?></td>
                                                                    <td style="width:10%;" align="left"><?php echo round($line->NetValue, 2); ?></td>
                                                                    <td style="width:15%;" align="left"><?php echo $line->TotalDiscount; ?></td>

                                                                    <td style="width:15%;" align="left"><?php echo round($line->Payable_amount, 2); ?></td>

                                                                </tr>


                                                                <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                        </td>
                                        </tr>
                                        </table>

                                        </body>
                                        </html>
                                        <?php
                                    } else
                                        echo "Please from and to date to process report";
                                
                                ?>