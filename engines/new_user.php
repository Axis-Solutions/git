<?php
require '../db/dbapi.php';
$user_type = $_POST["user_type"];
$username = $_POST["username"];
$password = $username;


if(empty($user_type) || empty($username))
{
    $rslt["msg"]="username or usertype can not be empty";
    $rslt["log"]="fail";
}
else
{
    $usernames = array();
  $all_users =  get_all_users();
  foreach($all_users as $user)
  {
      $db_usernam = $user["username"];
      array_push($usernames, $db_usernam);
  }
  if(in_array($username, $usernames)){
        $rslt["msg"]="Username $username already exists, please find another username option.";
    $rslt["log"]="fail";
  }
  else{
      
  
     $new_user  = create_user($username,$password,$user_type,$user_type);
     if($new_user["status"]=="ok")
     {
        $rslt["msg"]="User Created successfully. Password is defaulted to their username $username.";
    $rslt["log"]="ok";
     }
     else{
          $rslt["msg"]="Failed to create user. ERROR: ".$rslt["status"];
    $rslt["log"]="fail";
     }
}
}

echo json_encode($rslt);


