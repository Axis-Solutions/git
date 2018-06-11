<?php
require 'userinit.php';
require 'db/dbapi.php';
require 'db/var.php';

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $_SESSION["username"]; ?> - Sales</title>

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
<?php include_once("tpl/user_top_bar.php"); ?>
<!-- end top-bar -->



<!-- MAIN CONTENT -->
<div id="content">

    <div class="page-full-width cf">

         <div class="side-menu fl">

                    <h3><?php echo $_SESSION["username"]; ?></h3>
                    <ul>
                        <li><a href="create_sale.php">Add Sales</a></li>
                        <li><a href="mysales.php">My Sales</a></li>
                    </ul>
                  
                </div>
        <!-- end side-menu -->

        <div class="side-content fr">

            <div class="content-module">

                <div class="content-module-heading cf">

                    <h3 class="fl">Sales</h3>
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

                            <input type="hidden" name="table" value="stock_sales">
                            <input type="hidden" name="return" value="view_sales.php">
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
                                <?php

                                $userlogged = $_SESSION["id"];
                                $SQL = "SELECT Receipt_no FROM  receipt_header_info where CreatedBy=$userlogged ORDER BY id DESC ";
                                if (isset($_POST['Search']) AND trim($_POST['searchtxt']) != "") {

                                    $SQL = "SELECT Receipt_no FROM  receipt_header_info WHERE CreatedBy=$userlogged and Customer LIKE '%" . $_POST['searchtxt'] . "%' ORDER BY id DESC ";


                                }

                                $tbl_name = "receipt_header_info";        //your table name

                                // How many adjacent pages should be shown on each side?

                                $adjacents = 3;


                                /*

                                   First get total number of rows in data table.

                                   If you have a WHERE clause in your query, make sure you mirror it here.

                                */

                                $query = "SELECT COUNT(Receipt_no) as num FROM $tbl_name where CreatedBy=$userlogged  ";
                                if (isset($_POST['Search']) AND trim($_POST['searchtxt']) != "") {

                                    $query = "SELECT COUNT(Receipt_no) as num FROM receipt_header_info WHERE CreatedBy=$userlogged and Customer LIKE '%" . $_POST['searchtxt'] . "%'";


                                }


                                $total_pages = mysqli_fetch_array(mysqli_query($db_sec->connection, $query));
                                $total_pages = $total_pages['num'];


                                /* Setup vars for query. */

                                $targetpage = "view_sales.php";    //your file name  (the name of this file)

                                $limit = 10;                                //how many items to show per page
                                if (isset($_GET['limit']) && is_numeric($_GET['limit'])) {
                                    $limit = $_GET['limit'];
                                    $_GET['limit'] = 10;
                                }

                                $page = isset($_GET['page']) ? $_GET['page'] : 0;


                                if ($page)

                                    $start = ($page - 1) * $limit;            //first item to display on this page

                                else

                                    $start = 0;                                //if no page var is given, set start to 0


                                /* Get data. */

                                $sql = "SELECT * FROM receipt_header_info where status='Sold' and CreatedBy=$userlogged ORDER BY CreatedDate desc LIMIT $start, $limit  ";
                                if (isset($_POST['Search']) AND trim($_POST['searchtxt']) != "") {

                                    $sql = "SELECT * FROM receipt_header_info WHERE  status='Sold' and CreatedBy=$userlogged and Customer LIKE '%" . $_POST['searchtxt'] . "%'  ORDER BY CreatedDate desc LIMIT $start, $limit";


                                }


                                $result = mysqli_query($db_sec->connection, $sql);


                                /* Setup page vars for display. */

                                if ($page == 0) $page = 1;                    //if no page var is given, default to 1.

                                $prev = $page - 1;                            //previous page is page - 1

                                $next = $page + 1;                            //next page is page + 1

                                $lastpage = ceil($total_pages / $limit);        //lastpage is = total pages / items per page, rounded up.

                                $lpm1 = $lastpage - 1;                        //last page minus 1


                                /*

                                    Now we apply our rules and draw the pagination object.

                                    We're actually saving the code to a variable in case we want to draw it more than once.

                                */

                                $pagination = "";

                                if ($lastpage > 1) {

                                    $pagination .= "<div >";

                                    //previous button

                                    if ($page > 1)

                                        $pagination .= "<a href=\"view_sales.php?page=$prev&limit=$limit\" class=my_pagination >Previous</a>";

                                    else

                                        $pagination .= "<span class=my_pagination>Previous</span>";


                                    //pages

                                    if ($lastpage < 7 + ($adjacents * 2))    //not enough pages to bother breaking it up

                                    {

                                        for ($counter = 1; $counter <= $lastpage; $counter++) {

                                            if ($counter == $page)

                                                $pagination .= "<span class=my_pagination>$counter</span>";

                                            else

                                                $pagination .= "<a href=\"view_sales.php?page=$counter&limit=$limit\" class=my_pagination>$counter</a>";

                                        }

                                    } elseif ($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some

                                    {

                                        //close to beginning; only hide later pages

                                        if ($page < 1 + ($adjacents * 2)) {

                                            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {

                                                if ($counter == $page)

                                                    $pagination .= "<span class=my_pagination>$counter</span>";

                                                else

                                                    $pagination .= "<a href=\"view_sales.php?page=$counter&limit=$limit\" class=my_pagination>$counter</a>";

                                            }

                                            $pagination .= "...";

                                            $pagination .= "<a href=\"view_sales.php?page=$lpm1&limit=$limit\" class=my_pagination>$lpm1</a>";

                                            $pagination .= "<a href=\"view_sales.php?page=$lastpage&limit=$limit\" class=my_pagination>$lastpage</a>";

                                        } //in middle; hide some front and some back

                                        elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {

                                            $pagination .= "<a href=\"view_sales.php?page=1&limit=$limit\" class=my_pagination>1</a>";

                                            $pagination .= "<a href=\"view_sales.php?page=2&limit=$limit\" class=my_pagination>2</a>";

                                            $pagination .= "...";

                                            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {

                                                if ($counter == $page)

                                                    $pagination .= "<span  class=my_pagination>$counter</span>";

                                                else

                                                    $pagination .= "<a href=\"view_sales.php?page=$counter&limit=$limit\" class=my_pagination>$counter</a>";

                                            }

                                            $pagination .= "...";

                                            $pagination .= "<a href=\"view_sales.php?page=$lpm1&limit=$limit\" class=my_pagination>$lpm1</a>";

                                            $pagination .= "<a href=\"view_sales.php?page=$lastpage&limit=$limit\" class=my_pagination>$lastpage</a>";

                                        } //close to end; only hide early pages

                                        else {

                                            $pagination .= "<a href=\"$view_sales.php?page=1&limit=$limit\" class=my_pagination>1</a>";

                                            $pagination .= "<a href=\"$view_sales.php?page=2&limit=$limit\" class=my_pagination>2</a>";

                                            $pagination .= "...";

                                            for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {

                                                if ($counter == $page)

                                                    $pagination .= "<span class=my_pagination >$counter</span>";

                                                else

                                                    $pagination .= "<a href=\"$targetpage?page=$counter&limit=$limit\" class=my_pagination>$counter</a>";

                                            }

                                        }

                                    }


                                    //next button

                                    if ($page < $counter - 1)

                                        $pagination .= "<a href=\"view_sales.php?page=$next&limit=$limit\" class=my_pagination>Next</a>";

                                    else

                                        $pagination .= "<span class= my_pagination >Next</span>";

                                    $pagination .= "</div>\n";

                                }

                                ?>
                                <tr>
                                     <th>Receipt #</th>
                                    <th>Customer</th>
                                    <th>Total Value</th>
                                    <th>Discount</th>
                                    <th>Payable Amount</th>
                                    <th>Balance</th>
                                     <th>Payment Mode</th>
                                  
                                  
                                </tr>

                                <?php $i = 1;
                                $no = $page - 1;
                                $no = $no * $limit;
                                while ($row = mysqli_fetch_array($result)) {
                                    if($row['payment_mode']=="partly_cr")
                                    {
                                        $paymnt_mode = "Partly Credit";
                                    }
                                    else{
                                        $paymnt_mode = $row['payment_mode'];
                                    }
                                    ?>
                                    <tr id="<?php echo $row['Receipt_no']; ?>">
                                      
                                        <td><a href='add_sales_print.php?sid=<?php echo $row['Receipt_no']; ?>'> <?php echo $row['Receipt_no']; ?></a></td>
                                       <td> <?php echo $row['Customer']; ?></td>
                                        <td> <?php echo $row['NetValue']; ?></td>
                                        <td> <?php echo $row['TotalDiscount']; ?></td>
                                         <td> <?php echo $row['Payable_amount']; ?></td>
                                          <td><?php echo $row['Outstanding_balance']; ?></td>
                                          <td> <?php echo $paymnt_mode; ?></td>
                                         
                                        
                                      

                                    </tr>
                                    <?php $i++;
                                } ?>
                                <tr>

                                    <td align="center">
                                        <div style="margin-left:20px;"><?php echo $pagination; ?></div>
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
            

            
            <script>
                $(document).ready(function(){
                    $(".js-example-basic-multiple").select2();
                     $('#modal-normal').hide();  
                    $(".cancel_rec").click(function(ev){
                        var rec_no = $(this).closest('tr').attr('id');
                        //console.log(rec_no);
                        ev.preventDefault();
                        $("#rec_no").html(rec_no);
                      $('#modal-normal').modal('show');  
                    });
                    
                    $(".confirm_cancel").click(function(ev){
                        ev.preventDefault();
                      var receipt_no =  $("#rec_no").html();
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