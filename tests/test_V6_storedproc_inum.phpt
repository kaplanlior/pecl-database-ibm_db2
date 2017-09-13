--TEST--
IBM-DB2: Call xsptest stored procedure iNUM1
--SKIPIF--
<?php require_once('skipif.inc'); ?>
--FILE--
<?php
require_once('connection.inc');
$conn = db2_connect($db,$user,$password);

$sql1 = "";
$sql1 .= "DROP PROCEDURE $xmlservice_lib.iNUM1"."\n";
$res = db2_exec($conn, $sql1);

$sql2 = "";
$sql2 .= "CREATE PROCEDURE $xmlservice_lib.iNUM1("."\n";
$sql2 .= "INOUT shortx SMALLINT,"."\n";
$sql2 .= "INOUT intx INTEGER,"."\n";
$sql2 .= "INOUT longlongx BIGINT,"."\n";
$sql2 .= "INOUT doublex DOUBLE,"."\n";
$sql2 .= "INOUT dec12x DECIMAL(12,2),"."\n";
$sql2 .= "INOUT zone12x NUMERIC(12,2)"."\n";
$sql2 .= ")"."\n";
$sql2 .= "LANGUAGE SQL"."\n";
$sql2 .= "MODIFIES SQL DATA"."\n";
$sql2 .= "BEGIN"."\n";
$sql2 .= "SET shortx = shortx + 111;"."\n";
$sql2 .= "SET intx = intx + 111;"."\n";
$sql2 .= "SET longlongx = longlongx + 111;"."\n";
$sql2 .= "SET doublex = doublex + 111.11;"."\n";
$sql2 .= "SET dec12x = dec12x + 111.11;"."\n";
$sql2 .= "SET zone12x = zone12x + 111.11;"."\n";
$sql2 .= "END"."\n";
$res = db2_exec($conn, $sql2);

$stmt = db2_prepare( $conn , "CALL $xmlservice_lib.iNUM1(?, ?, ?, ?, ?, ?)" );
$shortx = 0;
$intx = 0;
$longlongx = 0;
$doublex = 0.00;
$dec12x = 0.00;
$zone12x = 0.00;
db2_bind_param( $stmt , 1 , "shortx" , DB2_PARAM_INOUT );
db2_bind_param( $stmt , 2 , "intx" , DB2_PARAM_INOUT );
db2_bind_param( $stmt , 3 , "longlongx" , DB2_PARAM_INOUT );
db2_bind_param( $stmt , 4 , "doublex" , DB2_PARAM_INOUT );
db2_bind_param( $stmt , 5 , "dec12x" , DB2_PARAM_INOUT);
db2_bind_param( $stmt , 6 , "zone12x" , DB2_PARAM_INOUT);
$result = db2_execute( $stmt );
echo "**** result global scope ****\n";
echo db2_stmt_errormsg()."\n";
echo "SMALLINT ".$shortx."\n";
echo "INTEGER ".$intx."\n";
echo "BIGINT ".$longlongx."\n";
echo "DOUBLE ".$doublex."\n";
echo "DECIMAL(12,2) ".$dec12x."\n";
echo "NUMERIC(12,2) ".$zone12x."\n";
$stmt = "";

// function scoped
callme($conn, $xmlservice_lib);

function callme($conn, $lib) {
  $stmt = db2_prepare( $conn , "CALL $lib.iNUM1(?, ?, ?, ?, ?, ?)" );
  $shorty = 2;
  $inty = 2;
  $longlongy = 2;
  $doubley = 2.22;
  $dec12y = 2.22;
  $zone12y = 2.22;
  db2_bind_param( $stmt , 1 , "shorty" , DB2_PARAM_INOUT );
  db2_bind_param( $stmt , 2 , "inty" , DB2_PARAM_INOUT );
  db2_bind_param( $stmt , 3 , "longlongy" , DB2_PARAM_INOUT );
  db2_bind_param( $stmt , 4 , "doubley" , DB2_PARAM_INOUT );
  db2_bind_param( $stmt , 5 , "dec12y" , DB2_PARAM_INOUT);
  db2_bind_param( $stmt , 6 , "zone12y" , DB2_PARAM_INOUT);
  $result = db2_execute( $stmt );
  echo "**** result function scope ****\n";
  echo db2_stmt_errormsg()."\n";
  echo "SMALLINT ".$shorty."\n";
  echo "INTEGER ".$inty."\n";
  echo "BIGINT ".$longlongy."\n";
  echo "DOUBLE ".$doubley."\n";
  echo "DECIMAL(12,2) ".$dec12y."\n";
  echo "NUMERIC(12,2) ".$zone12y."\n";
  $stmt = "";
}


$shortz = 3;
$intz = 3;
$longlongz = 3;
$doublez = 3.33;
$dec12z = 3.33;
$zone12z = 3.33;

// function scoped
callme2($conn, $xmlservice_lib);

function callme2($conn, $lib) {
  global $shortz, $intz, $longlongz, $doublez, $dec12z, $zone12z;
  $stmt = db2_prepare( $conn , "CALL $lib.iNUM1(?, ?, ?, ?, ?, ?)" );
  $shortz = 3;
  $intz = 3;
  $longlongz = 3;
  $doublez = 3.33;
  $dec12z = 3.33;
  $zone12z = 3.33;
  db2_bind_param( $stmt , 1 , "shortz" , DB2_PARAM_INOUT );
  db2_bind_param( $stmt , 2 , "intz" , DB2_PARAM_INOUT );
  db2_bind_param( $stmt , 3 , "longlongz" , DB2_PARAM_INOUT );
  db2_bind_param( $stmt , 4 , "doublez" , DB2_PARAM_INOUT );
  db2_bind_param( $stmt , 5 , "dec12z" , DB2_PARAM_INOUT);
  db2_bind_param( $stmt , 6 , "zone12z" , DB2_PARAM_INOUT);
  echo db2_stmt_errormsg()."\n";
  $result = db2_execute( $stmt );
  $stmt = "";
  echo "**** result global scope (function set) ****\n";
  echo db2_stmt_errormsg()."\n";
  echo "SMALLINT ".$shortz."\n";
  echo "INTEGER ".$intz."\n";
  echo "BIGINT ".$longlongz."\n";
  echo "DOUBLE ".$doublez."\n";
  echo "DECIMAL(12,2) ".$dec12z."\n";
  echo "NUMERIC(12,2) ".$zone12z."\n";
}
echo "**** repeat - result global scope (function set) ****\n";
echo db2_stmt_errormsg()."\n";
echo "SMALLINT ".$shortz."\n";
echo "INTEGER ".$intz."\n";
echo "BIGINT ".$longlongz."\n";
echo "DOUBLE ".$doublez."\n";
echo "DECIMAL(12,2) ".$dec12z."\n";
echo "NUMERIC(12,2) ".$zone12z."\n";

?>
--EXPECTF--
%s
SMALLINT 111
INTEGER 111
BIGINT 111
DOUBLE 111.11
DECIMAL(12,2) 111.11
NUMERIC(12,2) 111.11
%s
SMALLINT 113
INTEGER 113
BIGINT 113
DOUBLE 113.33
DECIMAL(12,2) 113.33
NUMERIC(12,2) 113.33
%s
SMALLINT 114
INTEGER 114
BIGINT 114
DOUBLE 114.44
DECIMAL(12,2) 114.44
NUMERIC(12,2) 114.44

