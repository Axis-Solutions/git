<?php
include_once("init.php");
require 'db/var.php';
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Import Product</title>

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

                            <h3 class="fl">Import Stocks </h3>
                            <span class="fr expand-collapse-text">Click to collapse</span>
                            <span class="fr expand-collapse-text initial-expand">Click to expand</span>

                        </div>
                        <!-- end content-module-heading -->

                        <div class="content-module-main cf">


                            <?php
                            //Gump is libarary for Validatoin
                            ?>

                            <form name="form1" method="post" id="uploadprod" action="">


                                <table class="form" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                          <div class="form-group">
                            <h1 style="color:#470607;"> 
                                Download Products Details Template (xlsx)<a href="templates/Products.xls" download="Products" title="download Products template" style="color:red; text-decoration:none;">  							Here</a>, edit and save it as is.
                            </h1>
                        </div>
                                    
                                    <br><br>
                                        
                               <label for="exampleInputFile">Pick Import file by clicking choose file</label>
                            <input type="file" id="file" name="file">
                            </tr>
                            <br><br>
                                    <tr>
                                        <td>
                                            &nbsp;
                                        </td>
                                        <td>
                                            <input class="button round blue image-right ic-add text-upper btnupload" type="submit"
                                                   name="Submit" id="btn_newstk" value="Add">
                                            (Control + S)

                                        <td align="right"><input class="button round red   text-upper" type="reset" name="Reset"
                                                                 value="Reset"></td>
                                    </tr>
                                </table>
                                 <div class="ajax-loaders upload-saving-spinner"> <span><b>...Importing Products...</b></span></div><br>  
                                 <div class="response"></div>
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
                    $(".upload-saving-spinner").hide();
            
            $('.btnupload').on('click', function(e) {
	 e.preventDefault();
	  $('.btnupload').prop('disabled', true);
	 $('.upload-saving-spinner').slideDown('slow');
var formdata = new FormData($("form#uploadprod")[0]);
                         
		$.ajax({
               url: 'engines/importproducts.php', // point to server-side PHP script 
               dataType: 'text',  // what to expect back from the PHP script, if anything
               cache: false,
               contentType: false,
               processData: false,
               data: formdata ,                       
               type: 'POST',
               success: function(response){
                    $('.upload-saving-spinner').slideUp('slow');
                   var dt = $.parseJSON(response);
                   console.log(dt);
				 if(dt.log==="failed")
                                 {
                                   $('.btnupload').prop('disabled', false);
                                    $('.response').html('<div class="alert alert-danger">'+dt.msg+'</div>');
                                
                                 }
                                 else if(dt.log=="ok")
                                 {
                                      $('.btnupload').prop('disabled', false);
                                     $('.response').html('<div class="alert alert-success">'+dt.msg+'</div>');
                                        
                                 }
                             
               }
    });
});
        });
            </script>

    </body>
</html>