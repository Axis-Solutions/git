<?PHP
$saveTime = (1234567890+3600); // Saved time from file/database
$thisTime = time(); // Current time
$diffTime = (saveTime-thisTime); // Difference in time

  if($diffTime >= 1) {
    $countMin = floor(diffTime/60);
    $countSec = (diffTime-(countMin*60));
    echo 'Time remaining until next run is in ',$countMin,' minute(s) ',$countSec,' seconds';
  } else {
    echo 'Timer expired.';
  }
?>