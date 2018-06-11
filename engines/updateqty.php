<?php
require '../db/dbapi.php';
$prodID = $_POST["prod_id"];
$prodQty = $_POST["prod_qty"];

$qty = get_prod_details($prodID);
$oldqty = $qty[0]["stock_quatity"];
$prodName = $qty[0]["stock_name"];

$updat = update_prod_qty($prodQty, $prodID);
if ($updat["status"] == "ok") {
    $desc = "New Take on Balance for $prodName set from $oldqty to $prodQty";
    $audit_rep = create_prod_audit($desc, $prodID);
    if ($audit_rep["status"] == "ok") {
        $rslt["msg"] = "Quantity update successful. Audit report successfully created.";
        $rslt["log"] = "ok";
    } else {
        $rslt["msg"] = "Quantity update successful. Audit report failed to create. Error: " . $audit_rep["status"];
        $rslt["log"] = "failed";
    }
} else {
    $rslt["msg"] = "failed to update quantity. Make sure you have made an ammendment on quantity.  ERROR: " . $updat["status"];
    $rslt["log"] = "failed";
}

echo json_encode($rslt);
