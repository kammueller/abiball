<?php
include('back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('login.php'); exit; }

include('back-end/txt/pages/profil.php');

// Wurden Karten bestellt?
	$sql = mysqli_query($db_link, "SELECT * FROM `abi_bestellung` WHERE `user_id` ='$user_id'");
	$menge = mysqli_num_rows($sql);
	if ($menge == '0') {
		$karten = "Es wurden noch keine Kartenbestellungen in Auftrag gegeben.<br>";
	} else {
		$karten = "Bislang wurden ".$menge." Bestellungen aufgegeben. 
		<a href='karte/rechnungen.php'>Alle Rechnungen als PDF</a><br>"; }

// Content
	
	include('back-end/design_alpha.inc.php');
	echo '<script src="profil.js"></script>
	<link rel="stylesheet" type="text/css" href="/profil.css">';
	
	include ('back-end/design_beta.inc.php');
	echo ('
		<h1>Profil</h1>
		<p>
			'.encode($bausteine[0]).'<br>
			'.$Vorname.' '.$Nachname.'<br>
			E-Mail: '.$Mail.'<br>
			'.encode($bausteine[1]).'<br>
			<br>
			'.$karten.'
			<br>
			<a href="javascript: mail()">E-Mail-Adresse aktualisieren</a>
		</p>
				<form name="changeMail" action="newMail.php" method="post" onsubmit="return chkMail()" id="mail" style="display: none">
					<input type="text" size="32" maxlength="32"	name="newMail" value="neue Mail-Adresse" onfocus="LeerenMail()" id="input"><br>
					<p class="error" id="mailA">Bitte g&uuml;ltige Mail-Adresse eingeben!</p>
					'.encode($bausteine[2]).'<br>
					<input type="submit" value="Bestätigungs-Mail zuschicken" id="submit" style="font-size: 12pt;"><br>
				</form>
		<br>
		<p>	<a href="javascript: passwort()">Passwort &auml;ndern</a> </p>
				<form name="changePass" action="newPass.php" method="post" onsubmit="return chkPass()" id="passwort" style="display: none">
					<table><tr>
					<td>Bisheriges Passwort:</td> <td><input type="password" size="32" maxlength="32" name="oldPass" id="pass"></td></tr>
					<tr><td><br></td><td></td></tr><tr>
					<td>Neues Passwort:</td> <td><input type="password" size="32" maxlength="32"	name="newPass1" id="pass"><br>
					<p class="error" id="eins">Bitte Passwort eingeben!</p>
					<p class="error" id="zwei">Das Passwort ist zu kurz.</p>
					<p class="error" id="drei">Das Passwort muss eine Zahl enthalten!</p>
					<p class="error" id="vier">Das Passwort muss Gro&szlig;- und Kleinbuchstaben enthalten!</p></td></tr>
					<tr><td>Wiederholen:</td><td> <input type="password" size="32" maxlength="32" name="newPass2" id="pass"><br>
					<p class="error" id="fuenf">Bitte das Passwort korrekt wiederholen!</p></td></tr>
					</table>
					<i>Mindestens 8 Zeichen, 1 Gro&szlig;buchstabe, 1 Kleinbuchstabe, 1 Ziffer</i><br>
					<input type="submit" value="Passwort &auml;ndern" id="submit" style="font-size: 12pt;"><br>
				</form>
		</p>');
	include ('back-end/design_gamma.inc.php');
	
