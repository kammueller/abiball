<?php
/*
 * LOGIN ANZEIGE
 * eine schön designte Landing-Page ;)
 */
    include ('../back-end/logincreate.inc.php');

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
			<link rel="stylesheet" type="text/css" href="/mobile/design.css">
			
			
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="author" content="Matthias Kammüller">
			<meta name="description" content="Herzlich Willkommen auf der Website zum Abiball 2015.
			Ohne Account wirst du hier nichts machen können.">
			<meta name="keywords" content="Abiball, LMGU, Unterhaching, Karten">
			
			<meta name=viewport content="width=device-width, initial-scale=1">
			
			<!-- JQuery -->	
			<script src="/back-end/jquery.js"></script>
			<!-- Auf Auflösung überprüfen, DIVS positionieren, Änderungen überwachen -->
			<script src="/mobile/design.js"></script>
			
		</head>


		<body>

		<!-- HEADER -->
			<img src="/img/mobileHeader.PNG" id="header" height="100%" width="auto">
			
			<div id="menueHeader"> &nbsp;	</div>
			

		<!-- CONTENT -->
		
			<p>'.$message.'<br><br>
			    <a id="menue" href="/mobile/karte">Kartenbestellung</a><br>
                <a id="menue" href="/mobile/about.php">Impressum</a>
            </p>
			
			
	</body>
	</html>');
