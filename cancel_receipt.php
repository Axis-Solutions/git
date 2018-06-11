<?php
include_once("init.php");

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WEBPOS - Stock</title>

    <!-- Stylesheets -->
    <!---->
  
    <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="js/select2/select2.css">

    <!-- Optimize for mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- jQuery & JS files -->
    <?php include_once("tpl/common_js.php"); ?>
    <script src="js/lib/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
     <script src="js/select2/select2.min.js"></script>
    <script src="js/view_sales.js"></script>


    
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

                    <h3 class="fl">Cancel Receipt </h3>
                    <span class="fr expand-collapse-text">Click to collapse</span>
                    <span class="fr expand-collapse-text initial-expand">Click to expand</span>

                </div>
                <!-- end content-module-heading -->
<?php $rec_no = base64_decode($_GET["rec_no"]); ?>
                <div class="content-module-main cf">


                              <div class="" id="" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                  
                    <h3  style="margin-left:30px;">Cancel Receipt <?php echo $rec_no; ?> </h3>
                </div><br>
                <div class="block-content" style="margin-left:30px; width:50%;">
                  
                    <input class="form-control" type="text" id="cancelation_reason" name="cancelation_reason" placeholder="State Cancelation reason">
                    <br>
                    <select style="width:100%;"class="js-example-basic-multiple" id="cancel_type" name="cancel_type" data-placeholder="  Return as ....." >
                                                <option value=""></option>
                                                <option value="CRN">Obsolete Stock </option>
                                                <option value="Reversal">Incorrect Receipt</option>
                                            </select> 
                
                
                </div>
            </div><br>
            <div class="modal-footer">
               
                <button class="btn btn-sm btn-primary confirm_cancel"> Confirm Cancellation</button>
                <br><br> <div class="response"></div>
            </div>
              
        </div>
    </div>      
                       

                       


                </div>
            </div>
        </div>
            <div id="footer">
                <p>Any Queries send to <a href="mailto:takundamadzamba@gmail.com">+263773629282</a>.
                </p>

            </div>
            

            
            <script>
                $(document).ready(function(){
                    $(".js-example-basic-multiple").select2();
                    
                  
                    
                    $(".confirm_cancel").click(function(ev){
                        ev.preventDefault();
                      var receipt_no = '<?php echo $rec_no; ?>' ;
                      $.post("engines/sales_returns.php",{
                          rec_no:receipt_no,
                          cancelation_reason:$("#cancelation_reason").val(),
                          cancel_type:$("#cancel_type").val()
                      },function(resp){
                          alert(resp);
                      });
                    });
                     
                    
                });
                </script>
            <!-- end footer -->

</body>
</html>