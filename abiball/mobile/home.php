<?php
/*
 * HOME
 * eine leere Startseite
 */
include('../back-end/logincheck.inc.php');
include('../back-end/txt/headerdata.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('login.php'); exit; }


// Content
	
include("design_alpha.inc.php");
include("design_beta.inc.php");
echo 'Herzlich Willkommen auf unserer Homepage!<br><br>
<a id="menue" href="/mobile/karte">Kartenbestellung</a><br>
<a id="menue" href="/mobile/about.php">Impressum</a>';
include("design_gamma.inc.php");