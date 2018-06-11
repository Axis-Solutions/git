<?php
include_once("db/dbapi.php");
include_once("db/var.php");
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WEBPOS - View UOM</title>

    <!-- Stylesheets -->
    <!---->
    <link rel="stylesheet" href="css/style.css">

    <!-- Optimize for mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- jQuery & JS files -->
    <?php include_once("tpl/common_js.php"); ?>
    <script src="js/script.js"></script>


    <script LANGUAGE="JavaScript">
        <!--
        // Nannette Thacker http://www.shiningstar.net
        function confirmSubmit() {
            var agree = confirm("Are you sure you wish to Delete this Entry?");
            if (agree)
                return true;
            else
                return false;
        }

        function confirmDeleteSubmit() {
            var flag = 0;
            var field = document.forms.deletefiles;
            for (i = 0; i < field.length; i++) {
                if (field[i].checked == true) {
                    flag = flag + 1;

                }

            }
            if (flag < 1) {
                alert("You must check one and only one checkbox!");
                return false;
            } else {
                var agree = confirm("Are you sure you wish to Delete Selected Record?");
                if (agree)

                    document.deletefiles.submit();
                else
                    return false;

            }
        }
        function confirmLimitSubmit() {
            if (document.getElementById('search_limit').value != "") {

                document.limit_go.submit();

            } else {
                return false;
            }
        }


        function checkAll() {

            var field = document.forms.deletefiles;
            for (i = 0; i < field.length; i++)
                field[i].checked = true;
        }

        function uncheckAll() {
            var field = document.forms.deletefiles;
            for (i = 0; i < field.length; i++)
                field[i].checked = false;
        }
        // -->
    </script>
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
                    },
                    contact1: {
                        minlength: 3,
                        maxlength: 20
                    },
                    contact2: {
                        minlength: 3,
                        maxlength: 20
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a supplier Name",
                        minlength: "supplier must consist of at least 3 characters"
                    },
                    address: {
                        minlength: "supplier Address must be at least 3 characters long",
                        maxlength: "supplier Address must be at least 3 characters long"
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

                    <h3 class="fl">Stock UOM</h3>
                    <span class="fr expand-collapse-text">Click to collapse</span>
                    <span class="fr expand-collapse-text initial-expand">Click to expand</span>

                </div>
                <!-- end content-module-heading -->

                <div class="content-module-main cf">


                    <table>
                        <form action="" method="post" name="search">
                            <input name="searchtxt" type="text" class="round my_text_box" placeholder="Search">
                            &nbsp;&nbsp;<input name="Search" type="submit" class="my_button round blue   text-upper"
                                               value="Search">
                        </form>
                        <form action="" method="get" name="limit_go">
                            Page per Record<input name="limit" type="text" class="round my_text_box" id="search_limit"
                                                  style="margin-left:5px;"
                                                  value="<?php if (isset($_GET['limit'])) echo $_GET['limit']; else echo "10"; ?>"
                                                  size="3" maxlength="3">
                            <input name="go" type="button" value="Go" class=" round blue my_button  text-upper"
                                   onclick="return confirmLimitSubmit()">
                        </form>

                        <form name="deletefiles" action="delete.php" method="post">

                            <input type="hidden" name="table" value="category_details">
                            <input type="hidden" name="return" value="view_category.php">
                            <input type="button" name="selectall" value="SelectAll"
                                   class="my_button round blue   text-upper" onClick="checkAll()"
                                   style="margin-left:5px;"/>
                            <input type="button" name="unselectall" value="DeSelectAll"
                                   class="my_button round blue   text-upper" onClick="uncheckAll()"
                                   style="margin-left:5px;"/>
                            <input name="dsubmit" type="button" value="Delete Selected"
                                   class="my_button round blue   text-upper" style="margin-left:5px;"
                                   onclick="return confirmDeleteSubmit()"/>


                            <table>
                               
                                <tr>
                                   
                                    <th>UOM</th>
                                    <th>description</th>
                                     <th>Edit /Delete</th>
                                    <th>Select</th>
                                </tr>

                                <?php
								$cat = get_uom();
                             foreach($cat as $row){
                                
                                    ?>
                                    <tr>
                                       
                                        <td><?php echo $row['UOM_DESC']; ?></td>
                                        <td> <?php echo $row['UOM_Detail']; ?></td>
                                        

                                        <td>
                                            <a href="update_category.php?sid=<?php echo $row['id']; ?>&table=category_details&return=view_category.php"
                                               class="table-actions-button ic-table-edit">
                                            </a>
                                            <a onclick="return confirmSubmit()"
                                               href="delete.php?id=<?php echo $row['id']; ?>&table=category_details&return=view_category.php"
                                               class="table-actions-button ic-table-delete"></a>
                                              
                                        </td>
                                        <td><input type="checkbox" value="<?php echo $row['id']; ?>" name="checklist[]"
                                                   id="check_box"/></td>

                                    </tr>
                                    <?php 
                                } ?>
                                <tr>

                                    <td align="center">
                                        <div style="margin-left:20px;"><?php ; ?></div>
                                    </td>

                                </tr>
                            </table>
                        </form>


                </div>
            </div>
            <div id="footer">
                <p>Any Queries send to <a href="mailto:takundamadzamba@gmail.com">+263773629282</a>.
                </p>

            </div>
            <!-- end footer -->

</body>
</html>