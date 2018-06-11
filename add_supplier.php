<?php
include_once("init.php");
include_once("db/dbapi.php");
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>POSNIC - Add Supplier</title>

    <!-- Stylesheets -->

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="js/date_pic/date_input.css">
    <link rel="stylesheet" href="lib/auto/css/jquery.autocomplete.css">

    <!-- Optimize for mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- jQuery & JS files -->
    <?php include_once("tpl/common_js.php"); ?>
    <script src="js/script.js"></script>
    <script src="js/date_pic/jquery.date_input.js"></script>
    <script src="lib/auto/js/jquery.autocomplete.js "></script>
    <script src="js/add_supplier.js"></script>

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
            <li><a href="view_sales.php" class=" sales-tab">Sales</a></li>
            <li><a href="view_customers.php" class="customers-tab">Customers</a></li>
            <li><a href="view_purchase.php" class="purchase-tab">Purchase</a></li>
            <li><a href="view_supplier.php" class="active-tab   supplier-tab">Supplier</a></li>
            <li><a href="view_product.php" class="stock-tab">Stocks / Products</a></li>
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

            <h3>supplier Management</h3>
            <ul>
                <li><a href="add_supplier.php">Add Supplier</a></li>
                <li><a href="view_supplier.php">View Supplier</a></li>
            </ul>

        </div>
        <!-- end side-menu -->

        <div class="side-content fr">

            <div class="content-module">

                <div class="content-module-heading cf">

                    <h3 class="fl">Add supplier</h3>
                    <span class="fr expand-collapse-text">Click to collapse</span>
                    <span class="fr expand-collapse-text initial-expand">Click to expand</span>

                </div>
                <!-- end content-module-heading -->

                <div class="content-module-main cf">


                   <?php 
                    ?>

                    <form name="form1" method="post" id="form1" action="">

                        <p><strong>Add Supplier Details </strong> - Add New ( Control +u)</p>
                        <table width="682" border="0" cellpadding="0" cellspacing="0" class="form">
                            <tr>
                                <td><span class="man">*</span>Name:</td>
                                <td><input name="supplier_name" placeholder="ENTER YOUR FULL NAME" type="text" id="name"
                                           maxlength="200" class="round default-width-input"
                                          /></td>
                                <td>Contact</td>
                                <td><input name="supplier_contact1" placeholder="ENTER YOUR ADDRESS contact1" type="text"
                                           id="buyingrate" maxlength="20" class="round default-width-input"
                                          /></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td><textarea name="supplier_address" placeholder="ENTER YOUR ADDRESS" cols="8"
                                              class="round full-width-textarea"></textarea>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>


                            <tr>
                                <td>&nbsp;
                                    
                                </td>
                                <td>
                                    <input class="button round blue image-right ic-add text-upper" type="submit"
                                           name="Submit" value="Add" id="button">
                                    (Control + S)

                                <td align="right"><input class="button round red   text-upper" type="reset" name="Reset"
                                                         value="Reset"></td>
                            </tr>
                        </table>
                    </form>


                </div>
                <!-- end content-module-main -->


            </div>
            <!-- end content-module -->


        </div>
        <!-- end full-width -->

    </div>
    <!-- end content -->


    <!-- FOOTER -->
    <div id="footer">
        <p>Any Queries send to <a href="mailto:takundamadzamba@gmail.com">+263773629282</a>.
        </p>

    </div>
    <!-- end footer -->
 <script type="text/javascript">
$(document).ready(function() {
    $('#button').click(function(ev){
		
		ev.preventDefault();
		$.post("engines/add_supplier.php",$("#form1").serialize(),function(response){
		
		alert(response);	
	});
});
});

 </script>
</body>
</html>