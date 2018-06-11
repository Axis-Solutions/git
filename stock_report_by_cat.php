<?php

include_once("init.php");// Use session variable on this page. This function must put on the top of page.

if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'admin') { // if session variable "username" does not exist.
    header("location: index.php?msg=Please%20login%20to%20access%20admin%20area%20!"); // Re-direct to index.php
} else {
   
       /* $selected_date = $_GET['from_stock_date'];
        $selected_date = strtotime($selected_date);
        $mysqldate = date('Y-m-d H:i:s', $selected_date);
        $fromdate = $mysqldate;
        $selected_date = $_GET['to_stock_date'];
        $selected_date = strtotime($selected_date);
        $mysqldate = date('Y-m-d H:i:s', $selected_date);

        $todate = $mysqldate;*/

        ?>
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/html4/loose.dtd">
        <html>
        <head>
            <title>Stock Report</title>
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
                         <img style="height:150px;width:150px;" src="<?php if (isset($_SESSION['logo'])) {
                echo "upload/" . $_SESSION['logo'];
            } else {
                echo "upload/posnic.png";
                } ?>" alt="Point of Sale"/><br><br>
                        <?php $line4 = $db->queryUniqueObject("SELECT * FROM store_details ");
                        ?>
                       
                        <strong><?php echo $line4->name; ?></strong><br/>
                        <?php echo $line4->address; ?>,<br/>
                        <?php echo $line4->city; ?><br/>
                       <br>Email<strong>:  <?php echo $line4->email; ?></strong><br/>Phone
                        <strong>:<?php echo $line4->phone; ?></strong>
                        <br/><br><br>
                        VAT NO: <strong>:<?php echo $line4->vat; ?><br>
                             BPN: <strong>:<?php echo $line4->bpn; ?>
                       
                    </div>
                    <table width="800" border="0" cellspacing="0" cellpadding="0">

                        <tr>
                            <td height="30" align="center"><strong>Stock Report By Category</strong></td>
                        </tr>
                        <tr>
                            <td height="30" align="center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right">
                                <table width="300" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="150"><strong>Total Out Of Stock </strong></td>
                                        <td width="150">
                                            &nbsp;<?php echo $age = $db->queryUniqueValue("SELECT count(*) FROM stock_details where status ='active' and stock_quatity<=0"); ?>
                                        </td>
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
                                        <td width="45"><strong>As At:  </strong></td>
                                        <td width="393">&nbsp;<?php echo date("D d M y"); ?></td>
                                       
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width="60">
                                <hr>
                            </td>
                        </tr>
                        
                        <?php 
                        
                        $result_init = $db->query("SELECT distinct(category) FROM stock_details");
                                    while ($line_init = $db->fetchNextObject($result_init)) 
                                            {
                            $category = $line_init->category;
                        ?>
                      
                        <tr><td>
                                <strong style="color:red"> CATEGORY : <?php echo $category; ?></strong>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <thead style="color:blue;"> 
                                    <th align="left"><strong>Product Code </strong></td>
                                        <th align="left"><strong>Product Description </strong></td>
                                        <th align="left"><strong>Cost</strong></td>
                                        <th align="left"><strong>Stock On Hand</strong></td>
                                         <th align="left"><strong>Value ($)</strong></td>
                                        
                                        
                                    </thead>
                                    
                                    <tbody>
                                    <?php
                                    $result = $db->query("SELECT * FROM stock_details where status ='active' and category='$category' order by stock_name asc");
                                    while ($line = $db->fetchNextObject($result)) {
                                        ?>
                                   
                                        <tr>
                                            <td align="left" style="width:18%;"><?php echo  $line->stock_id;
                                                 ?></td>
                                            <td style="width:30%;" align="left"><?php echo $line->stock_name; ?></td>
                                            <td style="width:20%;" align="center"><?php echo round($line->company_price,2); ?></td>
                                            <td style="width:20%;" align="center"><?php echo $line->stock_quatity; ?></td>
                                             <td style="width:15%;" align="center"><?php echo $value = round($line->company_price,2)*$line->stock_quatity; ?></td>
                                            
                                            
                                        </tr>


                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                    <br><br>
                            </td>
                          
                        </tr>
                      
                        <?php } ?>
                        
                        
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
<?php } ?>
 