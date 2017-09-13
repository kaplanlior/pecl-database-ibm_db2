<?php

$database = '*LOCAL';
$user = 'DB2';
$password = 'PWD';
$hostname = 'hotellnx122.torolab.ibm.com';
$port = 31904;
$url = 'no url';
$switch_user = 'DB2TWO';
$switch_password = 'PWD';
$chroot_dir = '/QOpenSys/zend7';
$xmlservice_lib = 'XMLSERVICE'; /* allow connect.inc to set xmlservice library $xmlservice_lib for xmlservice.inc */

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
  if (strpos($_SERVER["PHP_SELF"],"V6") > 0) {
    die('skip');
  }
}


date_default_timezone_set('UTC');


// test connection ok
$prepconn = db2_connect($database, $user, $password);
if (!$prepconn) die('skip');
db2_close($prepconn);

?>

