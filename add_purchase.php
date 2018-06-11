<?php
include_once("init.php");
require 'db/dbapi.php';
require 'db/var.php';
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>WEB POS - Add Purchase</title>

        <!-- Stylesheets -->

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
        <script src="js/add_puchase.js"></script>
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
                    <li><a href="view_purchase.php" class="active-tab purchase-tab">Purchase</a></li>
                    <li><a href="view_supplier.php" class=" supplier-tab">Supplier</a></li>
                    <li><a href="view_product.php" class="stock-tab">Stocks / Products</a></li>
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

                    <h3>Purchase Management</h3>
                    <ul>
                        <li><a href="add_purchase.php">Add Purchase</a></li>
                        <li><a href="view_purchase.php">View Supplies </a></li>
                        <li><a href="view_purchase.php">View Returns To Suppliers </a></li>
                    </ul>

                </div>
                <!-- end side-menu -->

                <div class="side-content fr">

                    <div class="content-module">

                        <div class="content-module-heading cf">

                            <h3 class="fl">Add Purchase</h3>
                            <span class="fr expand-collapse-text">Click to collapse</span>
                            <span class="fr expand-collapse-text initial-expand">Click to expand</span>

                        </div>
                        <!-- end content-module-heading -->

                        <div class="content-module-main cf">

                            <form name="form1" method="post" id="form1" action="">
                                <input type="hidden" id="posnic_total">

                                <p><strong>Add Stock/Product </strong> - Add New ( Control +2)</p>
                                <table class="form" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                                
                                        <?php $current_id = get_last_transID()+1; ?>
 
                                        <td>Transaction Date:</td>
                                        <td><input name="date" id="test1" placeholder="" value="<?php echo date('d-m-Y'); ?>"
                                                   type="text" id="name" maxlength="200" class="round default-width-input"/>
                                        </td>
                                        <td><span class="man"></span>Ref No:</td>
                                        <td><input name="bill_no" placeholder="ENTER BILL NO" type="text" id="bill_no"
                                                   maxlength="200" readonly="true"  value="<?php echo "PO".$current_id; ?>" class="round default-width-input" style="width:120px "/></td>

                                    </tr>
                                    <tr>
                                        <td><span class="man">*</span>Supplier:</td>
                                        <td><input name="supplier" placeholder="ENTER SUPPLIER" type="text" id="supplier"
                                                   maxlength="200" class="round default-width-input" style="width:130px "/></td>

                                        <td>Address:</td>
                                        <td><input name="address" placeholder="ENTER ADDRESS" type="text" id="address"
                                                   maxlength="200" class="round default-width-input"/></td>

                                        <td>contact:</td>
                                        <td><input name="contact" placeholder="ENTER CONTACT" type="text" id="contact1"
                                                   maxlength="200" class="round default-width-input"
                                                   onkeypress="return numbersonly(event)" style="width:120px "/></td>

                                    </tr>
                                </table>
                                <input type="hidden" id="guid">
                                <input type="hidden" id="edit_guid">
                                <table class="form">
                                    <tr>
                                        <td>Item:</td>
                                        <td>Quantity:</td>
                                        <td>Cost:</td>
                                        <td>Selling:</td>
                                        <td>Available Stock:</td>
                                        <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Cost ($)</td>
                                        <td> &nbsp;</td>
                                    </tr>
                                    <tr>


                                        <td> <select class="js-example-basic-multiple round default-width-input" id="item" name="product" data-placeholder="Select Products Name" >
                                                <option value="">Choose Product </option>
                                                <?php
                                                $prods = get_all_prods();
                                                foreach ($prods as $prd) {
                                                    $product_ID = $prd["stock_id"];
                                                    $prod_name = $prd["stock_name"];
                                                    ?>
                                                    <option value="<?php echo $product_ID; ?>"><?php echo $prod_name; ?> </option>
                                                <?php } ?>
                                            </select>  </td>
                                        
                                    <input type="hidden" id="prod_desc">

                                        <td><input name="" type="text" id="quty" maxlength="200"
                                                   class="round default-width-input my_with"
                                                /></td>

                                        <td><input name="" type="text" id="cost" maxlength="200"
                                                   class="round default-width-input my_with"/></td>


                                        <td><input name="" type="text" id="sell" readonly="readonly" maxlength="200"
                                                   class="round default-width-input my_with"/></td>


                                        <td><input name="" type="text" id="stock" readonly="readonly" maxlength="200"
                                                   class="round  my_with"/></td>


                                        <td><input name="" type="text" id="total" maxlength="200  class="round default-width-input " style="width:120px;  margin-left: 20px"/>
                                        </td>
                                        <td><input type="button"  id="add_new_code"  style="margin-left:30px; width:30px;height:30px;border:none;background:url(images/add_new.png)"
                                                   class="round">

                                    </tr>
                                </table>

                                <table class="item_copy_final" id="item_copy_final">
                                    <tr>
                                        <td style="color:green"><strong>Item (Upload):</td>
                                        <td style="color:green"><strong>Qty (Upload):</td>
                                        <td style="color:green"><strong>Cst(Upload):</td>
                                        <td style="color:green"><strong>Sell (Upload):</td>
                                        <td style="color:green"><strong>Total Cst($)</td>
                                        <td style="color:green"><strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Supplier</td>
                                        <td style="color:green"><strong> &nbsp;Command</td>
                                    </tr>
                                    </tr>
                                </table>


                                <table>
                                    <tr>
                                        <td>Mode &nbsp;</td>
                                        <td>
                                            <select class="js-example-basic-multiple round default-width-input" name="mode" id="payment_mode" data-placeholder="Choose Payment mode">
                                                <option value=""></option>
                                                <option value="cash">Cash</option>
                                                <option value="partly_cr">Partly Cash</option>
                                                <option value="credit">Credit</option>
                                            </select>
                                        </td>
                                        <td id="date_due">
                                            Due Date:<input type="text" name="duedate" id="test2"
                                                            value="<?php echo date('d-m-Y'); ?>" class="round">
                                        </td>
                                        <td> &nbsp;</td>
                                        <td> &nbsp;</td>


                                        <td> &nbsp;</td>
                                        <td> &nbsp;</td>
                                        <td> &nbsp;</td>
                                    </tr>
                                </table>
                                <table class="form">
                                    <tr>
                                        <td> &nbsp;</td>
                                        <td>Payment:<input type="text" class="round"  name="payment" id="payment">
                                        </td>
                                        <td> &nbsp;</td>
                                        <td>Balance:<input type="text" class="round" id="balance" readonly="readonly"
                                                           name="balance">
                                        </td>
                                        <td> &nbsp;</td>

                                        <td> &nbsp;</td>
                                        <td> &nbsp;</td>
                                        <td> &nbsp;</td>
                                        <td> &nbsp;</td>
                                        <td>Grand Total:
                                            <input type="text" id="main_grand_total" class="round default-width-input"
                                                   readonly="readonly"
                                                   style="width: 120px">
                                        </td>
                                    </tr>
                                </table>

                                <table class="form">
                                    <tr>
                                        <td>
                                            <input class="button round blue image-right ic-add text-upper btnAddPurchase" id="btnAddPurchase" type="submit"
                                                   name="Submit" value="Add">
                                        </td>
                                        <td> 
                                            <input class="button round red text-upper" type="reset" name="Reset"
                                                   value="Reset"></td>
                                        <td> &nbsp;</td>
                                        <td> &nbsp;</td>
                                    </tr>
                                </table>
                                <div id="response"> </div>
                            </form>
                        </div>
                        <!-- end content-module-main -->


                    </div>
                    <!-- end content-module -->


                </div>
            </div>
            <!-- end full-width -->

        </div>
        <!-- end content -->


        <!-- FOOTER -->
        <div id="footer">
            <p>Any Queries send to <a href="mailto:takundamadzamba@gmail.com">+263773629282</a>.
            </p>

        </div>
        <script type="text/javascript">
            $(".js-example-basic-multiple").select2();
            $(document).ready(function () {
                $("#date_due").hide();
                 $("#payment").attr("readonly", true);
                // $('#btnAddPurchase').prop('disabled', true);

                $("#item").change(function () {
                    var supp_id = $(this).val();
                    $.getJSON("engines/prodet.php?sid=" + supp_id, function (response) {
                        $("#cost").val(response.cost);
                        $("#sell").val(response.sell);
                        $("#stock").val(response.qty);
                        

                        var cost = $("#cost").val();
                        var qty = $("#quty").val();

                        var total = cost * qty;
                        $("#total").val(total);


                    });
                });

                $("#quty").keyup(function () {
                    var value = $(this).val();
                    var cost = $("#cost").val();
                    var total = cost * value;
                    $("#total").val(total);
                });
                $("#btn_newstk").click(function (e) {
                    e.preventDefault();
                    $.post("engines/new_stock.php", $("#form1").serialize(), function (response) {
                        alert(response);
                    });
                });

                $(".item_copy_final").hide();

                var totals_array = [];
                var sum = 0;
                $("#add_new_code").click(function () {

                    var product_code = $("#item").val();
                    var qty = $("#quty").val();
                    var cost = $("#cost").val();
                    var selling = $("#sell").val();
                    var supplier = $("#supplier").val();
                    var total_value = $("#total").val();
                    var in_stock = $("#stock").val();
                    if (product_code === "" || qty === "" || supplier === "")
                    {
                        alert("Make sure Product name, quantity to be supplied and Supplier values are provided");
                    } else {
                        $(".item_copy_final").show(1000);
                        var new_row = $('<tr id="' + product_code + '"><td style="width:25%;color:green;"><strong>' + product_code + '</td><td style="color:red;">' + qty + '</td><td>' + cost + '</td><td>' + selling + '</td><td>' + total_value + '</td><td>' + supplier + '</td><td><a  class="btn btn-danger btndeleted"  href="#"><input type="hidden" class="form-control fields disabled" product_code="' + product_code + '" qty="' + qty + '" sell="' + selling + '" in_stock="'+in_stock+'" supplier="' + supplier + '" total_value="' + total_value + '" cost="' + cost + '">&times;</a></td></tr>');
                        $('table.item_copy_final').append(new_row);
                        totals_array.push(total_value);

                        for (var i = 0; i < totals_array.length; i++) {
                            sum += totals_array[i] << 0;
                        }
                        $("#main_grand_total").val(sum);
                        sum = 0;
                    }
                });

                //delete a poroduct line
                $("table.item_copy_final").on("click", ".btndeleted", function () {
                    var trid = $(this).closest('tr').attr('id');
                    $(this).closest('tr').remove();
                    console.log('table row id: ' + trid + ' removed');
                    console.log(totals_array);
                    return false;
                });
                
                
                 
                $("#payment_mode").change(function () 
                {
                    var mode = $(this).val();
                    var grand_total = $("#main_grand_total").val();
                    if(grand_total!="")
                    {
                    if (mode == "partly_cr") 
                    {
                        $("#payment").attr("readonly", false);
                        $("#date_due").show();
                        $("#balance").val("");
                        $("#payment").val("");
                        
                        
                    } 
                    else if (mode == "cash")
                    {
                        $("#date_due").hide();
                       $("#balance").val("Cash Only");
                       $("#payment").val(grand_total);
                        $("#payment").attr("readonly", true);
                    } 
                    else if (mode == "credit") {
                        $("#payment").val("Credit Only");
                        $("#payment").attr("readonly", true);
                         $("#balance").val(grand_total);
                         $("#date_due").show();
                    }
                }
                        else 
                        {
                            alert("Total Amount due can not be zero. Please add products first.");
                            $("#payment_mode").val("");
                        }
                });

                $("#payment").on("change", function () {
                     var pay = parseFloat($(this).val());
                      var tot = parseFloat($("#main_grand_total").val());
                    var payment_mode = $("#payment_mode").val();
                    if(payment_mode=="partly_cr")
                    {
                        if(pay<tot){
                    var bal = tot - pay;
                    $("#balance").val(bal);
                }
                else {
                   alert("If mode is partly cash you can only pay amout less than total cost of supply. If your cash amount is greater than total supply cost. Change mode to Cash."); 
                }
                }
                
                   
                });
                
                
                
                
                $(".btnAddPurchase").click(function(e){
                e.preventDefault();
                var products = [];
                function FormField()
            {
                this.product_code;
                this.stock_in_qty;
                this.cost;
                 this.sell;
                this.avail;
                this.supplier;
                this.line_total;

            };
            
            // loop thru all products
            $.each($("table.item_copy_final").find(".fields"), function (index, value) {

                var fl = new FormField();
             fl.product_code =  $(value).attr('product_code');
              fl.stock_in_qty = $(value).attr('qty');
                fl.cost  =  $(value).attr('cost');
                 fl.sell =  $(value).attr('sell');
                fl.avail =  $(value).attr('in_stock');
                fl.supplier =  $(value).attr('supplier');
                fl.line_total = $(value).attr('total_value');
         products.push(fl);
             
            });
            
            $.post("engines/addpurchase.php",
            {
                allproducts:products,
                payment_mode:$("#payment_mode").val(),
                due_date:$("#test2").val(),
                grand_total:parseFloat($("#main_grand_total").val()),
                amnt_paid: parseFloat($("#payment").val()),
                oustanding: parseFloat($("#balance").val()),
                TransID:$("#bill_no").val(),
                transDate: $("#test1").val(),
                supplier: $("#supplier").val(),
                address:$("#address").val(),
                contact:$("#contact1").val() 
                
                },
                function(response){
                   var res = $.parseJSON(response);
                  if(res.status==="ok")
                  {
                      $("#response").html('<div style="color:green;">'+res.msg+'<\div>');
                    }
                    else{$("#response").html('<div style="color:red;">'+res.msg+'<\div>');
                        
                         }
                });
            console.log(products);
            
            });
            
            });
        </script>

        <!-- end footer -->

    </body>
</html>