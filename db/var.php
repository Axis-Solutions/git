<?php

$db = new PDO('mysql:host=localhost;dbname=webpos;charset=utf8', 'root', '');

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

function get_uom(){
     global $db;
    try{
    $sql = "SELECT * FROM tbl_uom";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;
}

function get_categs(){
   global $db;
    try{
    $sql = "SELECT * FROM `category_details`";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;   
}

function get_last_transID(){
     global $db;
    try{
    $sql = "SELECT max(id) as max_val FROM `stock_entries`";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rslt = $stmt->fetchColumn();
   
    } catch (Exception $ex) {
        $rslt=$ex->getMessage();
    }
    return $rslt;   
}


