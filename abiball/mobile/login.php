<?php
header ('Content-type: text/html; charset=utf-8');
// Test-Cookie
setcookie("failed", "0", time()+100*24*60*60, "/");
include('../back-end/txt/errors.php');
include('../back-end/txt/pages/login.php');
include('../back-end/txt/headerdata.php');
if(!isset($already_encoded)) {include('../back-end/db_encode.inc.php');} // include Encoding nur, wenn notwendig

echo ('
<!doctype html>
<html>
<head>
	
	<title>'.html_title.'</title>
	<link rel="stylesheet" type="text/css" href="/back-end/fonts/fonts.css">
	<link rel="stylesheet" type="text/css" href="/mobile/design.css">
	<link rel="stylesheet" type="text/css" href="/mobile/login.css">
	
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="author" content="Matthias Kammüller">
	<meta name="description" content="Herzlich Willkommen auf der Website zum Abiball 2015.
	Ohne Account wirst du hier nichts machen können.">
	<meta name="keywords" content="Abiball, LMGU, Unterhaching, Karten">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	
	<!-- JQuery -->	
	<script src="/back-end/jquery.js"></script>
	<!-- Auf Auflösung überprüfen, DIVS positionieren, Änderungen überwachen -->
	<script src="/mobile/design.js"></script>
	<script src="/mobile/login.js"></script>
	
</head>


<body>

<!-- HEADER -->
	<img src="/img/mobileHeader.PNG" id="header" height="100%" width="auto">
	
	<div id="menueHeader"> &nbsp;	</div>
	

<!-- CONTENT -->');
	
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
		<h1 id="title">Login</h1>
		<form action="/mobile/landing.php" method="post" name="login" onsubmit="return chkFormular()" style="line-height: 2.5em">
			<input type="text" size="30" maxlength="32"	name="Vorname" value="Vorname" onfocus="LeerenVor()" id="input"><br>
			<p class="error" id="vor">Bitte Vornamen eingeben!</p>
			<input type="text" size="30" maxlength="32"	name="Nachname" value="Nachname" onfocus="LeerenNach()" id="input"><br>
			<p class="error" id="nach">Bitte Nachnamen eingeben!</p>
			Passwort: <input type="password" size="20" maxlength="32" name="password" value="pass" onfocus="LeerenPass()" id="pass"><br>
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
			<a href="javascript:alert(\'Neue Benutzer können nicht angelegt werden!\')">Noch keinen Account?</a>
		</p>
	
</body>
</html> ');
