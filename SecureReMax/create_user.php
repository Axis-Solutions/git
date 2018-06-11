<?php
include_once("init.php");

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WEBPOS - Create User</title>

    <!-- Stylesheets -->

    <link rel="stylesheet" href="css/style.css">
     <link rel="stylesheet" href="js/select2/select2.css">

    <!-- Optimize for mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- jQuery & JS files -->
    <?php include_once("tpl/common_js.php"); ?>
    <script src="js/script.js"></script>
      <script src="js/select2/select2.min.js"></script>
</head>
<body>

<!-- TOP BAR -->
<?php include_once("tpl/top_bar.php"); ?>
<!-- end top-bar -->


<!-- HEADER -->
<div id="header-with-tabs">

    <div class="page-full-width cf">

        <ul id="tabs" class="fl">
            <li><a href="dashboard.php" class="active-tab dashboard-tab">Dashboard</a></li>
            <li><a href="view_sales.php" class="sales-tab">Sales</a></li>
            <li><a href="view_customers.php" class=" customers-tab">Customers</a></li>
            <li><a href="view_purchase.php" class="purchase-tab">Purchase</a></li>
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

            <h3>Quick Links</h3>
            <ul>
                <li><a href="add_sales.php">Add Sales</a></li>
                <li><a href="add_purchase.php">Add Purchase</a></li>
                <li><a href="add_supplier.php">Add Supplier</a></li>
                <li><a href="add_customer.php">Add Customer</a></li>
                <li><a href="view_report.php">Report</a></li>
            </ul>

        </div>
        <!-- end side-menu -->

        <div class="side-content fr">

            <div class="content-module">

                <div class="content-module-heading cf">

                    <h3 class="fl">New User</h3>
                    <span class="fr expand-collapse-text">Click to collapse</span>
                    <span class="fr expand-collapse-text initial-expand">Click to expand</span>

                </div>
                <!-- end content-module-heading -->

                <div class="content-module-main cf">

                    <form action="" class="new_user_form" method="post">
                        <table style="width:600px; margin-left:50px; float:left;" border="0" cellspacing="0"
                               cellpadding="0">

                           
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>User Type</td>
                                 <td>
                                            <select class="js-example-basic-multiple round default-width-input" name="user_type" id="payment_mode" data-placeholder="User type">
                                                <option value=""></option>
                                                <option value="user">User</option>
                                                <option value="manager">Manager</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                           
                            <tr>
                                <tr>
                                <td>Username</td>
                                <td><input type="text" name="username" ></td>
                            </tr>
                            </tr>
                            <tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td>
                                    <input class="button round blue image-right ic-add text-upper btn_new_user" type="submit"
                                           name="Submit" name="change_pass" value="Create User">
                                </td>
                                <td>
                                    <input class="button round red   text-upper" type="reset" name="Reset"
                                           value="Reset"></td>
                            </tr>

                        </table>
                    </form>
                    <!--<ul class="temporary-button-showcase">
                                        <li><a href="#" class="button round blue image-right ic-add text-upper">Add</a></li>
                                        <li><a href="#" class="button round blue image-right ic-edit text-upper">Edit</a></li>
                                        <li><a href="#" class="button round blue image-right ic-delete text-upper">Delete</a></li>
                                        <li><a href="#" class="button round blue image-right ic-download text-upper">Download</a></li>
                                        <li><a href="#" class="button round blue image-right ic-upload text-upper">Upload</a></li>
                                        <li><a href="#" class="button round blue image-right ic-favorite text-upper">Favorite</a></li>
                                        <li><a href="#" class="button round blue image-right ic-print text-upper">Print</a></li>
                                        <li><a href="#" class="button round blue image-right ic-refresh text-upper">Refresh</a></li>
                                        <li><a href="#" class="button round blue image-right ic-search text-upper">Search</a></li>
                                    </ul>-->

                </div>
                <!-- end content-module-main -->


            </div>
            <!-- end content-module -->


        </div>
        <!-- end full-width -->

    </div>
</div>


<!-- FOOTER -->
<div id="footer">
   

    <p>Any Queries send to <a href="mailto:takundamadzamba@gmail.com">+263773629282</a>.
    </p>

</div>

<script>
$(document).ready(function(){
     $(".js-example-basic-multiple").select2();
     
     $(".btn_new_user").click(function(ev){
         ev.preventDefault();
         $.post("engines/new_user.php",$(".new_user_form").serialize(),function(resp){
             alert(resp);
         });
     });
});

</script>
<!-- end footer -->

</body>
</html>