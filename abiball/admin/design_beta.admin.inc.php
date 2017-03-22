<?php
/*
 * ONLY FOR ADMINS - mit Message-Aufruf (JS)
 * 
 * DESIGN - TEIL 2
 * Schlie�t HEAD, gibt den ersten Teil des BODYs aus
 * danach soll der Seiteninhalt einge�gt werden
 *
 * BEN�TIGT $Vorname und $Nachname!
 */
 
header ('Content-type: text/html; charset=utf-8');
echo ('
</head>
<body onload="Aufloesung(); resize(); message();">
	<script type="text/javascript">
	/* �berwachung von Internet Explorer initialisieren */
	if (!window.Weite && document.body && document.body.offsetWidth) {
	  window.onresize = neuAufbau();
	  Weite = Fensterweite();
	  Hoehe = Fensterhoehe();
	}
	</script>

	<div id="bg"><img id="backgroundimage" src="/img/bg.jpg"></div>

	<div id="header" onclick="toHome()">
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
		');

