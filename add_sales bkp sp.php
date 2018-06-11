<?php
include_once("init.php");
require 'db/dbapi.php';
require 'db/var.php';
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>WEBPOS - Create Sale</title>

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
                    <li><a href="view_sales.php" class="active-tab  sales-tab">Sales</a></li>
                    <li><a href="view_customers.php" class=" customers-tab">Customers</a></li>
                    <li><a href="view_purchase.php" class="purchase-tab">Purchase</a></li>
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

                    <h3>Sales Management</h3>
                    <ul>
                        <li><a href="add_sales.php">Add Sales</a></li>
                        <li><a href="view_sales.php">View Sales</a></li>
                    </ul>
                    <h3>Help Term</h3>
                    <ul>
                        <li><a> Home (Ctrl+0)</a></li>
                        <li><a> Add sales (Ctrl+)</a></li>
                        <li><a> Save (Ctrl+s)</a></li>
                        <li><a> Print (Ctrl+enter)</a></li>

                    </ul>
                </div>
                <!-- end side-menu -->


                <div class="side-content fr">

                    <div class="content-module">

                        <div class="content-module-heading cf">

                            <h3 class="fl">Add Sales</h3>
                            <span class="fr expand-collapse-text">Click to collapse</span>
                            <span class="fr expand-collapse-text initial-expand">Click to expand</span>

                        </div>
                        <!-- end content-module-heading -->

                        <div class="content-module-main cf">


                            <form name="form1" method="post" id="form1" action="">
                                <input type="hidden" id="posnic_total">

                                <p><strong>Add Sales/Product </strong> - Add New ( Control +2)</p>
                                <table class="form" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                     
                                    </tr>
                                    <tr>
                                        <td>Customer:</td>
                                        <td> <input name="customer" placeholder="Customer Name"  type="text" id="customer"
                                                   maxlength="200" class="round default-width-input"/></td>

                                        <td>Address:</td>
                                        <td><input name="address" placeholder="Customer Address" type="text" id="address"
                                                   maxlength="200" class="round default-width-input"/></td>

                                        <td>contact:</td>
                                        <td><input name="contact" placeholder="Enter Contact" type="text" id="contact1"
                                                   maxlength="200" class="round default-width-input"  style="width:120px "/></td>

                                    </tr>
                                </table>
                                <input type="hidden" id="guid">
                                <input type="hidden" id="edit_guid">
                                <table class="form">
                                    <tr>
                                        <td>Item:</td>
                                        <td>Quantity:</td>
                                        <td>Price:</td>

                                        <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Cost ($)</td>
                                        <td>&nbsp; </td>
                                    </tr>
                                    <tr>


                                        <td> <select class="js-example-basic-multiple round default-width-input" id="products" name="product" data-placeholder="Select Products Name" >
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

                                    <input type="hidden" id="prod_desc" >
                                     <input type="hidden" id="myTaxCode" >

                                    <td><input name="" type="text" id="quty" maxlength="200"  class="round default-width-input my_with"
                                               /></td>


                                    <td><input name="" type="text" id="sell" readonly maxlength="200"
                                               class="round default-width-input my_with"/>
                                    
                                        <input name="" type="hidden" id="val_in_stock" readonly maxlength="200"
                                               class="round default-width-input my_with"/>
                                    </td>


                                    <td><input name="" type="text" id="total" maxlength="200"  class="round default-width-input"  style="width:120px;  margin-left: 20px"/>
                                    </td>
                                    <td><input type="button"  id="add_new_code"  style="margin-left:30px; width:30px;height:30px;border:none;background:url(images/add_new.png)"
                                               class="round">

                                        </tr>
                                </table>
                                <table class="item_copy_final" id="item_copy_final">
                                    <tr>
                                        <td style="color:green; width:20%;"><strong>Item (Upload):</td>
                                        <td style="color:green; width:20%;"><strong>Qty (Upload):</td>
                                        <td style="color:green;width:20%;"><strong>Price (Upload):</td>
                                        <td style="color:green;width:20%;"><strong>Total Cst($)</td>
                                        <td style="color:green; width:20%;"><strong> &nbsp;Command</td>
                                    </tr>
                                    </tr>
                                </table>
                               

                                <table class="form">
                                    <tr>
                                        <td> DISCOUNTS&nbsp;</td>
                                        <td>&nbsp; </td>
                                        <td><input type="checkbox" name="checkbox" class="checkbx" id="round">Is Discounted?</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp; </td>
                                        <td>Discount %<input type="text"  maxlength="5" class="round" name="discount"
                                                             id="discount_perc">
                                        </td>

                                        <td>Discount Amount:<input type="text" readonly class="round" id="discount_amount" name="dis_amount">
                                        </td>
                                        <td>&nbsp; </td>

                                        <td>&nbsp; </td>
                                        <td>&nbsp; </td>
                                        <td>Grand Total:<input type="hidden" readonly id="grand_total"
                                                               name="subtotal">
                                            <input type="text" id="main_grand_total" readonly
                                                   class="round default-width-input" style="width: 120px">
                                        </td>
                                        <td>&nbsp; </td>

                                    </tr>
                                        <tr>
                                            <td>Payment Mode  &nbsp;</td>
                                        
                                        <td>
                                            <select class="js-example-basic-multiple round default-width-input" name="mode" id="payment_mode" data-placeholder="Choose Payment mode">
                                                <option value=""></option>
                                                <option value="cash">Cash</option>
                                                <!--<option value="partly_cr">Partly Cash</option>-->
												<option value="swipe">Swipe</option>
                                                <option value="credit">Credit</option>
                                            </select>
                                        </td>
                                        <td>
                                            Due Date:<input type="text" name="duedate" id="date_due"
                                                            value="<?php echo date('d-m-Y'); ?>" class="round">
                                        </td>




                                        <td>&nbsp; </td>
                                        <td>&nbsp; </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp; </td>
                                        <td>Payment:<input type="text" class="round" name="payment" id="payment">
                                        </td>

                                        <td>Balance:<input type="text" class="round" readonly id="balance"
                                                           name="balance">
                                        </td>
                                        <td>&nbsp; </td>

                                        <td>&nbsp; </td>
                                        <td>&nbsp; </td>
                                        <td>Payable Amount:
                                            <input type="text" id="payable_amount" readonly name="payable"
                                                   class="round default-width-input" style="width: 120px">
                                        </td>
                                        <td>&nbsp; </td>
                                        <td>&nbsp; </td>
                                        <td>&nbsp; </td>
                                    </tr>
                                </table>

                                <table class="form">
                                    <tr>
                                        <td>
                                            <input class="button round blue image-right ic-add text-upper btnadd" type="submit"
                                                   name="Submit" value="Add">
                                        </td>
                                        <td> (Control + S)
                                            <input class="button round red   text-upper" type="reset" name="Reset"
                                                   value="Reset"></td>
                                        <td>&nbsp; </td>
                                        <td>&nbsp; </td>
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

        <script>
            $(document).ready(function () {
                $(".js-example-basic-multiple").select2();
                
                $(".btnadd").prop("disabled",true); 
               
                 $("#customer").autocomplete("engines/customer_det.php", {
                width: 160,
                autoFill: true,
                selectFirst: true
            });
                
                
                
                $("#customer").blur(function () {

                    var supp_id = $(this).val();
                    console.log(supp_id);
                    $.getJSON("engines/custdet.php?cid=" + supp_id, function (response) {
                        $("#address").val(response.addr);
                        $("#contact1").val(response.contact);


                    });
                });

                $("#products").change(function () {

                    var supp_id = $(this).val();
                    $.getJSON("engines/prodet.php?sid=" + supp_id, function (response) {
                        var in_stock = response.qty;
                        $("#val_in_stock").val(in_stock);
                        if(in_stock<=0){
                            alert("Product out of stock. You can not sell");
                          
                        }
                        else{
                            $("#prod_desc").val(response.desc);
                        $("#sell").val(response.sell);
                       var price = $("#sell").val();
                        var qty = $("#quty").val();
                        $("#myTaxCode").val(response.taxCode);

                        var total = price * qty;
                        $("#total").val(total);
                    }

                    });
                });

                $("#quty").keyup(function () {
                    var value = parseFloat($(this).val());
                    var instock = parseFloat($("#val_in_stock").val());
                    if(value>instock)
                    {
                        alert("Quantity to be sold is more than what is in stock");
                          $("#total").val("");
                    }
                    else{
                    var price = $("#sell").val();
                    var total = (price * value).toFixed(4);
                    $("#total").val(total);
                }
                });

                $(".item_copy_final").hide();

                var totals_array = [];
                var sum = 0;
                var totTaxArray = [];
                $("#add_new_code").click(function () {

                    var product_code = $("#products").val();
                    var prod_name = $("#prod_desc").val();
                    var qty = $("#quty").val();
                    var price = $("#sell").val();
                    var customer = $("#customer").val();
                    var total_value1 = parseFloat($("#total").val()).toFixed(2);
                    var taxCode = $("#myTaxCode").val();
                    
                    if(taxCode === "A"){
                        var lineTax = parseFloat(total_value1 * 0.15);
                        totTaxArray.push(lineTax.toFixed(2));
                    }
                    else{
                        var lineTax = parseFloat(0.00);
                        totTaxArray.push(lineTax);
                    }
                    var  total_value = parseFloat(total_value1).toFixed(2);
                    if (product_code === "" || qty === "" || customer === "" || price==="" || total_value==="")
                    {
                        alert("Make sure Product details  and customer values are provided");
                    } else {
                        $(".item_copy_final").show(1000);
                        var new_row = $('<tr id="' + product_code + '"><td style="width:25%;color:green;"><strong>' + prod_name + '</td><td style="color:red;">' + qty + '</td><td>' + price + '</td><td>' + total_value1 + '</td><td><a  class="btn btn-danger btndeleted" line_total="' + total_value + '"  href="#"><input type="hidden" class="form-control fields disabled" product_code="' + product_code + '" qty="' + qty + '" price="' + price + '" line_tax= "'+lineTax+'" total_value="' + total_value1 + '">&times;</a></td></tr>');
                        $('table.item_copy_final').append(new_row);
                       
                        totals_array.push(total_value);
                        console.log(total_value);
                        sum =sum + parseFloat(total_value);
                        $("#main_grand_total").val(sum.toFixed(2));
                         $("#payable_amount").val($("#main_grand_total").val());
                      //remove product from select tool
                         $("#products option[value='"+product_code+"']").remove();
                    }
                });

                //delete a product linez
                $("table.item_copy_final").on("click", ".btndeleted",function () {
             var line_tot =   $(this).attr("line_total");
            // var lineTax = $(this).attr("line_tax");
            var productCode = $(this).closest('tr').attr('id');
            var pdct_desc = $(this).find(".fields").attr("product_code");
           
             totals_array.pop(line_tot);
                console.log(line_tot);
                    $(this).closest('tr').remove();
                  $("#products").append('<option value="'+productCode+'">'+pdct_desc+'</option>');
                  sum =sum - parseFloat(line_tot);
                   $("#main_grand_total").val(sum.toFixed(2));
                         $("#payable_amount").val($("#main_grand_total").val());
                    return false;
                });

              

                   $("#discount_perc").attr("readonly",true);

                $(".checkbx").change(function () {
                      var grand_total = $("#main_grand_total").val();
                    if (grand_total != "")
                    {
                    if (this.checked) {
                        // means is discounted. Activate % tex
                      $("#discount_perc").attr("readonly",false);
                       $("#payment").val("");
                          $("#balance").val("");
                           $("#payment_mode").val("");
                      
                        
                    }
                    else{
                       $("#discount_perc").val("");
                        $("#discount_perc").attr("readonly",true);
                         $("#payable_amount").val(grand_total);
                         $("#discount_amount").val("");
                         $("#payment").val("");
                          $("#balance").val("");
                           $("#payment_mode").val("");
                    }
                }
                else{
                    alert("Grant Total Amount can not be zero. Please add products first.");
                        $("#discount_perc").val("");
                    }
                });
               
                 $("#discount_perc").keyup(function () {
                    var value = parseFloat($(this).val());
                    var grand_total = $("#main_grand_total").val().toFixed(2);
                 var discount = value/100;
                 var val_disc_amount = (discount*grand_total).toFixed(2);
                 var payable_amount = grand_total - val_disc_amount;
                 $("#discount_amount").val(val_disc_amount);
                 $("#payable_amount").val(payable_amount);
                   // $("#total").val(total);
                });
                
                  $("#payment_mode").change(function () {

                    var mode = $(this).val();
                    var payable_amnt = $("#payable_amount").val();
                    if (payable_amnt != "")
                    {
                        if (mode == "partly_cr")
                        {
                            $("#payment").attr("readonly", false);
                            $("#date_due").show();
                             $("#balance").val("");
                              $("#payment").val("");
                              $(".btnadd").prop("disabled",false); 

                        } 
                        else if (mode == "cash")
                        {
                            $("#date_due").hide();
                            $("#balance").val("Cash Only");
                            $("#payment").val(payable_amnt);
                            
                            $(".btnadd").prop("disabled",false); 
                        } 
                        
                        else if (mode == "credit") {
                            $("#payment").val("Credit Only");
                            $("#payment").attr("readonly", true);
                            $("#balance").val(payable_amnt);
                            $("#date_due").show();
                            $(".btnadd").prop("disabled",false); 
                        }
						
						                    }

				
											else
                    {
                        alert("Payable Amount can not be zero. Please add products first.");
                        $("#payment_mode").val("");
                    }
                });
                
                //if payment mode is partly cash
                  $("#payment").on("change", function () {
                     var pay = parseFloat($(this).val());
                      var tot = parseFloat($("#payable_amount").val());
                    var payment_mode = $("#payment_mode").val();
                    if(payment_mode=="partly_cr")
                    {
                        if(pay<tot){
                    var bal = (tot - pay).toFixed(2);
                    $("#balance").val(bal);
                }
                else {
                   alert("If mode is partly cash you can only pay amout less than total cost of supply. If your cash amount is greater than total supply cost. Change mode to Cash."); 
                   $("#balance").val("");
                   $("#payment").val("");
                }
                }
                
                });
                
                $(".btnadd").click(function(ev){
                ev.preventDefault();
				$(".btnadd").prop("disabled",true); 
                 var products = [];
                function FormField()
            {
                this.product_code;
                 this.price;
                this.qty;
                this.taxCode;
                this.line_total;

            };
            
            // loop thru all products
            $.each($("table.item_copy_final").find(".fields"), function (index,value) {

                var fl = new FormField();
             fl.product_code =  $(value).attr('product_code');
              fl.qty = $(value).attr('qty');
                 fl.price =  $(value).attr('price');
                fl.line_total = $(value).attr('total_value');
         products.push(fl);
          });
          $.post("engines/addsale.php",
            {
                allproducts:products,
                payment_mode:$("#payment_mode").val(),
                due_date:$("#date_due").val(),
                grand_total:parseFloat($("#main_grand_total").val()),
                discount_amount:$("#discount_amount").val(),
                payable_amount:$("#payable_amount").val(),
                amnt_paid: parseFloat($("#payment").val()),
                oustanding: parseFloat($("#balance").val()),
                receipt_NO:$("#rec_no").val(),
                transDate: $("#test1").val(),
                customer: $("#customer").val(),
                 address: $("#address").val(),
                 contact: $("#contact1").val()
                
                },
                function(response){
                 var res = $.parseJSON(response);
                 console.log(res);
                  if(res.status==="ok")
                  {
                        $("#response").html('<div style="color:green">'+res.msg+'<\div>');
                    }
                    else{
                        $("#response").html('<div style="color:red">'+res.msg+'<\div>');
                                                 }
                });
            
                });


            });
        </script>
        <!-- end footer -->

    </body>
</html>