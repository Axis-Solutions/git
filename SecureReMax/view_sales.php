<?php
include_once("init.php");
require 'db/dbapi.php';

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WEBPOS - Sales</title>

    <!-- Stylesheets -->
    <!---->
  
       <link rel="stylesheet" href="css/style.css">
   
 <link rel="stylesheet" href="js/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="js/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="js/datatables/buttons.dataTables.min.css">

    <!-- Optimize for mobile devices -->
         <?php include_once("tpl/common_js.php"); ?>
    <script src="js/datatables/jquery.dataTables.min.js"></script>
<script src="js/datatables/dataTables.buttons.min.js"></script>
<script src="js/datatables/buttons.flash.min.js"></script>
<script src="js/datatables/jszip.min.js"></script>
<script src="js/datatables/pdfmake.min.js"></script>
<script src="js/datatables/vfs_fonts.js"></script>
<script src="js/datatables/buttons.html5.min.js"></script>
<script src="js/datatables/buttons.print.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    
</head>
<body>

<!-- TOP BAR -->
<?php include_once("tpl/top_bar.php"); ?>
<!-- end top-bar -->


<!-- HEADER -->
<div id="header-with-tabs">

    <div class="page-full-width cf">

        <ul id="tabs" class="fl">
            <li><a href="dashboard.php" class="dashboard-tab">Dashboard</a></li>
            <li><a href="view_sales.php" class="active-tab sales-tab">Sales</a></li>
            <li><a href="view_customers.php" class=" customers-tab">Customers</a></li>
            <li><a href="view_purchase.php" class=" purchase-tab">Purchase</a></li>
            <li><a href="view_supplier.php" class=" supplier-tab">Supplier</a></li>
            <li><a href="view_product.php" class=" stock-tab">Stocks / Products</a></li>
            <li><a href="view_payments.php" class="payment-tab">Payments / Outstandings</a></li>
            <li><a href="view_report.php" class="report-tab">Reports</a></li>
        </ul>
        <!-- end tabs -->

        <!-- Change this image to your own company's logo -->
        <!-- The logo will automatically be resized to 30px height. -->
        <a href="#" id="company-branding-small" class="fr"><img src="<?php if (isset($_SESSION['logo'])) {
                echo "upload/" . $_SESSION['logo'];
            } else {
                echo "upload/posnic.png";
            } ?>" alt="Point of Sale"/></a>

    </div>
    <!-- end full-width -->

</div>
<!-- end header -->


<!-- MAIN CONTENT -->
<div id="content">

    <div class="page-full-width cf">

        <div class="side-menu fl">

            <h3>Sales</h3>
            <ul>
                <li><a href="add_sales.php">Add Sales</a></li>
                <li><a href="view_sales.php">View Sales</a></li>

            </ul>

        </div>
        <!-- end side-menu -->

        <div class="side-content fr">

            <div class="content-module">

                <div class="content-module-heading cf">

                    <h3 class="fl">Sales</h3>
                    <span class="fr expand-collapse-text">Click to collapse</span>
                    <span class="fr expand-collapse-text initial-expand">Click to expand</span>

                </div>
                <!-- end content-module-heading -->

                <div class="content-module-main cf">
            <table class="table table-borderless js-dataTable-full table-vcenter display nowrap">
                                <thead>
                                     <tr>
                                        <th>Receipt #</th>
                                    <th>Customer</th>
                                    <th>Total Value</th>
                                    <th>Discount</th>
                                    <th>Payable (excl VAT)</th>
                                     <th>Payment Mode</th>
                                     <th>Date </th>
                                    <th>Salesman</th>
                                    <th> Command </th>

                                </tr>
                                </thead>
                                <tbody>
                                    
                               
                               

                                <?php 
                             $sales =   get_all_sales();
                             foreach($sales as $row){
                                 if($row["payment_mode"]=="partly_cr"){
                                     $paymnt_mode = "Credit";
                                 }
                                 else{
                                      $paymnt_mode = $row["payment_mode"];
                                 }
                               
                                  $datecreated = date("d M y",strtotime($row["CreatedDate"]));
                                  $salemn = get_user_det($row["CreatedBy"]);
                                  $salesman = $salemn[0]["username"];
                                  
                                    ?>
                                    <tr>
                                        <td><a href='my_invoice.php?sid=<?php echo $row['Receipt_no']; ?>'> <?php echo $row['Receipt_no']; ?></a></td>
                                       <td> <?php echo $row['Customer']; ?></td>
                                        <td> <?php echo $row['NetValue']; ?></td>
                                        <td> <?php echo $row['TotalDiscount']; ?></td>
                                         <td> <?php echo $row['Payable_amount']; ?></td>
                                          <td> <?php echo $paymnt_mode; ?></td>
                                           <td> <?php echo $datecreated; ?></td>
                                            <td> <?php echo $salesman; ?></td>
                                         <td>
                                          
                                                <a title="cancel receipt" href="cancel_receipt.php?rec_no=<?php echo base64_encode($row['Receipt_no']); ?> " class="table-actions-button ic-table-delete"></a>
                                        </td>
                                      

                                    </tr>
                                  
                               <?php } ?>
                                     </tbody>
                              
                            </table>


                </div>
            </div>
            <div id="footer">
                <p>Any Queries send to <a href="mailto:takundamadzamba@gmail.com">+263773629282</a>.
                </p>

            </div>
            
 <script>
                 $(document).ready(function () {
  jQuery('.js-dataTable-full').dataTable({
            columnDefs: [ { orderable: false, targets: [ 4 ] } ],
            pageLength: 20,
             "order": [[ 2, "asc" ]],
            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
             dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
        });
     
    });
                </script>
            <!-- end footer -->

</body>
</html>