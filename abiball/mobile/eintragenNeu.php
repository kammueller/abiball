<?php
header("location: login.php");

/* NORMALFALL:
header ('Content-type: text/html; charset=utf-8');
include('../back-end/txt/headerdata.php');
include('../back-end/txt/pages/eintragen.php');
include('../back-end/txt/pages/about.php');
include('../back-end/db_encode.inc.php');

echo (' <!doctype html>
				<html>
				<head>
					
					<title>Abiball LMGU 2015</title>
					<link rel="stylesheet" type="text/css" href="/back-end/fonts/fonts.css">
					<link rel="stylesheet" type="text/css" href="/mobile/design.css">
					
					
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<meta name="author" content="Matthias Kamm�ller">
					<meta name="description" content="Herzlich Willkommen auf der Website zum Abiball 2015.
					Ohne Account wirst du hier nichts machen k�nnen.">
					<meta name="keywords" content="Abiball, LMGU, Unterhaching, Karten">
					
					<meta name=viewport content="width=device-width, initial-scale=1">
					
					<!-- JQuery -->	
					<script src="/back-end/jquery.js"></script>
					<!-- Auf Aufl�sung �berpr�fen, DIVS positionieren, �nderungen �berwachen -->
					<script src="/mobile/design.js"></script>
					
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
	
	echo ('
	
	
		<form name="Anmeldung" action="eintragen.php" method="post"  onsubmit="return chkPass()">
			<div id="contentA">
				<h1>Neuer Account</h1>
				'.encode($bausteine[0]).'<br><br>
				Vorname:<br>
				<input type="text" size="32" maxlength="32"
				name="Vorname"><br>
				<p class="smallError" id="vor">Bitte Vornamen angeben!</p>

				Nachname:<br>
				<input type="text" size="32" maxlength="32"
				name="Nachname"><br>
				<p class="smallError" id="nach">Bitte Nachnamen angeben!</p><br>

				E-Mail-Adresse:<br>
				<input type="text" size="32" maxlength="64"
				name="mail"><br>
				<div class="smallError" id="mailA"><p>Bitte g&uuml;ltige Mail-Adresse eingeben!</p>
				<p style="font-size: 10pt">(gültige Zeichen sind Klein-&Großbuchstaben ohne Umlaute sowie - _ . und natürlich @. Benutzen Sie ggf. bitte Punycode)</p></div>

				Passwort:<br>
				<span style="font-style: italic; font-size: 12pt;">Mindestens 8 Zeichen, 1 Gro&szlig;buchstabe, 1 Kleinbuchstabe, 1 Ziffer</span><br>
				<input type="password" size="32" maxlength="64"
				name="passwort"><br>
				<p class="smallError" id="eins">Bitte Passwort eingeben!</p>
				<p class="smallError" id="zwei">Das Passwort ist zu kurz.</p>
				<p class="smallError" id="drei">Das Passwort muss eine Zahl enthalten!</p>
				<p class="smallError" id="vier">Das Passwort muss Gro&szlig;- und Kleinbuchstaben enthalten!</p>


				Passwort wiederholen:<br>
				<input type="password" size="32" maxlength="64"
				name="passwort2"><br>
				<p class="smallError" id="fuenf">Bitte das Passwort korrekt wiederholen!</p><br>
			</div>
			<div id="contentB">
				<div id="agb">
				 '.encode($bausteine[4]).'
				</div>
				<div id="losgehts">
					<br>
					<input type="checkbox" name="agb" value="gelesen">'.encode($bausteine[1]).'<br>
					<input type="submit" value="Account erstellen">
					<button name="Klickmich" type="button" onclick="window.location = \'login.php\' ;">Abbrechen und zur&uuml;ck zum Login</button> <br>
				</div>
			</div>

				
		</form>
		
	</div>
</body>
</html>');


*/