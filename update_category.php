<?php
include_once("init.php");
require "db/dbapi.php";
require 'db/var.php';
@$sid = $_GET["sid"];
$cat = get_category($sid);


?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WEBPOS - Update Category</title>

    <!-- Stylesheets -->

    <link rel="stylesheet" href="css/style.css">

    <!-- Optimize for mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- jQuery & JS files -->
    <?php include_once("tpl/common_js.php"); ?>
    <script src="js/script.js"></script>
    <script>
        /*$.validator.setDefaults({
         submitHandler: function() { alert("submitted!"); }
         });*/
        $(document).ready(function () {

            // validate signup form on keyup and submit
            $("#form1").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 200
                    },
                    address: {
                        minlength: 3,
                        maxlength: 500
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a Category Name",
                        minlength: "Category Name must consist of at least 3 characters"
                    },
                    address: {
                        minlength: "Category Discription must be at least 3 characters long",
                        maxlength: "Category Discription must be at least 3 characters long"
                    }
                }
            });

        });

    </script>

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

            <h3>Stock Category Management</h3>
            <ul>
                <li><a href="add_stock.php">Add Stock/Product</a></li>
                <li><a href="view_product.php">View Stock/Product</a></li>
                <li><a href="add_category.php">Add Stock Category</a></li>
                <li><a href="view_category.php">view Stock Category</a></li>
            </ul>

        </div>
        <!-- end side-menu -->

        <div class="side-content fr">

            <div class="content-module">

                <div class="content-module-heading cf">

                    <h3 class="fl">Update Supplier</h3>
                    <span class="fr expand-collapse-text">Click to collapse</span>
                    <span class="fr expand-collapse-text initial-expand">Click to expand</span>

                </div>
                <!-- end content-module-heading -->

                <div class="content-module-main cf">
                    <form name="form1" method="post" id="form1" action="">
                        <p><strong>Add Stock </strong> - Add New ( Control + 3)</p>
                        <table class="form" border="0" cellspacing="0" cellpadding="0">
                           
                            <form name="form1" method="post" id="form1" action="">
                                  <tr>
                                    <td>Name</td>
                                    <td><input name="category_name" type="text" id="name" maxlength="200"
                                               class="round default-width-input"
                                               value="<?php echo $cat [0]["category_name"] ; ?> "/></td>

                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td><textarea name="category_description" cols="15"
                                                  class="round full-width-textarea"><?php echo $cat [0]["category_description"] ; ?></textarea>
                                    </td>

                                </tr>


                                <tr>
                                    <td>&nbsp;
                                        
                                    </td>
                                    <td>
                                        <input class="button round blue image-right ic-add text-upper" type=				"submit"
                                               name="Submit" value="Save" id="btn_edit">
                                        (Control + S)
                                    </td>
                                    <td align="right"><input class="button round red   text-upper" type="reset"
                                                             name="Reset" value="Reset"></td>

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
    $('.button').click(function(ev){
		alert('clicked');
		ev.preventDefault();
		var id = '<?php echo $sid; ?>';
		$.post("engines/update_category.php?id="+id,$("#form1").serialize(),function(response){
		
		alert(response);	
	});
});
});
/*&
$(document).ready(function(e) {
    $(".button").click(function(ev){
		alert("Clicked");
		
		
	});
});
*/

 </script>
</body>
</html>
