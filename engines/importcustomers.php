
<?php

require '../db/dbapi.php';


$userNames = array();
$magroup = array();
//$mydefaultID;
$uploadedStatus = 0;

//select validation
if (isset($_FILES["file"])) {
//if there was an error uploading the file
if ($_FILES["file"]["error"] > 0) {
    $response['status']='error';
$response['msg']= "Return Code: " . $_FILES["file"]["error"] . "<br />";
}
else {
if (file_exists($_FILES["file"]["name"])) {
	
chown($_FILES["file"]["name"],465); //Insert an Invalid UserId to set to Nobody Owner; for instance 465
//$do = unlink($FileName);
unlink($_FILES["file"]["name"]);
}
$storagename = "Products.xls";
move_uploaded_file($_FILES["file"]["tmp_name"],  $storagename);
$uploadedStatus = 1;
}
} 

else 
{
$response['msg']= "No file selected";
$response['status']= "error";
}


if($uploadedStatus==1){

set_include_path(get_include_path() . PATH_SEPARATOR . '../fileclasses/');
include '../fileclasses/PHPExcel/IOFactory.php';

// This is the file path to be uploaded.
$inputFileName  = 'C:/Users/tmadzamba/Desktop/Products.xlsx'; 

try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
}
 catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}


$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$arrayCount = count($allDataInSheet);  // Here get total count of rows in that Excel sheet

$lastId = array();
$p=0;
for($i=2;$i<=$arrayCount;$i++){	
    
    //BASIC accunt informtion
$code = trim($allDataInSheet[$i]["A"]);
$stk_name = trim($allDataInSheet[$i]["B"]);
$category = trim($allDataInSheet[$i]["C"]);
$opening_stock = trim($allDataInSheet[$i]["D"]);
$cost = trim($allDataInSheet[$i]["E"]);
$sellingPrice = trim($allDataInSheet[$i]["F"]);
$TaxCode = trim($allDataInSheet[$i]["G"]);
$UOM = trim($allDataInSheet[$i]["H"]);
$expiry_date = "";


if(!empty($code) && !empty($stk_name) && !empty($TaxCode) && !empty($cost) && !empty($sellingPrice) && !empty($category))
{
    //check if code exists
    $codes = array();
    $prods = get_all_prods();
    foreach($prods as $prod){
        $cod2 = $prod["stock_id"];
        array_push($codes, $cod2);
    }
    if(in_array($code, $codes)){
      $rslt["msg"] = "Product with code $code already exist in the system. No duplicate codes required!";
    $rslt["log"]="failed";   
    }
    else{
    if($expiry_date==""){
    $expiry_date = date("Y-m-d H:i:s",strtotime("1970/01/01"));
    }else{
         $expiry_date = date("Y-m-d H:i:s",strtotime($expiry_date));
    }
$new_st = create_stock($code,$stk_name,$opening_stock,$TaxCode,$cost,$sellingPrice,$category,$expiry_date,$UOM);

if($new_st["status"]=="ok"){
    $rslt["msg"] = "New Stocks have been successfully uploaded in the system";
    $rslt["log"]="ok";
}else{
    $rslt["msg"] = "Failed to create stock. Error: ".$new_st["status"];
    $rslt["log"]="failed";
}
}
}
else{
     $rslt["msg"] = "Product code, name, tax code, cost and selling price and category can not be empty";
    $rslt["log"]="failed";
}


}

}

echo json_encode($rslt);

