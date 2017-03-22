<?php
/*
 * LOGIN ANZEIGE
 * eine schön designte Landing-Page ;)
 */


	include ('back-end/logincreate.inc.php');

	if ($message == encode($error_pw)) {
		$loggedIn = 0; include ('login.php'); exit;
    }

	// STATT ALPHA & BETA
	echo ('	
	<!doctype html>
	<html>
	<head>
		
		<title>'.html_title.'</title>
		<link rel="stylesheet" type="text/css" href="/back-end/fonts/fonts.css">
		<link rel="stylesheet" type="text/css" href="/landing.css">
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="author" content="Matthias Kammüller">
		<meta name="description" content="Herzlich Willkommen auf der Website zur Abiball-Kartenbestellung.
		Ohne Account wirst Du hier nichts machen können.">
		
		<!-- JQuery -->	');
		if($JSding) {	echo ('<script src="/landing2.js"></script>'); }
		echo ('<script src="/back-end/jquery.js"></script>
		<!-- Auf Auflösung überprüfen, DIVS positionieren, Änderungen überwachen -->
		<script src="/landing.js"></script>');
		
    echo ('
	</head>
	<body onload="Aufloesung(); resize(); meldung(); logged();"> 
		<script type="text/javascript">
		/* Überwachung von Internet Explorer initialisieren */
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
		
	echo ('	<a id="user_link" href="/profil.php">Mein Profil</a> &bull; <a href="/logout.php" id="user_link">Abmelden</a></p>
		</div>
		
		<div id="wrapper">
			'.$message);
	if (isset($publickey)) {
		include ('admin/file-edit/recaptchalib.php');
		echo recaptcha_get_html($publickey, "", true);
		echo ('<input type="submit" value="Account erstellen">
                    </form>');
	}
	echo '</div>';
		
	if ( isset($ablaufen) ) {
	echo ('
		<div id="footer">
		<p style="text-align: center"><a id="menue" href="/home.php">&nbsp; Home &nbsp;</a>&nbsp;<a id="menue" href="/karte">&nbsp; Kartenbestellung &nbsp;</a>&nbsp;<a id="menue" href="/location.php">&nbsp; Location &nbsp;</a>&nbsp;<a id="menue" href="/essen.php">&nbsp; Menü &nbsp;</a>&nbsp;<a id="menue" href="blog.php">&nbsp;Neuigkeiten &nbsp;</a>&nbsp;<a id="menue" href="about.php">&nbsp; Impressum &nbsp;</a></p>
		</div> '); }
		
	echo ('
	</body>
	</html>');
	
	
