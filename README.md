# mcs-manager
Control Panel for MCS management allowing to create and manipulate videoconference rooms.

## Rooms Viewer ##

![alt text](images/dash.PNG "Rooms viewer")


## Config ##

### Database configuration ###
Set your database credentials in the `config.php`
```diff

+ $host = 'DB_HOST';
+ $dbname = 'DB_NAME';
+ $dbuser = 'DB_USER';
+ $dbpass = 'DB_PASSWORD';
```
Choose wich DB you are gonna use and connect to. By default you have MySQL and PostgreSQL PDO connection example. If needed, add your own database PDO connection settings.
```php
/* After configure credentials */
try{
    /* Attempt to connect to MySQL database */
    //$pdo = new PDO("mysql:host=" .  $host  . ";dbname=" . $dbname, $dbuser, $dbpass);

    /* Attempt to connect to PostgreSQL database */
    $pdo = new PDO("pgsql:dbname=$dbname;host=$host", $dbuser, $dbpass) or die("error") ;
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
```



