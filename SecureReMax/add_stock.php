<?php
include_once("init.php");
require 'db/var.php';
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>New Product</title>

        <!-- Stylesheets -->
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="js/date_pic/date_input.css">
        <link rel="stylesheet" href="lib/auto/css/jquery.autocomplete.css">
        <link rel="stylesheet" href="js/select2/select2.css">
       

        <!-- Optimize for mobile devices -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <!-- jQuery & JS files -->
        <?php include_once("tpl/common_js.php"); ?>
        <script src="js/script.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/date_pic/jquery.date_input.js"></script>
        <script src="lib/auto/js/jquery.autocomplete.js "></script>
        <script src="js/add_stock.js"></script>
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
                <a href="#" id="company-branding-small" class="fr"><img src="<?php
                    if (isset($_SESSION['logo'])) {
                        echo "upload/" . $_SESSION['logo'];
                    } else {
                        echo "upload/posnic.png";
                    }
                    ?>" alt="Point of Sale"/></a>

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
                        <li><a href="add_stock.php">Add Stock/Product</a></li>
                        <li><a href="view_product.php">View Stock/Product</a></li>
                        <li><a href="add_category.php">Add Stock Category</a></li>
                        <li><a href="view_category.php">view Stock Category</a></li>
                        <li><a href="view_stock_availability.php">view Stock Available</a></li>
                    </ul>

                </div>
                <!-- end side-menu -->

                <div class="side-content fr">

                    <div class="content-module">

                        <div class="content-module-heading cf">

                            <h3 class="fl">Add Stock </h3>
                            <span class="fr expand-collapse-text">Click to collapse</span>
                            <span class="fr expand-collapse-text initial-expand">Click to expand</span>

                        </div>
                        <!-- end content-module-heading -->

                        <div class="content-module-main cf">


                            <?php
                            //Gump is libarary for Validatoin
                            ?>

                            <form name="form1" method="post" id="form1" action="">


                                <table class="form" border="0" cellspacing="0" cellpadding="0">
                                    <tr>

                                        <td><span class="man">*</span>Code:</td>
                                        <td><input name="stockid" type="text" id="stockid" placeholder="Enter Stock Code"  maxlength="200"
                                                   class="round default-width-input"
                                                   value="<?php echo isset($autoid) ? $autoid : ''; ?>"/></td>

                                        <td><span class="man">*</span>Name:</td>
                                        <td><input name="name" placeholder="ENTER STOCK NAME" type="text" id="name"
                                                   maxlength="200" class="round default-width-input"
                                                   /></td>

                                    </tr>
                                    <tr>
                                        <td><span class="man">*</span>Cost:</td>
                                        <td><input name="cost" placeholder="ENTER COST PRICE" type="text" id="cost"
                                                   maxlength="200" class="round default-width-input"
                                                   onkeypress="return numbersonly(event)"
                                                   /></td>

                                        <td><span class="man">*</span>Sell:</td>
                                        <td><input name="sell" placeholder="ENTER SELLING PRICE" type="text" id="sell"
                                                   maxlength="200" class="round default-width-input"
                                                   onkeypress="return numbersonly(event)"
                                                  /></td>

                                    </tr>
                                    <tr>
                                        <td>Qty Avail:</td>
                                        <td><input name="qty" placeholder="Qty available" type="number" id="qty"
                                                   maxlength="200" class="round default-width-input"
                                                   /></td>

                                        <td>Category:</td>
                                        <td><select class="js-example-basic-multiple round default-width-input" name="category" id="categ" placeholder="Provide Product Tac Code" >
                                                <option value="">Choose category</option>
                                                <?php $cat =  get_categs(); 
                                                foreach($cat as $ct){
                                                   
                                                    $cat_desc = $ct["category_name"];
                                               
                                                ?>
                                                <option value="<?php echo $cat_desc; ?>"><?php echo $cat_desc; ?></option>
                                                <?php } ?>
                                            </select> </td>

                                    </tr>

                                    <tr>
                                        <td><span class="man">*</span>Tax Code:</td>
                                        <td>  <select class="js-example-basic-multiple round default-width-input" name="tax_code" placeholder="Provide Product Tac Code" >
                                                <option value="">Choose tax code..</option>
                                                <option value="A">A (15% VAT)</option>
                                                <option value="B">B (Exclude VAT)</option>
                                            </select>                         </td>
                                        
                                         <td>UOM:</td>
                                        <td> <select class="js-example-basic-multiple round default-width-input" name="UOM" placeholder="Provide Product Tac Code" >
                                                <option value="">Choose UOM</option>
                                                <?php $uom = get_uom(); 
                                                foreach($uom as $um){
                                                   
                                                    $uom_desc = $um["UOM_DESC"];
                                               
                                                ?>
                                                <option value="<?php echo $uom_desc; ?>"><?php echo $uom_desc; ?></option>
                                                <?php } ?>
                                            </select>  </td>
                                        
                                    </tr>
                                    <tr>
                                        <td>Expiry Date:</td>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp; <input name="expiry_date" type="text" id="expiry_date"
                                               style="width:250px;"></td>
                                        
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
                                                   name="Submit" id="btn_newstk" value="Add">
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
                $(".js-example-basic-multiple").select2();
                $(document).ready(function () {
            $('#expiry_date').jdPicker();
            $("#btn_newstk").click(function(e){
                e.preventDefault();
                $.post("engines/new_stock.php",$("#form1").serialize(),function(response){
                    alert(response);
                });
            });
        });
            </script>

    </body>
</html>