<?php
require '../db/dbapi.php';
$sid = $_GET["sid"];
$details = get_prod_details($sid);
$res["cost"] = round($details[0]["company_price"],2);
$res["sell"] = round($details[0]["selling_price"],2);
$res["qty"] = $details[0]["stock_quatity"];
$res["desc"]=$details[0]["stock_name"];
$res["taxCode"] = $details[0]["Tax_Code"];

echo json_encode($res);