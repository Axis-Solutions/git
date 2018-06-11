<?php
require '../db/dbapi.php';
function sendSocketRequest($XmlString, $Socket_Request,$caseNum) {
    $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if (!($sock)) {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        die("Couldn't create socket: [$errorcode] $errormsg \n");
    }

  

if($caseNum == 1){ //check transaction inialitization


    if (!($sock)) {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        die("Couldn't create socket: [$errorcode] $errormsg \n");
    }

    if (!socket_connect($sock, $Socket_Request['HostName'], $Socket_Request['Port'])) {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        die("Could not connect: [$errorcode] $errormsg \n");
    }

    socket_write($sock, pack_int32be(strlen($XmlString)), 4);
    socket_write($sock, $XmlString, strlen($XmlString));

    $test = "";

	
	while (true) {
	
	//read socket data
	  socket_recv($sock, $test, 2048, 0);
    $MyXml = htmlspecialchars(substr($test, 2));
	
    $SrtToXml = <<<XML
    $MyXml;
XML;
$nm3="";


	


//check for decline
    if (strpos($SrtToXml, 'DECLINE') !== false) {
	
	
	$responsecodeposition = strrpos($SrtToXml,"ResponseCode");
		$wezhaz=substr($SrtToXml, $responsecodeposition+19,2);
		//echo substr($SrtToXml, $responsecodeposition+19,2);
		//echo $wezhaz;
		
		
		$res = get_pos_responses($wezhaz);
		$response_code = $res[0]["response"];
		//echo  $response_code;

       // $resp["msg"] = $SrtToXml;
		 $resp["msg"] = $response_code;
        $resp["status"] = "notok";
		
		return json_encode($resp,true);
		die();		
		
    }		
		
		
		
			
			
			
			
	
			
		
			
			
			
			//CHECK TRANSACTION RESPONSE
			  
			$nm2= htmlspecialchars(substr($test,2));
			//echo '<br>';
		    //	echo htmlspecialchars(substr($test,2));			
		if(strpos($nm2,'AuthorizationProfile')!== false){
		
		$responsecodeposition = strrpos($nm2,"ResponseCode");
		$wezhaz=substr($nm2, $responsecodeposition+19,2);
		//echo substr($SrtToXml, $responsecodeposition+19,2);
		//echo $wezhaz;
		
		
		$res = get_pos_responses($wezhaz);
		$response_code = $res[0]["response"];
		//echo  $response_code;
			//echo 'Enter Pin';
			//echo '<br>';
			If(strpos($nm2,'DECLINE')!== false){
			
			$nm3='DECLINED';
		//	echo $nm3;
			}
			
			else{
			$nm3='APPROVED';
			//echo $nm3;
			}
			
			$nm3=$response_code;
			  $SrtToXml = <<<XML
$nm3
XML;

$myFile = "C:/Receipts/Receipt.txt";
$fh = fopen($myFile, 'w') or die("can't create file");
//echo $fh;
$stringData = <<<XML
$nm2
XML;


fwrite($fh, htmlspecialchars_decode($stringData));

fclose($fh);

$resp["msg"] = $SrtToXml;
//$resp["msg"] =$response_code;
$resp["status"] = "ok";	
		return json_encode($resp,true);
		die();		
			}
			

	
	}
	

	} 


	
   // socket_close($sock);
    return json_encode($resp,true);
}

function pack_int32be($i) {
    if ($i < -2147483648 || $i > 2147483647) {
        die("Out of bounds");
    }
    return pack('C4', ($i >> 24) & 0xFF, ($i >> 16) & 0xFF, ($i >> 8) & 0xFF, ($i >> 0) & 0xFF
    );
}

@$AmntPaid = $_GET["AmntPaid"];
$random = mt_rand(100000,999999);
$case = $_GET["case"];

$xmlString_Init = '<?xml version="1.0" encoding="UTF-8"?>
<Esp:Interface Version="1.0" xmlns:Esp="http://www.mosaicsoftware.com/Postilion/eSocket.POS/"><Esp:Admin TerminalId="16600001" Action="INIT" />
</Esp:Interface>';

$xmlString_trans = '<?xml version="1.0" encoding="UTF-8"?>
        <Esp:Interface Version="1.0" xmlns:Esp="http://www.mosaicsoftware.com/Postilion/eSocket.POS/"><Esp:Transaction TerminalId="16600001" TransactionAmount="' . $AmntPaid . '" TransactionId="'.$random.'" Type="PURCHASE" />
        </Esp:Interface>';

$socketResponse = sendSocketRequest($xmlString_trans, array('HostName' => 'localhost', 'Port' => '23001'),$case);
echo $socketResponse;













