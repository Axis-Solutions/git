<?php
require "db/dbapi.php";


if(isset($_POST["submit"])){
    $username  = $_POST["username"];
    $password = $_POST["password"];
    if(!empty($username) && !empty($password)){
        
       $login = login($username,$password);
      
       if($login["status"]=="ok"){
           
           //only if username is not the same as password
           if($username == $password){
               $id = base64_encode($_SESSION["id"]);
               $user = base64_encode($_SESSION["username"]);
            $error = "Your Password is not secure, please click <a href='change_password_onlogin.php?urlKey=$id&unq=$user'>here</a> to change your password.";   
           }
           
           elseif(empty(get_co_details())){
               header("location:update_details.php");
           }
           
           else{
               // check if store details are updated
  
            if($_SESSION["usertype"]=="admin" || $_SESSION["usertype"]=="manager"){
            header("location:dashboard.php");
       }
       else{
            header("location:create_sale.php");
       }
           
       }
       }
       else{
            $error = "Username or password incorrect.";
       }
    }
    else{
        $error = "Username or Password can not be empty";
    }
}
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>POSNIC - Login to Control Panel</title>

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
                    username: {
                        required: true,
                        minlength: 3
                    },
                    password: {
                        required: true,
                        minlength: 3
                    }
                },
                messages: {
                    username: {
                        required: "Please enter a username",
                        minlength: "Your username must consist of at least 3 characters"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 3 characters long"
                    }
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

            <h1>Login to Dashboard</h1>
            <h5>Enter your credentials below</h5>

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


<!-- MAIN CONTENT -->
<div id="content">

    <form action="" method="POST" id="login-form" class="cmxform" autocomplete="off">

        <fieldset>
            <p> <?php

                if (isset($error)) {

               echo "  <div class='error-box round'>". $error . "</div>";
                 
                }
                ?>

            </p>

            <p>
                <label for="login-username">username</label>
                <input type="text" id="login-username" class="round full-width-input" placeholder="admin"
                       name="username" autofocus/>
            </p>

            <p>
                <label for="login-password">password</label>
                <input type="password" id="login-password" name="password" placeholder="admin"
                       class="round full-width-input"/>
            </p>

            <a href="forget_pass.php" class="button ">Forgot your password?</a>

            <!--<a href="dashboard.php" class="button round blue image-right ic-right-arrow">LOG IN</a>-->
            <input type="submit" class="button round blue image-right ic-right-arrow" name="submit" value="LOG IN"/>
        </fieldset>

        <br/>

      
    </form>

</div>
<!-- end content -->


<!-- FOOTER -->
<div id="footer">
  

    <div id="fb-root"></div>

    <script type="text/javascript">
        (function () {
            var po = document.createElement('script');
            po.type = 'text/javascript';
            po.async = true;
            po.src = 'https://apis.google.com/js/plusone.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(po, s);
        })();
    </script>
    <p>Any Queries send to <a href="mailto:takundamadzamba@gmail.com">+263773629282</a>.
    </p>


</div>
<!-- end footer -->

</body>
</html>