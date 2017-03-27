<?php
header('Content-type: text/html; charset=utf-8');
include("abiball/back-end/db_connect.inc.php");

if (!(isset($_POST["host"]) && isset($_POST["user"]) && isset($_POST["db"]) && isset($_POST["pass"]))) {
    $msg = "Nicht gen&uuml;gend Daten angebeben";
    include "2.php";
    exit;
}
if (($_POST["host"] == "") OR ($_POST["user"] == "") OR ($_POST["db"] == "") OR ($_POST["pass"] == "")) {
    $msg = "Nicht gen&uuml;gend Daten angebeben";
    include "2.php";
    exit;
}

$query = "CREATE TABLE IF NOT EXISTS `abi_0_kartenfreischalt` (
			  `timestamp` INT(12) NOT NULL,
			  `anzahl` INT(3) NOT NULL,
			  `uebrig` INT(3) NOT NULL,
			  `reserviert` INT(3) NOT NULL,
			  PRIMARY KEY (`timestamp`),
			  KEY `timestamp` (`timestamp`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			";
if (mysqli_query($db_link, $query)) {
    echo "Datenbank f&uuml;r Kartenfreischaltung wurde erstellt <br>";
} else {
    echo "<h2>Fehler in der Verbindung. Bitte nochmals versuchen!</h2><br>
		<a href='2.php'>Bitte probieren Sie es erneut.</a>";
    exit;
}

$query = "CREATE TABLE IF NOT EXISTS `abi_admin` (
			  `user_id` INT(8) NOT NULL,
			  `rechte` ENUM('all','finance','announce','verify') NOT NULL,
			  UNIQUE KEY `user_id` (`user_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			";
if (mysqli_query($db_link, $query)) {
    print "Datenbank f&uuml;r Administratoren wurde erstellt <br>";
} else {
    echo "<h2>Fehler in der Verbindung. Bitte nochmals versuchen!</h2><br>
		<a href='2.php'>Bitte probieren Sie es erneut.</a>";
    exit;
}

$query = "CREATE TABLE IF NOT EXISTS `abi_bestellung` (
			  `BestellNr` VARCHAR(12) NOT NULL,
			  `user_id` INT(8) NOT NULL,
			  `karte1` INT(8) NOT NULL,
			  `karte2` INT(8) NOT NULL,
			  `karte3` INT(8) NOT NULL,
			  `karte4` INT(8) NOT NULL,
			  `Wunschkarten` INT(2) NOT NULL,
			  `Kommentar` TEXT NOT NULL,
			  `datum` DATE NOT NULL,
			  `Bezahlt` ENUM('true','false') NOT NULL DEFAULT 'false',
			  `BezAm` DATE DEFAULT NULL COMMENT 'Bezahldatum',
			  `admin_id` INT(8) DEFAULT NULL,
			  `BezArt` ENUM('bar','konto','sonstige') DEFAULT NULL COMMENT 'Art der Bezahlung',
			  `BezKom` VARCHAR(128) DEFAULT NULL COMMENT 'Genauere Beschreibung der Bezahlung',
			  `mahnung` DATE NULL DEFAULT NULL COMMENT 'Versanddatum der letzten Mahnung (wenn keine: NULL)',
			  PRIMARY KEY (`BestellNr`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			";
if (mysqli_query($db_link, $query)) {
    print "Datenbank f&uuml;r Bestellungen wurde erstellt <br>";
} else {
    echo "<h2>Fehler in der Verbindung. Bitte nochmals versuchen!</h2><br>
		<a href='2.php'>Bitte probieren Sie es erneut.</a>";
    exit;
}

$query = "CREATE TABLE IF NOT EXISTS `abi_blocked` (
			  `user_id` INT(8) NOT NULL,
			  `admin_id` INT(8) NOT NULL,
			  `Grund` TEXT NOT NULL,
			  `datum` DATE NOT NULL,
			  UNIQUE KEY `user_id` (`user_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			";
if (mysqli_query($db_link, $query)) {
    print "Datenbank f&uuml;r blockierte Nutzer wurde erstellt <br>";
} else {
    echo "<h2>Fehler in der Verbindung. Bitte nochmals versuchen!</h2><br>
		<a href='2.php'>Bitte probieren Sie es erneut.</a>";
    exit;
}

$query = "CREATE TABLE IF NOT EXISTS `abi_karten` (
			  `id` INT(8) NOT NULL AUTO_INCREMENT,
			  `user_id` INT(8) NOT NULL,
			  `karteNr` ENUM('1','2','3','4','edit') NOT NULL COMMENT 'Welche Nummer in der Bestellung',
			  `Vorname` VARCHAR(32) NOT NULL,
			  `Nachname` VARCHAR(32) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
			";
if (mysqli_query($db_link, $query)) {
    print "Datenbank f&uuml;r bestellte Karten wurde erstellt <br>";
} else {
    echo "<h2>Fehler in der Verbindung. Bitte nochmals versuchen!</h2><br>
		<a href='2.php'>Bitte probieren Sie es erneut.</a>";
    exit;
}

$query = "CREATE TABLE IF NOT EXISTS `abi_news` (
			  `id` INT(8) NOT NULL AUTO_INCREMENT,
			  `user_id` INT(8) NOT NULL,
			  `Titel` VARCHAR(64) NOT NULL,
			  `Teaser` TEXT NOT NULL,
			  `Text` TEXT NOT NULL,
			  `Timestamp` INT(20) NOT NULL,
			  `edit_id` INT(20) NOT NULL,
			  `edit_time` INT(20) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
			";
if (mysqli_query($db_link, $query)) {
    print "Datenbank f&uuml;r Blog wurde erstellt <br>";
} else {
    echo "<h2>Fehler in der Verbindung. Bitte nochmals versuchen!</h2><br>
		<a href='2.php'>Bitte probieren Sie es erneut.</a>";
    exit;
}

$query = "CREATE TABLE IF NOT EXISTS `abi_tische` (
  `Nummer` int(2) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `Plaetze` int(2) NOT NULL,
  `Frei` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
if (mysqli_query($db_link, $query)) {
    print "Datenbank f&uuml;r Tischreservierungen wurde erstellt <br>";
} else {
    echo "<h2>Fehler in der Verbindung. Bitte nochmals versuchen!</h2><br>
		<a href='2.php'>Bitte probieren Sie es erneut.</a>";
    exit;
}

$query = "CREATE TABLE IF NOT EXISTS `abi_reservierung` (
			  `user_id` INT(8) NOT NULL,
			  `ablauf` INT(20) NOT NULL COMMENT 'timestamp',
			  `anz` INT(1) NOT NULL COMMENT 'Wie viele Karten werden reserviert? 1 oder 2?',
			  `bestellung` INT(20) NOT NULL COMMENT 'timestamp des Kartenschubs',
			  PRIMARY KEY (`user_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Speichert, wenn sich gerade wer Karten holen will, um Zeitlimit durchzusetzen';
			";
if (mysqli_query($db_link, $query)) {
    print "Datenbank f&uuml;r Reservierungen wurde erstellt <br>";
} else {
    echo "<h2>Fehler in der Verbindung. Bitte nochmals versuchen!</h2><br>
		<a href='2.php'>Bitte probieren Sie es erneut.</a>";
    exit;
}

$query = "CREATE TABLE IF NOT EXISTS `abi_session` (
			  `id` TEXT NOT NULL,
			  `user_id` INT(8) NOT NULL,
			  `time` INT(10) NOT NULL,
			  UNIQUE KEY `user_id` (`user_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			";
if (mysqli_query($db_link, $query)) {
    print "Datenbank f&uuml;r Sessions wurde erstellt <br>";
} else {
    echo "<h2>Fehler in der Verbindung. Bitte nochmals versuchen!</h2><br>
		<a href='2.php'>Bitte probieren Sie es erneut.</a>";
    exit;
}

$query = "CREATE TABLE IF NOT EXISTS `abi_user` (
			  `id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
			  `password` VARCHAR(64) NOT NULL,
			  `Vorname` VARCHAR(32) NOT NULL,
			  `Nachname` VARCHAR(32) NOT NULL,
			  `verified` ENUM('false','mail','true','geblockt','newMail') NOT NULL,
			  `Mail` VARCHAR(64) NOT NULL,
			  `reservierend` ENUM('true','false') DEFAULT NULL,
			  `failed` INT(1) NOT NULL DEFAULT '0' COMMENT 'Falsche Login-Versuche in Reihe',
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `username` (`Vorname`, `Nachname`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
			";
if (mysqli_query($db_link, $query)) {
    print "Datenbank f&uuml;r User wurde erstellt <br>";
} else {
    echo "<h2>Fehler in der Verbindung. Bitte nochmals versuchen!</h2><br>
		<a href='2.php'>Bitte probieren Sie es erneut.</a>";
    exit;
}

$query = "CREATE TABLE IF NOT EXISTS `abi_verify` (
			  `user_id` INT(8) NOT NULL,
			  `hash` VARCHAR(32) NOT NULL,
			  UNIQUE KEY `user_id` (`user_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			";
if (mysqli_query($db_link, $query)) {
    print "Datenbank f&uuml;r Verifizierung wurde erstellt <br><br>";
} else {
    echo "<h2>Fehler in der Verbindung. Bitte nochmals versuchen!</h2><br>
		<a href='2.php'>Bitte probieren Sie es erneut.</a>";
    exit;
}

$trun = mysqli_query($db_link, "TRUNCATE TABLE `abi_0_kartenfreischalt`;");
$trun = $trun && mysqli_query($db_link, "TRUNCATE TABLE `abi_admin`;");
$trun = $trun && mysqli_query($db_link, "TRUNCATE TABLE `abi_bestellung`;");
$trun = $trun && mysqli_query($db_link, "TRUNCATE TABLE `abi_blocked`;");
$trun = $trun && mysqli_query($db_link, "TRUNCATE TABLE `abi_karten`;");
$trun = $trun && mysqli_query($db_link, "TRUNCATE TABLE `abi_news`;");
$trun = $trun && mysqli_query($db_link, "TRUNCATE TABLE `abi_reservierung`;");
$trun = $trun && mysqli_query($db_link, "TRUNCATE TABLE `abi_session`;");
$trun = $trun && mysqli_query($db_link, "TRUNCATE TABLE `abi_tische`;");
$trun = $trun && mysqli_query($db_link, "TRUNCATE TABLE `abi_user`;");
$trun = $trun && mysqli_query($db_link, "TRUNCATE TABLE `abi_verify`;");
if ($trun) {
    print "Datenbanken wurden gereinigt <br><br>";
} else {
    echo "<h2>Fehler in der Verbindung. Bitte nochmals versuchen!</h2><br>
		<a href='2.php'>Bitte probieren Sie es erneut.</a>";
    exit;
}

$query = "INSERT INTO `abi_admin` (`user_id`, `rechte`) VALUES
			(1, 'all');
			";
if (mysqli_query($db_link, $query)) {
    print "Erster Administrator wurde angelegt <br>";
} else {
    echo "<h2>Fehler in der Verbindung. Bitte nochmals versuchen!</h2><br>
		<a href='2.php'>Bitte probieren Sie es erneut.</a>";
    exit;
}

$query = "INSERT INTO `abi_0_kartenfreischalt` (`timestamp`, `anzahl`, `uebrig`, `reserviert`) VALUES
			(100, 0, 20, 0);
			";
if (mysqli_query($db_link, $query)) {
    print "Garantierunde wurde angelegt <br>";
} else {
    echo "<h2>Fehler in der Verbindung. Bitte nochmals versuchen!</h2>
		<a href='2.php'>Bitte probieren Sie es erneut.</a>";
    exit;
}

/* @TODO auf Übergabewert checken
 * @TODO Drop Keys!!!
 */
$query = "INSERT INTO `abi_user` (`id`, `password`, `Vorname`, `Nachname`, `verified`, `Mail`, `reservierend`, `failed`) VALUES
			(1, '" . password_hash($_POST["pass"], PASSWORD_BCRYPT) . "', '" . $_POST["host"] . "', '" .
    $_POST["user"] . "', 'true', '" . $_POST["db"] . "', NULL, 0);
			";
if (mysqli_query($db_link, $query)) {
    print "Nutzer wurde angelegt <br><br><br>";
} else {
    echo "<h2>Fehler in der Verbindung. Bitte nochmals versuchen!</h2>
		<a href='2.php'>Bitte probieren Sie es erneut.</a>";
    exit;
}

### HEADERDATA SCHREIBEN ###
/**@todo escape */
$file = "abiball/back-end/txt/headerdata.php";
$content = '<?php
/**
 * HEADER-DATA
 * der Title-Text sowie der im Bildschirm angezeigte
 */

 // Die Folgenden Daten werden NICHT encoded!!
define("html_title", "' . $_POST["html"] . '"); // Der HTML-Title

define("header", "' . $_POST["header1"] . '"); // erste Zeile

define("sub_head", "' . $_POST["header2"] . '"); // zweite Zeile

 // ANSPRECHPARTNER:
/** @var STRING $admin_vor
 * Vorname des Admins
 */
$admin_vor  = "' . $_POST["host"] . '";
/** @var STRING $admin_nach
 * Nachname des Admins
 */
$admin_nach = "' . $_POST["user"] . '";
/** @var STRING $admin_mail
 * Mailadresse des Admins
 */
define("admin_mail", "' . $_POST["db"] . '");

/** @var STRING $admin_post
 * Adresse des Admins (im Real-life) ;D
 */
$admin_post = "' . $_POST["str"] . ' %nZ%
                ' . $_POST["ort"] . '";

/* webadress - Die Überadresse ( http://[...].de) */
define("webadress", "' . $_POST["adress"] . '");               ';

$handle = fopen($file, "w");
if (!fwrite($handle, $content)) {
    echo "<h2>Fehler in der Verbindung. Bitte nochmals versuchen!</h2>
		<a href='2.php'>Bitte probieren Sie es erneut.</a>";
    exit;
}
fclose($handle);

$file = "abiball/back-end/db_captcha.php";
$content = '<?php
/**
 * Die Captcha-Keys und das Admin-PW zur Seiten-Bearbeitung
 */

/* CAPTCHA-CODES */
define("privatekey", "' . $_POST["cap2"] . '");
define("publickey", "' . $_POST["cap1"] . '");
/* ADMIN-PW */
define("check", \'$2y$10$QCTJVtTM40yN7effvSEx/OeLG62/cKzH4CdkSbrDVsvdpBLHgZMme\');';
$handle = fopen($file, "w");
if (!fwrite($handle, $content)) {
    echo "<h2>Fehler in der Verbindung. Bitte nochmals versuchen!</h2>
		<a href='2.php'>Bitte probieren Sie es erneut.</a>";
    exit;
}
fclose($handle);

echo "Textdaten erfolgreich angelegt.<br>
<h2>Sie k&ouml;nnen sich nun anmelden!</h2>";

unlink("2.php");
unlink("3.php");
unlink("index.php");
unlink("bild.png");