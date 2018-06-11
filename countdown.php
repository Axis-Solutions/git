<script>
var p1 = "success";
</script>

<?php
echo "<script>document.writeln(p1);</script>";
?>

<?php
$val = set_time_limit(15);
$i = 0;
while ($i<=15)
{

        echo "i=$i ";
                $i++;
  
}


?>

<span id="countdown-1">30 seconds</span>

<script type="text/javascript">
  
	
	secs       = parseInt(document.getElementById('countdown-1').innerHTML,10);
	
    setTimeout("countdown('countdown-1',"+secs+")", 1000);
	
	
	 function countdown(id, timer){
        timer--;
        minRemain  = Math.floor(timer / 60);
        secsRemain = new String(timer - (minRemain * 60));
        // Pad the string with leading 0 if less than 2 chars long
        if (secsRemain.length < 2) {
            secsRemain = '0' + secsRemain;
        }

        // String format the remaining time
        clock      = minRemain + ":" + secsRemain;
		
        document.getElementById(id).innerHTML = clock;
		
        if ( timer > 0 ) {
            // Time still remains, call this function again in 1 sec
            setTimeout("countdown('" + id + "'," + timer + ")", 1000);
        } else {
            // Time is out! Hide the countdown
            //document.getElementById(id).style.display = 'none';
			alert('Time out')
			
			die();
        }
    }
</script>


