<?php
include_once("init.php");

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>POSNIC - Add Customer</title>

    <!-- Stylesheets -->

    <link rel="stylesheet" href="css/style.css">

    <!-- Optimize for mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style type="text/css">

        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
            background-color: #FFFFFF;
        }

        * {
            padding: 0px;
            margin: 0px;
        }

        #vertmenu {
            font-family: Verdana, Arial, Helvetica, sans-serif;
            font-size: 100%;
            width: 160px;
            padding: 0px;
            margin: 0px;
        }

        #vertmenu h1 {
            display: block;
            background-color: #FF9900;
            font-size: 90%;
            padding: 3px 0 5px 3px;
            border: 1px solid #000000;
            color: #333333;
            margin: 0px;
            width: 159px;
        }

        #vertmenu ul {
            list-style: none;
            margin: 0px;
            padding: 0px;
            border: none;
        }

        #vertmenu ul li {
            margin: 0px;
            padding: 0px;
        }

        #vertmenu ul li a {
            font-size: 80%;
            display: block;
            border-bottom: 1px dashed #C39C4E;
            padding: 5px 0px 2px 4px;
            text-decoration: none;
            color: #666666;
            width: 160px;
        }

        #vertmenu ul li a:hover, #vertmenu ul li a:focus {
            color: #000000;
            background-color: #eeeeee;
        }

        .style1 {
            color: #000000
        }

        div.pagination {

            padding: 3px;

            margin: 3px;

        }

        div.pagination a {

            padding: 2px 5px 2px 5px;

            margin: 2px;

            border: 1px solid #AAAADD;

            text-decoration: none; /* no underline */

            color: #000099;

        }

        div.pagination a:hover, div.pagination a:active {

            border: 1px solid #000099;

            color: #000;

        }

        div.pagination span.current {

            padding: 2px 5px 2px 5px;

            margin: 2px;

            border: 1px solid #000099;

            font-weight: bold;

            background-color: #000099;

            color: #FFF;

        }

        div.pagination span.disabled {

            padding: 2px 5px 2px 5px;

            margin: 2px;

            border: 1px solid #EEE;

            color: #DDD;

        }


    </style>
    <!-- jQuery & JS files -->
    <?php include_once("tpl/common_js.php"); ?>
    <script src="js/script.js"></script>
    <script src="js/add_customer.js"></script>
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
            <li><a href="view_customers.php" class="active-tab customers-tab">Customers</a></li>
            <li><a href="view_purchase.php" class="purchase-tab">Purchase</a></li>
            <li><a href="view_supplier.php" class="  supplier-tab">Supplier</a></li>
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

            <h3>Customers Management</h3>
            <ul>
                <li><a href="add_customer.php">Add Customer</a></li>
                <li><a href="view_customers.php">View Customers</a></li>
            </ul>

        </div>
        <!-- end side-menu -->

        <div class="side-content fr">

            <div class="content-module">

                <div class="content-module-heading cf">

                    <h3 class="fl">Add Customer</h3>
                    <span class="fr expand-collapse-text">Click to collapse</span>
                    <span class="fr expand-collapse-text initial-expand">Click to expand</span>

                </div>
                <!-- end content-module-heading -->

                <div class="content-module-main cf">


                    <form name="form1" method="post" id="form1" action="">

                        <p><strong>Add Customer Details </strong> - Add New ( Control +A)</p>
                        <table class="form" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><span class="man">*</span>Name:</td>
                                <td><input name="name" placeholder="ENTER CUSTOMER NAME" type="text" id="name"
                                           maxlength="200" class="round default-width-input"
                                          /></td>
                                <td>Contact Number</td>
                                <td><input name="contact" placeholder="ENTER CUSTOMER MOBILE" type="text"
                                           id="buyingrate" maxlength="20" class="round default-width-input"
                                           /></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td><textarea name="address" placeholder="ENTER CUSTOMER ADDRESS" cols="15"
                                              class="round full-width-textarea"><?php echo isset($address) ? $address : ''; ?></textarea>
                                </td>
                               

                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    <input class="button round blue image-right ic-add text-upper" type="submit"
                                           name="Submit" id="button" value="Add">
                                    (Control + S)
                                <td>
                                    &nbsp;
                                </td>
                                <td align="right"><input class="button round red text-upper" type="reset" name="Reset"
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
		$.post("engines/add_customer.php",$("#form1").serialize(),function(response){
		
		alert(response);	
	});
});
});

 </script>

</body>
</html>