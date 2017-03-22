<?php
/*
 * INDEX INC
 * für Rückleitungen mit Rückmeldung
 */
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if (!( ($zugriff == 'all') OR ($zugriff == 'announce') OR ($zugriff =='verify') OR ($zugriff == 'finance') )) { header('location: ../home.php'); exit; }

// Content
	
	include('../back-end/design_alpha.inc.php');
	echo '<link rel="stylesheet" type="text/css" href="message.css">
	<script src="message.js"></script>';
	include ('design_beta.admin.inc.php'); 
	
	if ( isset($success) ) { echo ('
	<div class="success" id="message">
		'.$success.'
	</div>'); }
	if ( isset($error) ) { echo ('
	<div class="error" id="message">
		'.$error.'
	</div>'); }
	
	
		
// Zu erledigende Arbeit
	$result = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `verified` = 'mail'");
	$menge = mysqli_num_rows($result);
		
// Content
	echo "<p>Hallo ".$Vorname.",<br><br>
	Herzlich Willkommen in der Admin-Konsole.<br>
	Das mag zwar toll klingen, doch gib Acht:<br>
	Sie bringt nicht nur gro&szlig;e Macht, sondern auch gro&szlig;e Verantwortung ;)<br><br>";
	
	if ($menge != 0) {
		echo "<b>Deine t&auml;gliche Portion Verifizierungs-Arbeit:</b><br>
		Jeder Account muss, bevor er freigeschaltet wird, hier akzeptiert werden.<br>
		Falls du denkst, dass der Account nicht freigeschalten werden sollte, so begr&uuml;nde dies bitte.<br>
		Die armen ".$menge." Leute, die noch auf eine validierung warten, kannst du <a href='validate.php'>hier ein bisschen gl&uuml;cklicher machen.</a><br><br>"; }
	
	if ($zugriff == ('all' OR 'announce')) {
		echo "<p><a href='blog.php'>Hier geht's zum Blog</a></p>"; }
	
	if ($zugriff == 'all') {
		echo "<br><br>
		<p><a href='useruebersicht.php'>Zur User&uuml;bersicht</a><br>
		<!-- Nur für diese Seite --> <a href='100_newuser.php'>Neuen Nutzer erstellen</a><br>
		<a href='blockbericht.php'>Zur &Uuml;bersicht der blockierten Nutzer</a><br>
		<a href='adminuebersicht.php'>Zur Admin&uuml;bersicht</a><br>
		<a href='bestelluebersicht.php'>Zur &Uuml;bersicht der Kartenbestellungen</a><br>
		<a href='kartenuebersicht.php'>Zur &Uuml;bersicht der bestellten Karten</a><br>
		<a href='bestellungfreischalten.php'>Neue Karten freigeben</a><br>
		<a href='sitzplatz.php'>Tisch & Sitzplan</a><br><br>
		<a href='file-edit/bausteine.php'>Die Seiten-Texte bearbeiten</a><br><br><br>

		<a href='000_zuruecksetzen.php'>Seite zurücksetzen</a>
		</p>"; }
	
	if ($zugriff == 'finance') {
		echo "<p><a href='bestelluebersicht.php'>Auf zur Finanz-Arbeit!!</a></p>"; }
	
	include ('../back-end/design_gamma.inc.php');
	
