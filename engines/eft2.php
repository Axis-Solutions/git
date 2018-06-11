<?php

require '../db/dbapi.php';

$dtt = get_swipe_countdown();


@$AmntPaid = $_POST["AmntPaid"];
$random = mt_rand(100000, 999999);
@$rec_no = $_POST["rec_no"];
$case = $_GET["case"];
$seconds = $dtt[0]["seconds"];

function sendSocketRequest($XmlString, $Socket_Request, $caseNum, $rec_no, $AmntPaid, $random, $seconds) {
    $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if (!($sock)) {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        die("Couldn't create socket: [$errorcode] $errormsg \n");
    }


    if ($caseNum == 1) { //check transaction inialitization
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



        $startTime = time();
//$timeout = $seconds;   //timeout in seconds
//comment out
        $timeout = 10;
//echo $seconds;
        $seconds = 10;







        while (true) {

            if (time() > $startTime + $timeout) {

                // echo "zvafa";
                //die();

                $xmlString_trans = '<?xml version="1.0" encoding="UTF-8"?>
        <Esp:Interface Version="1.0" xmlns:Esp="http://www.mosaicsoftware.com/Postilion/eSocket.POS/"><Esp:Transaction TerminalId="16600001"  Reversal="TRUE" TransactionAmount="' . $AmntPaid . '" TransactionId="' . $random . '" Type="PURCHASE" />
        </Esp:Interface>';


                socket_write($sock, pack_int32be(strlen($xmlString_trans)), 4);
                socket_write($sock, $XmlString, strlen($xmlString_trans));

                //echo "zvafa";
                //die();	
            }
            //read socket data
            socket_recv($sock, $test, 2048, 0);
            $MyXml = htmlspecialchars(substr($test, 2));

            $SrtToXml = <<<XML
    $MyXml;
XML;
            $nm3 = "";




//check for decline
            if (strpos($SrtToXml, 'DECLINE') !== false) {


                $responsecodeposition = strrpos($SrtToXml, "ResponseCode");
                $wezhaz = substr($SrtToXml, $responsecodeposition + 19, 2);
                //echo substr($SrtToXml, $responsecodeposition+19,2);
                //echo $wezhaz;


                $res = get_pos_responses($wezhaz);
                $response_code = $res[0]["response"];
                //echo  $response_code;
                // $resp["msg"] = $SrtToXml;
                $resp["msg"] = $response_code;
                $resp["status"] = "notok";

                return json_encode($resp, true);
                die();
            }


            //check for reversal
            if (strpos($SrtToXml, 'Reversal') !== false) {


                $responsecodeposition = strrpos($SrtToXml, "ResponseCode");
                $wezhaz = substr($SrtToXml, $responsecodeposition + 19, 2);
                //echo substr($SrtToXml, $responsecodeposition+19,2);
                //echo $wezhaz;


                $res = get_pos_responses($wezhaz);
                $response_code = "Reversal " . $res[0]["response"];
                //echo  $response_code;
                // $resp["msg"] = $SrtToXml;
                $resp["msg"] = $response_code;
                $resp["status"] = "notok";

                return json_encode($resp, true);
                die();
            }













            //CHECK TRANSACTION RESPONSE

            $nm2 = htmlspecialchars(substr($test, 2));
            //echo '<br>';
            //	echo htmlspecialchars(substr($test,2));			
            if (strpos($nm2, 'AuthorizationProfile') !== false) {

                $responsecodeposition = strrpos($nm2, "ResponseCode");
                $wezhaz = substr($nm2, $responsecodeposition + 19, 2);
                
                $res = get_pos_responses($wezhaz);
                $response_code = $res[0]["response"];
                
                $nm3 = $response_code;
                $SrtToXml = <<<XML
$nm3
XML;


                if (strpos($wezhaz, "00") !== false) {
                    $myFile = "C:/Receipts/Eftslip.txt";
                    $fh = fopen($myFile, 'w') or die("can't create file");

                    $stringDa = <<<XML
$nm2
XML;

                    $stringData = $stringDa . "" . $rec_no;
                    fwrite($fh, htmlspecialchars_decode($stringData));
                    fclose($fh);
                }



                $resp["msg"] = $SrtToXml;
//$resp["msg"] =$response_code;
                $resp["status"] = "ok";
                return json_encode($resp, true);
                die();
            }
        }
    }



    // socket_close($sock);
    return json_encode($resp, true);
}

function pack_int32be($i) {
    if ($i < -2147483648 || $i > 2147483647) {
        die("Out of bounds");
    }
    return pack('C4', ($i >> 24) & 0xFF, ($i >> 16) & 0xFF, ($i >> 8) & 0xFF, ($i >> 0) & 0xFF
    );
}

$xmlString_Init = '<?xml version="1.0" encoding="UTF-8"?>
<Esp:Interface Version="1.0" xmlns:Esp="http://www.mosaicsoftware.com/Postilion/eSocket.POS/"><Esp:Admin TerminalId="16600001" Action="INIT" />
</Esp:Interface>';

$xmlString_trans = '<?xml version="1.0" encoding="UTF-8"?>
        <Esp:Interface Version="1.0" xmlns:Esp="http://www.mosaicsoftware.com/Postilion/eSocket.POS/"><Esp:Transaction TerminalId="16600001" TransactionAmount="' . $AmntPaid . '" TransactionId="' . $random . '" Type="PURCHASE"  />
        </Esp:Interface>';

$socketResponse = sendSocketRequest($xmlString_trans, array('HostName' => 'localhost', 'Port' => '23001'), $case, $rec_no, $AmntPaid, $random, $seconds);
$respons = json_decode($socketResponse,True);
$LogAmnt = round($AmntPaid/100,2);
if($respons["status"] == "ok")
{
    
  $CreateReciept =  CreateReceipt($random,$random,$LogAmnt,"","");
}
else{
   $failedAtt =  "FailedSwipe_".$random;
    $Attempt =  LogOrder("","",$failedAtt,$failedAtt,$LogAmnt);
}
//print_r(json_decode($socketResponse,True));
echo $socketResponse;


