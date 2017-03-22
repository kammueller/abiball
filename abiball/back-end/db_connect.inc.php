<?php
define('MYSQL_HOST','rdbms.strato.de');
define('MYSQL_BENUTZER','U1929030');
define('MYSQL_KENNWORT','123456789a');
define('MYSQL_DATENBANK','DB1929030');


$db_link = mysqli_connect(MYSQL_HOST, MYSQL_BENUTZER, MYSQL_KENNWORT, MYSQL_DATENBANK);
if(!$db_link) {
    if(isset($error_db)){echo '<h1>'.$error_db.'</h1>'; exit;} else {echo '<h1>Datenbank-Verbindungsfehler!</h1>'; exit;}
}
mysqli_set_charset($db_link, 'utf8');

