<?php
include_once("init.php");
require 'db/dbapi.php';

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WEBPOS - Stock</title>

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

    <!-- jQuery & JS files -->

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
            <li><a href="view_sales.php" class="sales-tab">Sales</a></li>
            <li><a href="view_customers.php" class=" customers-tab">Customers</a></li>
            <li><a href="view_purchase.php" class="purchase-tab">Purchase</a></li>
            <li><a href="view_supplier.php" class=" supplier-tab">Supplier</a></li>
            <li><a href="view_product.php" class="active-tab stock-tab">Stocks / Products</a></li>
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

            <h3>Stock Management</h3>
            <ul>
                <li><a href="import_products.php">Import Products</a></li>
                <li><a href="add_stock.php">Add Stock/Product</a></li>
                <li><a href="view_product.php">View Stock/Product</a></li>
                <li><a href="add_category.php">Add Stock Category</a></li>
                <li><a href="view_category.php">view Stock Category</a></li>
                <li><a href="add_uom.php">Add Unit Of Measure</a></li>
                <li><a href="view_uom.php">view Unit Of Measure</a></li>
                <li><a href="view_stock_availability.php">view Stock Available</a></li>
            </ul>

        </div>
        <!-- end side-menu -->

        <div class="side-content fr">

            <div class="content-module">

                <div class="content-module-heading cf">

                    <h3 class="fl">Stock/Product</h3>
                    

                </div>
                <!-- end content-module-heading -->

                <div class="content-module-main cf">

                            <table class="table table-borderless js-dataTable-full table-vcenter display nowrap">
                                <thead>
                                     <tr>
                                         <th style="width:10%">Stock Code</th>
                                    <th>Stock Name</th>
                                     <th>Category</th>
                                    <th>On Stock</th>
                                    
                                    <th>Sell Price</th>
                                   <?php if($_SESSION["usertype"]=="admin"){ ?>
                                    <th>Edit /Delete</th>
                                   <?php } ?>
                                
                                </tr>
                                </thead>
                                <tbody>
                                    
                               
                               

                                <?php 
                             $products =   get_all_prods();
                             foreach($products as $row){
                                    ?>
                                    <tr>
                                        
                                        <td> <?php echo $row['stock_id']; ?></td>
                                        <td><?php echo $row['stock_name']; ?></td>
                                        <td> <?php echo $row['category']; ?></td>
                                        <td> <?php echo $row['stock_quatity']; ?></td>
                                       
                                        <td> <?php echo $row['selling_price']; ?></td>
                                        <?php if($_SESSION["usertype"]=="admin"){ ?>
                                         <td>
                                            <a href="update_stock.php?sid=<?php echo $row['id']; ?>&table=stock_details&return=view_product.php"
                                               class="table-actions-button ic-table-edit">
                                            </a>
                                            <a 
                                               href="delete.php?id=<?php echo $row['id']; ?>&table=stock_details&return=view_supplier.php"
                                               class="table-actions-button ic-table-delete"></a>
                                             
                                               <a href="updateqty.php?id=<?php echo $row['id']; ?>" title="Update Quantity"
                                                  class="table-actions-button ic-info"></a>
                                              
                                             
                                              <a href="sku_sum.php?id=<?php echo $row['id']; ?>" title="View Sku Summary"
                                                  class="table-actions-button menu-settings"></a>
                                        </td>
                                         <?php } ?>
                                      

                                    </tr>
                                  
                               <?php } ?>
                                     </tbody>
                              
                            </table>
                   


                </div>
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