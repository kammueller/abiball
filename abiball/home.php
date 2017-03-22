<?php
/*
 * HOME
 * eine leere Startseite
 */
include('back-end/logincheck.inc.php');
include('back-end/txt/headerdata.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('login.php'); exit; }

// Content
	
	echo('
<!doctype html>
<html>
<head>
	
	<title>'.html_title.'</title>
	<link rel="stylesheet" type="text/css" href="/back-end/fonts/fonts.css">
	<link rel="stylesheet" type="text/css" href="/back-end/design.css">
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="author" content="Matthias Kamm�ller">
	<meta name="description" content="Herzlich Willkommen auf der Website zum Abiball 2015.
	Ohne Account wirst du hier nichts machen k�nnen.">
	<meta name="keywords" content="Abiball, LMGU, Unterhaching, Karten">
	
	<!-- JQuery -->	
	<script src="/back-end/jquery.js"></script>
	<!-- Auf Aufl�sung �berpr�fen, DIVS positionieren, �nderungen �berwachen -->
	<script src="/home.js"></script>
		
</head>
<body onload="Aufloesung(); resize();"> 
	<script type="text/javascript">
	/* �berwachung von Internet Explorer initialisieren */
	if (!window.Weite && document.body && document.body.offsetWidth) {
	  window.onresize = neuAufbau();
	  Weite = Fensterweite();
	  Hoehe = Fensterhoehe();
	}
	</script>

	<div id="bg"><img id="backgroundimage" src="/img/bg.jpg"></div>
	
	<div id="header" onclick="toHome();">
		<span id="header_title">'.header.'</span>
		<hr id="header_line">
		<span id="header_sub">'.sub_head.'</span>
	</div>
	
	<div id="user_1"><img src="/back-end/img/schraeg_ccc.png" id="user_2"></div>
	<div id="user">
		<p id="user_3">Du bist eingeloggt als <b>'.$Vorname.' '.$Nachname.'</b><br>');

if ( isset($zugriff) ) {
	echo (' <a id="user_link" href="/admin">Admin-Konsole</a> &bull;');
	}
	
echo ('	
		<a id="user_link" href="/profil.php">Mein Profil</a> &bull; <a href="/logout.php" id="user_link">Abmelden</a></p>
	</div>

	<div id="footer">
		<p style="text-align: center"><a id="menue" href="/home.php">&nbsp; Home &nbsp;</a>&nbsp;<a id="menue" href="/karte">&nbsp; Kartenbestellung &nbsp;</a>&nbsp;<a id="menue" href="/location.php">&nbsp; Location &nbsp;</a>&nbsp;<a id="menue" href="/essen.php">&nbsp; Men&uuml; &nbsp;</a>&nbsp;<a id="menue" href="blog.php">&nbsp;Neuigkeiten &nbsp;</a>&nbsp;<a id="menue" href="about.php">&nbsp; Impressum &nbsp;</a></p>
	</div>
	
</body>
</html>');