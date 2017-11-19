<?php

$database = 'sample';
$user = 'db2user1';
$password = 'db2password';
$hostname = 'dbhost.ibm.com';
$port = 50000;
$url = 'no url';
$switch_user = '';
$switch_password = '';
$xmlservice_lib = 'XMLSERVICE'; /* allow connect.inc to set xmlservice library $xmlservice_lib for xmlservice.inc */
$letitroll = ''; /* run some IBM i V6 on Linux (ADC only) */
$chroot_dir = '';

// env var addition
if (getenv('PHP_DB')) {
  $database = getenv('PHP_DB');
}
if (getenv('PHP_UID')) {
  $user = getenv('PHP_UID');
}
if (getenv('PHP_PWD')) {
  $password = getenv('PHP_PWD');
}
if (getenv('PHP_HOST')) {
  $hostname = getenv('PHP_HOST');
}
if (getenv('PHP_PORT')) {
  $port = getenv('PHP_PORT');
}
if (getenv('PHP_URL')) {
  $url = getenv('PHP_URL');
}
if (getenv('PHP_UID2')) {
  $switch_user = getenv('PHP_UID2');
}
if (getenv('PHP_PWD2')) {
  $switch_password = getenv('PHP_PWD2');
}
if (getenv('PHP_ROLL')) {
  $letitroll = getenv('PHP_ROLL');
}
if (getenv('XMLSERVICE')) {
  $xmlservice_lib = getenv('XMLSERVICE');
}
if (getenv('CHROOT')) {
  $chroot_dir = getenv('CHROOT');
}

$db = $database;
$username = $user;

// IBM i (PASE)
$myos = PHP_OS;
if (strpos("  ".$myos,'400') > 0 || strpos(" ".$myos,'AIX') > 0) {
  if (!file_exists('/QSYS.LIB') && !$chroot_dir) {
      die("CHROOT env var not set (via no /QSYS.LIB)");
  }
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
