<?php
$db = "UT28P63";
$user = "DB2";
$password = "NICE2DB2";
$xmlservice_lib = "XMLSERVICE";
$conn = db2_connect($db,$user,$password);

/*
       dcl-pr iNUM1 extproc(*CL:'iNUM1');
         shortx    int(5);       // SMALLINT
         intx      int(10);      // INTEGER
         longlongx int(20);      // BIGINT
         doublex   float(8);     // DOUBLE
         dec12x    packed(12:2); // DECIMAL(12,2)
         zone12x   zoned(12:2);  // NUMERIC(12,2)
       end-pr;
*/

$stmt = db2_prepare( $conn , "CALL $xmlservice_lib.iNUM1(?, ?, ?, ?, ?, ?)" );
echo "**** result ****\n";
echo db2_stmt_errormsg()."\n";

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
echo "**** result ****\n";
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
  echo "**** result ****\n";
  echo db2_stmt_errormsg()."\n";

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
  echo "**** result ****\n";
  echo db2_stmt_errormsg()."\n";
  echo "SMALLINT ".$shorty."\n";
  echo "INTEGER ".$inty."\n";
  echo "BIGINT ".$longlongy."\n";
  echo "DOUBLE ".$doubley."\n";
  echo "DECIMAL(12,2) ".$dec12y."\n";
  echo "NUMERIC(12,2) ".$zone12y."\n";
}

?>

