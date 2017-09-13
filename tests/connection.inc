<?php

$database = "V7R1GOLD"; // YIPS V7R1GOLD;
$user = 'ADC';
$password = getenv($user);
$hostname = 'yips.idevcloud.com';
$port = 31904;
$url = 'no url';
$switch_user = 'TCAIRNS';
$switch_password = getenv($switch_user);
$chroot_dir = '';
$xmlservice_lib = 'XMLSERVICE'; /* allow connect.inc to set xmlservice library $xmlservice_lib for xmlservice.inc */
$letitroll = getenv('ROLL'); /* run some IBM i V6 on Linux (ADC only) */

$db = $database;
$username = $user;

// IBM i (PASE)
$myos = PHP_OS;
if (strpos("  ".$myos,'400') > 0 || strpos(" ".$myos,'AIX') > 0) {
  if (strpos($_SERVER["PHP_SELF"],"V6") === false) {
    require_once('skipif.PASE');
    for ($entry = strtok($PASE_ALT_TEST,"\n"); $entry; $entry = strtok("\n")) {
      $check = str_replace(array("test_V6",".phpt",".php"),"",$entry);
      if (strpos($_SERVER["PHP_SELF"],$check) > 0) {
        die('skip');
      }
    }
  }
}
// LUW (not PASE) 
else {
  if (!$letitroll && strpos($_SERVER["PHP_SELF"],"V6") > 0) {
    die('skip');
  }
}


date_default_timezone_set('UTC');


// test connection ok
$prepconn = db2_connect($database, $user, $password);
if (!$prepconn) die('skip');
db2_close($prepconn);

?>

