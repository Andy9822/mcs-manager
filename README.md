# mcs-manager
Web App for MCS management


# Rooms Viewer #

![alt text](images/dash.PNG "Rooms viewer")


### Database configuration in config.php ###

```php
/* Database credentials */

$host = 'DB_HOST';
$dbname = 'DB_NAME';
$dbuser = 'DB_USER';
$dbpass = 'DB_PASSWORD';

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
```



