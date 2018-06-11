
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>

<?php
require 'db/dbapi.php';

$company = get_co_details();

$sid = $_GET['sid'];
$InvoiceDetails = get_trans_products($sid);
$CustomerName  = $InvoiceDetails[0]["customer"];

$CustomerData = get_customer_details($CustomerName);
$CustomerAddres  = $CustomerData[0]["customer_address"];
$PhoneNum = $CustomerData[0]["customer_contact1"];

$InvDate = date("d M y",  strtotime($InvoiceDetails[0]["CreatedDate"]));

?>


<!-- Page Header -->
<!-- You can use the .hidden-print class to hide an element in printing -->
<div class="content bg-gray-lighter hidden-print">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Invoice 
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li>Generic</li>
                <li><a class="link-effect" href="">Invoice</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content content-boxed">
    <!-- Invoice -->
    <div class="block report_contents">
        <div class="block-header">
            <ul class="block-options">
                <li>
                    <!-- Print Page functionality is initialized in App() -> uiHelperPrint() -->
                    <button type="button" onclick="window.print();"><i class="si si-printer"></i> Print Invoice</button>
                </li>
              
            </ul>
            <h3 class="block-title">INV#: <?php echo $sid; ?></h3>
        </div>
        <div class="block-content block-content-narrow">
            <!-- Invoice Info -->
            <div class="row">


                <div class="h1 text-left  col-xs-5 col-sm-5 col-lg-5 pull-left"> 
                    <img src="<?php echo 'upload/'.$company[0]['log']; ?>" alt="No image" class="" style="height:150px; width: 150px;">
                </div>
                <div class="col-xs-2 col-sm-2 col-lg-2 text-center block-title">
                    FISCAL INVOICE
                </div>
                <div class="h1 text-right col-xs-5 col-sm-5 col-lg-5 pull-right"> 
                   
                </div>
            </div>
            <hr class="">
            <div class="row items-push-2x">
                <!-- Company Info -->
                <div class="col-xs-6 col-sm-4 col-lg-3">
                   <p class="h4 font-w200 push-5"><?php echo $company[0]['name']; ?></p>
                    <address>
                        <?php
                        $myaddr = $company[0]['address'].'<br>'; 
                        $myaddr .= $company[0]['city'].'<br>';
                        $myaddr .="VAT #: ".$company[0]['vat'].'<br>';
                        $myaddr .="BPN : ".$company[0]['bpn'].'<br>';
                        echo $myaddr;
                       
                        ?>
                    </address>

                    Invoice Date: <?php echo $InvDate; ?>

                </div>
                <!-- END Company Info -->

                <!-- Client Info -->
                <div class="col-xs-6 col-sm-4 col-sm-offset-4 col-lg-3 col-lg-offset-6 text-right">
                    <p class="h4 font-w200 push-5">SHIP TO DETAILS </p>
                    <p class="h5 font-w200 push-5"><?php echo 'Customer Name: '.$CustomerName; ?></p>
                    <address>
                        <?php
                        $myaddr = $CustomerAddres.'<br>'; 
                       
                        echo $myaddr;
                       
                        ?>
                    </address>

                </div>
                <!-- END Client Info -->
            </div>
            <!-- END Invoice Info -->

            <!-- Table -->
            <div class="table-responsive push-50">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 150px;"> Code</th>
                            <th>Product Description</th>
                            <th class="text-center" style="width: 100px;">Quantity</th>
                            <th class="text-center" style="width: 120px;">Unit Price</th>
                            <th class="text-center" style="width: 120px;">Line VAT</th>
                            <th class="text-center" style="width: 100px;">Line Total</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalVat = array();
                        foreach ($InvoiceDetails as $det) {
                            $prdct_name = $det['stock_name'];
                            $qty = $det['quantity'];
                            $unit_price = $det['selling_price'];
                          
                            $total = $det['subtotal'];
                              $TaxCode = $det['Tax_Code'];
                              if($TaxCode=="A"){
                               $Vat =   $total - ($total/1.15);
                                  $LineVat = number_format(($total - ($total/1.15)),2,".","");
                              }
                              else{
                                  $Vat = 0.00;
                                  $LineVat = "0.00";
                              }
                           
                      
                           
                          
                            $pdctCode =  $det['stock_id'];
                            array_push($totalVat, $Vat);
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $pdctCode; ?></td>
                                <td>
                                    <p class="font-w600 push-10"><?php echo $prdct_name; ?></p>

                                </td>
                                <td class="text-center"><span class="badge badge-primary"><?php echo $qty; ?></span></td>
                                <td class="text-center"> <?php echo (float) $unit_price; ?></td>
                                <td class="text-center"> <?php echo  $LineVat; ?></td>
                                <td class="text-right"> <?php echo (float) $total; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="5" class="font-w600 text-right">Subtotal</td>
                            <td class="text-right">
                                <?php
                                $InvTotal = $InvoiceDetails[0]["payable_amount"];
                                $grandTtl = $InvTotal - array_sum($totalVat);
                                echo number_format($grandTtl,2,".","");
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="5" class="font-w600 text-right">Vat Due</td>
                            <td class="text-right"><?php echo number_format(array_sum($totalVat),2,".",""); ?></td>
                        </tr>
                        <tr class="active">
                            <td colspan="5" class="font-w700 text-uppercase text-right">Invoice Total</td>
                            <td class="font-w700 text-right"><?php echo number_format($InvTotal,2,".",""); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- END Table -->

            <!-- Footer -->
            <hr class="hidden-print">
           
        </div>
    </div>
    <!-- END Invoice -->
</div>
<!-- END Page Content -->


<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<?php require 'inc/views/template_footer_end.php'; ?>

