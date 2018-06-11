<?php include_once("init.php");

require "db/dbapi.php";
require 'db/var.php';

$det = get_swipe_countdown();



?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WEBPOS - Login to Control Panel</title>

    <!-- Stylesheets -->

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cmxform.css">
    <link rel="stylesheet" href="js/lib/validationEngine.jquery.css">

    <!-- Scripts -->
    <script src="js/lib/jquery.min.js" type="text/javascript"></script>
    <script src="js/lib/jquery.validate.min.js" type="text/javascript"></script>

    <script>
        /*$.validator.setDefaults({
         submitHandler: function() { alert("submitted!"); }
         });*/

        $(document).ready(function () {

            // validate signup form on keyup and submit
            $("#login-form").validate({
                rules: {
                    seconds: {
                        required: true,
                       
                    },
                   
                },
                messages: {
                    seconds: {
                        required: "Please select swipe countdown",
                       
                    },
                   
                }
            });

        });

    </script>

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

            <h1>Swipe Setting </h1>


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
if(empty($det))
{
    ?>
    <div id="content">


    <form action="" method="POST" id="login-form" class="cmxform form_create_store" autocomplete="off">
      
        <table>
            <tr>
                <td>

                    <p>
                        <label>Swipe Countdown Time</label>
                        <select class="js-example-basic-multiple round default-width-input" name="seconds" id="seconds" data-placeholder="Choose Payment mode">
                                                <option value=""></option>
                                                <option value="30">30</option>
                                                <option value="60">60</option>
												<option value="90">90</option>
                                                <option value="120">120</option>
                                            </select>
                    </p></td>
                
            </tr>
            
          
        
            <tr></tr>
            <tr>
                <td>


                    <!--<a href="dashboard.php" class="button round blue image-right ic-right-arrow">LOG IN</a>-->
                    <input type="submit" class="button round blue image-right ic-right-arrow" id="btnswipe"
                           value="Create "/>
                </td>
                <td><a href="index.php" class="button blue round side-content">Dashboard</a></td>
            </tr>
        </table>

    </form>
    <div class="imgoncreate" style="float: right;margin-top: -350px">
         <form action="" enctype="multipart/form-data" id="upload_logo" method="post" name="form">
            <p>Set  Logo</p>
            <input type="file" name="fileToUpload" id="fileToUpload" class="round full-width-input"><br><br><br>
            <input type="submit" name="submit" value="Submit" class="btnoncreate button round blue image-right ic-right-arrow"><br><br><br>
            <img id="upload"  src="#" alt="no image file">
            <div id="message"></div>
        </form>
    </div>
</div>
<?php
}
else{
    
 ?>

<!-- MAIN CONTENT -->
<div id="content">


    <form action="" method="POST" id="login-form" class="cmxform" autocomplete="off">
      
        <table>
            <tr>
                <td>

                    <p>
                        <label>Swipe Countdown</label>
                        
                     
                         
                           <select class="js-example-basic-multiple round default-width-input" name="seconds" id="seconds" data-placeholder="Choose Payment mode">
        <option value="">Currently set to -- <?php echo $det [0]["seconds"] ;?> seconds</option>
                                                <option value="30">30</option>
                                                <option value="60">60</option>
												<option value="90">90</option>
                                                <option value="120">120</option>
                                            </select>
                        
                       
                    </p></td>
              
            </tr>
                
                   

                </td>
            </tr>
            <tr></tr>
            <tr>
                <td>


                    <!--<a href="dashboard.php" class="button round blue image-right ic-right-arrow">LOG IN</a>-->
                    <input type="submit" class="button round blue image-right ic-right-arrow" name="submit" id="button"
                           value="Update"/>
                </td>
                <td><a href="index.php" class="button blue round side-content">Dashboard</a></td>
            </tr>
        </table>

    </form>
    <div  style="float: right;margin-top: -350px">
         <form action="" enctype="multipart/form-data" id="upload_logo" method="post" name="form">
            <p>Upload Logo</p>
            <input type="file" name="fileToUpload" id="fileToUpload" class="round full-width-input"><br><br><br>
            <input type="submit" name="submit" value="Submit" class="button round blue image-right ic-right-arrow"><br><br><br>
            <img id="upload"  src="#" alt="no image file">
            <div id="message"></div>
        </form>
    </div>
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
    
    
    $(".imgoncreate").hide();
    
    $("#btnswipe").click(function(ev){
        ev.preventDefault();
        $.post("engines/newstore.php",$(".form_create_store").serialize(),function(resp){
           var res = $.parseJSON(resp);
           console.log(res);
           if(res.status=='ok'){
               alert(res.msg);
              $(".imgoncreate").show(1000); 
           }
           else if(res.status=='fail') {
               alert(res.msg);
               $(".imgoncreate").hide();
           }
        });
        
    });
        
    
    
    $('#button').click(function(ev){
		
		ev.preventDefault();
		
		$.post("engines/update_swipe.php",$("#login-form").serialize(),function(response){
		
		alert(response);	
	});
    });
        
        
         //image logo 
         $('#upload').hide();
        $('#fileToUpload').on('change', function () {
            $('#upload').slideDown('slow');
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {

                    $('#upload').attr('src', e.target.result).width(200).height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        

//send image date via jquery
$("#upload_logo").on('submit',(function(e) {
   
e.preventDefault();
$.ajax({
url: "engines/upload_img.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
  var dt = $.parseJSON(data);
    if(dt.log=="ok"){
$("#message").html('<div class="alert alert-success">'+dt.msg+'</div>');
   var delay = 3000; //Your delay in milliseconds
                            setTimeout(function () {
                                location.reload(true);
                            }, delay);
    }else if(dt.log=="fail"){
       $("#message").html('<div class="alert alert-danger">'+dt.msg+'</div>'); 
}
}
});
}));

});


 </script>
</body>
</html>

