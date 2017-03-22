<?php
header ('Content-type: text/html; charset=utf-8');
// Test-Cookie
setcookie("failed", "0", time()+100*24*60*60, "/");
include('back-end/txt/headerdata.php');
include('back-end/txt/errors.php');
include('back-end/txt/pages/login.php');
if(!isset($already_encoded)) {include('back-end/db_encode.inc.php');} // include Encoding nur, wenn notwendig

echo ('
<!doctype html>
<html>
<head>
	
	<title>'.html_title.'</title>
	<link rel="stylesheet" type="text/css" href="/back-end/fonts/fonts.css">
	<link rel="stylesheet" type="text/css" href="/login.css">

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<!-- JQuery -->
	<script src="/back-end/jquery.js"></script>
	<!-- Auf Auflösung überprüfen, DIVS positionieren, Änderungen überwachen -->
	<script src="/login.js"></script>

</head>
<body onload="Aufloesung(); resize();  loading();  errorWeg()">
	<script type="text/javascript">
	/* Überwachung von Internet Explorer initialisieren */
	if (!window.Weite && document.body && document.body.offsetWidth) {
	  window.onresize = neuAufbau();
	  Weite = Fensterweite();
	  Hoehe = Fensterhoehe();
	}
	</script>

	<div id="bg"><img id="backgroundimage" src="/img/login.jpg"></div>

	<div id="header">
		<span id="header_title">'.header.'</span>
		<hr id="header_line">
		<span id="header_sub">'.sub_head.'</span>
	</div> ');
	
	if ( isset($message) ) { echo ('
	<div class="error" id="message">
		'.$message.'
	</div>'); }
	if ( isset($out) ) { echo ('
	<div class="out" id="message">
		'.$out.'
	</div>'); }
	
	
	if ( !isset($_COOKIE['failed']) ) { echo ('
	<div class="error" id="cookie">
		'.encode($error_cookie).'
	</div>'); }
	
	echo ('
	<div id="wrapper">
		<h1 id="title">Login</h1>
		<form action="/landing.php" method="post" name="login" onsubmit="return chkFormular()">
			<input type="text" size="30" maxlength="32"	name="Vorname" value="Vorname" onfocus="LeerenVor()" class="input"><br>
			<p class="error" id="vor">Bitte Vornamen eingeben!</p>
			<input type="text" size="30" maxlength="32"	name="Nachname" value="Nachname" onfocus="LeerenNach()" class="input"><br>
			<p class="error" id="nach">Bitte Nachnamen eingeben!</p>
			Passwort: <input type="password" size="20" maxlength="32" name="password" onfocus="LeerenPass()" id="pass" value="pass"> <!--placeholder="Passwort"--><br>
			<p class="error" id="passwort">Bitte Passwort eingeben!</p>
			<input type="submit" value="'.$bausteine[0].'" id="submit">
		</form>
		<p>
			<br>
			<a href="javascript:help()">Login-Daten vergessen?</a><br>
			<span id="help">
				'.encode($bausteine[1]).'<br><br>
			</span>
			<!--<a href="/eintragenNeu.php">Noch keinen Account?</a> - Neue Accounts sind hier nicht anlegbar!! -->
			<a href="javascript:alert(\'Schüler der Q12 können sich direkt anmelden. Bitte logge Dich mit deinem Vor- & Nachnamen, sowie einem beliebigen Passwort ein.\')">Noch keinen Account?</a>
		</p>
	</div>
	
</body>
</html> ');
