<?php
include_once("init.php");
$username = base64_decode($_GET["unq"]);

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WEBPOS - Update Password</title>

    <!-- Stylesheets -->

    <link rel="stylesheet" href="css/style.css">

    <!-- Optimize for mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- jQuery & JS files -->
    <?php include_once("tpl/common_js.php"); ?>
    <script src="js/script.js"></script>
</head>
<body>

<!-- TOP BAR -->
<?php include_once("tpl/user_top_bar.php"); ?>
<!-- end top-bar -->


<!-- HEADER -->
<div id="header-with-tabs">

  

</div>
<!-- end header -->


<!-- MAIN CONTENT -->
<div id="content">

    <div class="page-full-width cf">

    
        <!-- end side-menu -->

        <div class="side-content fr">

            <div class="content-module">

                <div class="content-module-heading cf">

                    <h3 class="fl">UPDATE PASSKEY FOR <?PHP echo $username; ?></h3>
                    <span class="fr expand-collapse-text">Click to collapse</span>
                    <span class="fr expand-collapse-text initial-expand">Click to expand</span>

                </div>
                <!-- end content-module-heading -->

                <div class="content-module-main cf">

                    <?php
                    if (isset($_POST['old_pass']) and isset($_POST['new_pass']) and isset($_POST['confirm_pass'])) {
                      //  $username = $_SESSION['username'];
                        $old_pass = $_POST['old_pass'];
                        $count = $db->countOf("stock_user", "username='$username' and password='$old_pass'");
                        if ($count == 0) {
                            echo "<br><font color=red size=6px >Old Password is wrong!</font>";
                        } elseif(strcasecmp(trim($_POST['new_pass']), trim($username))==0){
                            
                             echo "<br><font color=red size=6px >Password can not be the same as username</font>";
                            
                        }else{
                            if (trim($_POST['new_pass']) == trim($_POST['confirm_pass'])) {
                                $con = $_POST['confirm_pass'];
                                $db->query("update stock_user  SET password='$con' where username='$username'");
                                echo "<br><font color=green size=6px >Password is Successfuly updated! Click on logout to login again!</font>";
                               
                            } else {
                                echo "<br><font color=red size=6px >Confirm password is Wrong!</font>";
                            }
                        }
                    }
                    ?>
                    <form action="" method="post">
                        <table style="width:600px; margin-left:50px; float:left;" border="0" cellspacing="0"
                               cellpadding="0">

                            <tr>
                                <td>Old Password</td>
                                <td><input type="password" name="old_pass"></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>New Password</td>
                                <td><input type="password" name="new_pass"></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Confirm Password</td>
                                <td><input type="password" name="confirm_pass"></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td>
                                    <input class="button round blue image-right ic-add text-upper" type="submit"
                                           name="Submit" name="change_pass" value="Save">
                                </td>
                                <td>
                                    <input class="button round red   text-upper" type="reset" name="Reset"
                                           value="Reset"></td>
                            </tr>

                        </table>
                    </form>
                    <!--<ul class="temporary-button-showcase">
                                        <li><a href="#" class="button round blue image-right ic-add text-upper">Add</a></li>
                                        <li><a href="#" class="button round blue image-right ic-edit text-upper">Edit</a></li>
                                        <li><a href="#" class="button round blue image-right ic-delete text-upper">Delete</a></li>
                                        <li><a href="#" class="button round blue image-right ic-download text-upper">Download</a></li>
                                        <li><a href="#" class="button round blue image-right ic-upload text-upper">Upload</a></li>
                                        <li><a href="#" class="button round blue image-right ic-favorite text-upper">Favorite</a></li>
                                        <li><a href="#" class="button round blue image-right ic-print text-upper">Print</a></li>
                                        <li><a href="#" class="button round blue image-right ic-refresh text-upper">Refresh</a></li>
                                        <li><a href="#" class="button round blue image-right ic-search text-upper">Search</a></li>
                                    </ul>-->

                </div>
                <!-- end content-module-main -->


            </div>
            <!-- end content-module -->


        </div>
        <!-- end full-width -->

    </div>
</div>


<!-- FOOTER -->
<div id="footer">
    <div id="fb-root"></div>
    <div id="fb-root"></div>
   

    <p>Any Queries send to <a href="mailto:takundamadzamba@gmail.com">+263773629282</a>.
    </p>

</div>
<!-- end footer -->

</body>
</html>