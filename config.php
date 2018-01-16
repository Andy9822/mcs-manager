<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'mcu');

$dbname = 'dairit8o68tbla';
$host = 'ec2-107-20-204-179.compute-1.amazonaws.com';
$dbuser = 'nztbhbfavgfpjd';
$dbpass = '04034e094b1149eb19210717ed852b4174ba4404b98d37056a9bd1934913976b';

try{
    /* Attempt to connect to MySQL database */
    //$pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);

    /* Attempt to connect to PostgreSQL database */
    $pdo = new PDO("pgsql:dbname=$dbname;host=$host", $dbuser, $dbpass) or die("error") ;
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>
