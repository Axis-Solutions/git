<?php
require '../db/dbapi.php';
$cid = $_GET["cid"];
$details = get_customer_details($cid);
$res["addr"] = $details[0]["customer_address"];
$res["contact"] = $details[0]["customer_contact1"];


echo json_encode($res);