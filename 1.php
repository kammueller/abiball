<?php
if (!(isset($_POST["host"]) && isset($_POST["user"]) && isset($_POST["db"]) && isset($_POST["pass"]))) {
    $msg = "Nicht gen&uuml;gend Daten angebeben";
    include "0.php";
    exit;
}
if (($_POST["host"] == "") OR ($_POST["user"] == "") OR ($_POST["db"] == "") OR ($_POST["pass"] == "")) {
    $msg = "Nicht gen&uuml;gend Daten angebeben";
    include "0.php";
    exit;
}

define('MYSQL_HOST',$_POST["host"]);
define('MYSQL_BENUTZER',$_POST["user"]);
define('MYSQL_KENNWORT',$_POST["pass"]);
define('MYSQL_DATENBANK',$_POST["db"]);


$db_link = mysqli_connect(MYSQL_HOST, MYSQL_BENUTZER, MYSQL_KENNWORT, MYSQL_DATENBANK);
if(!$db_link) {
    $msg = "Verbindung konnte nicht hergestellt werden!";
	include ("0.php");
	exit;
}
mysqli_set_charset($db_link, "utf8");

$msg = "Verbindung erfolgreich hergestellt!";

$content = "<?php
define('MYSQL_HOST','".MYSQL_HOST."');
define('MYSQL_BENUTZER','".MYSQL_BENUTZER."');
define('MYSQL_KENNWORT','".MYSQL_KENNWORT."');
define('MYSQL_DATENBANK','".MYSQL_DATENBANK."');


\$db_link = mysqli_connect(MYSQL_HOST, MYSQL_BENUTZER, MYSQL_KENNWORT, MYSQL_DATENBANK);
if(!\$db_link) {
    if(isset(\$error_db)){echo '<h1>'.\$error_db.'</h1>'; exit;} else {echo '<h1>Datenbank-Verbindungsfehler!</h1>'; exit;}
}
mysqli_set_charset(\$db_link, 'utf8');

";
$handle = fopen("abiball/back-end/db_connect.inc.php", "w");
if (!fwrite ($handle, $content)) {
	$msg = "Verbindung konnte nicht gespeichert weden werden!<br> Bitte versuchen Sie es erneut!";
	include ("0.php");
	exit;
}

include ("2.php");

unlink("0.php");
unlink("1.php");