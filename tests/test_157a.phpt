--TEST--
IBM-DB2: db2_fetch_assoc() - positioned without scrollable cursor (error)
--SKIPIF--
<?php require_once('skipif.inc'); ?>
--FILE--
<?php

require_once('connection.inc');

$conn = db2_connect($db,$username,$password);
if ($conn) {
    require_once('prepare.inc');
    $sql = "SELECT id, name, breed, weight FROM animals ORDER BY breed";
    $result = db2_exec($conn, $sql);

    $i=2;
    while ($row = db2_fetch_assoc($result, $i)) {
        printf ("%-5d %-16s %-32s %10s\n", 
            $row['ID'], $row['NAME'], $row['BREED'], $row['WEIGHT']);
    
        $i = $i + 2;
    }
}

?>
--EXPECTF--
PHP Warning:  db2_fetch_assoc(): Fetch Failure in %s on line %d 