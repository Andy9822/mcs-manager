<?php
/* Database credentials */

$dbname = 'dairit8o68tbla';
$host = 'ec2-107-20-204-179.compute-1.amazonaws.com';
$dbuser = 'nztbhbfavgfpjd';
$dbpass = '04034e094b1149eb19210717ed852b4174ba4404b98d37056a9bd1934913976b';

try{
    /* Attempt to connect to MySQL database */
    //$pdo = new PDO( 'mysql:host=' . $host . ';dbname=' . $dbname, $dbuser, $dbpass );

    /* Attempt to connect to PostgreSQL database */
    $pdo = new PDO("pgsql:dbname=$dbname;host=$host", $dbuser, $dbpass) or die("error") ;
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>
