<?php include_once("init.php");

require "db/dbapi.php";
require 'db/var.php';

$det = get_store_details();
$vatNum = $det[0]['vat'];
$bpnNum = $det[0]['bpn'];
$key = $det[0]['fiscal_key'];

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WEBPOS - FISCAL CARD</title>

    <!-- Stylesheets -->

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cmxform.css">
    <link rel="stylesheet" href="js/lib/validationEngine.jquery.css">

    <!-- Scripts -->
    <script src="js/lib/jquery.min.js" type="text/javascript"></script>
    <script src="js/lib/jquery.validate.min.js" type="text/javascript"></script>

   
    <!-- Optimize for mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>


<!--    Only Index Page for Analytics   -->

<!-- TOP BAR -->
<div id="top-bar">

    <div class="page-full-width">

        <!--<a href="#" class="round button dark ic-left-arrow image-left ">See shortcuts</a>-->

    </div>
    <!-- end full-width -->

</div>
<!-- end top-bar -->


<!-- HEADER -->
<div id="header">

    <div class="page-full-width cf">

        <div id="login-intro" class="fl">

            <h1>FISCAL CARD SETTING </h1>


        </div>
        <!-- login-intro -->

        <!-- Change this image to your own company's logo -->
        <!-- The logo will automatically be resized to 39px height. -->
        <a href="#" id="company-branding" class="fr"><img src="<?php if (isset($_SESSION['logo'])) {
                echo "upload/" . $_SESSION['logo'];
            } else {
                echo "upload/posnic.png";
            } ?>" alt="Point of Sale"/></a>

    </div>
    <!-- end full-width -->

</div>
<!-- end header -->


<?php 
if(empty($det) || $vatNum=="" || $bpnNum == "" )
{
   echo "VAT number or BPNumber missing. Click <a href='update_details.php'>here</a> to set them.";
    
  
}
elseif($key !=""){
    echo "Key already set. Click <a href='dashboard.php'>here</a> to go back to home page.";
}
else{
    
 ?>

<!-- MAIN CONTENT -->
<div id="content" style="width:30%; margin-left: 30%;">


    <form action="" method="POST" id="fiscalKey" class="cmxform" autocomplete="off">
      
        <table>
           
          
            <tr style="width:30%; text-align: center">
                <td >
                    <p>
                        <label>Card Number</label>
                        <input type="text" name="cardNum" id="cardNum" class="round full-width-input"
                                autofocus/>
                    </p>

                </td>
                
                <td>
                    <p>
                        <label>VAT Number</label>
                        <input type="text" name="vat" id="vat" readonly="true" class="round full-width-input"
                               value="<?php echo $det [0]["vat"] ; ?>" autofocus/>
                    </p>

                </td>
                <td>
                     <p>
                        <label>BP Number</label>
                        <input type="text" name="bpn" id="bpn" readonly="true" class="round full-width-input"
                               value="<?php echo $det [0]["bpn"] ; ?>" autofocus/>
                    </p>
                    
                   </td>
            </tr>
            
            <tr>
                <td>


                    <!--<a href="dashboard.php" class="button round blue image-right ic-right-arrow">LOG IN</a>-->
                    <input type="submit" class="button round blue" name="submit" id="set_card"
                           value="Set Card"/>
                </td>
                <td><a href="dashboard.php" class="button blue round side-content">Dashboard</a></td>
            </tr>
        </table>

    </form>
    
</div>

<?php } ?>
<!-- end content -->


<!-- FOOTER -->
<div id="footer">
 
    <p>Any Queries send to <a href="mailto:takundamadzamba@gmail.com">+263773629282</a>.
    </p>


</div>
<!-- end footer -->
<script type="text/javascript">
$(document).ready(function() {
    

    
    
    $('#set_card').click(function(ev){
		
		ev.preventDefault();
		
		$.post("engines/set_key.php",$("#fiscalKey").serialize(),function(response){
		
		alert(response);	
	});
    });
        

});


 </script>
</body>
</html>

