<?php

define('MYSQL_HOST', getenv("MYSQL_HOST"));
define('MYSQL_BENUTZER', getenv("MYSQL_USER"));
define('MYSQL_KENNWORT', getenv("MYSQL_PASSWORD"));
define('MYSQL_DATENBANK', getenv("MYSQL_DATABASE"));


$db_link = mysqli_connect(MYSQL_HOST, MYSQL_BENUTZER, MYSQL_KENNWORT, MYSQL_DATENBANK);
if (!$db_link) {
    if (isset($error_db)) {
        echo '<h1>' . $error_db . '</h1>';
        exit;
    } else {
        echo '<h1>Datenbank-Verbindungsfehler!</h1>';
        exit;
    }
}
mysqli_set_charset($db_link, 'utf8');
