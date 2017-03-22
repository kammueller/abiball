<?php
/*
 * BLOCKIEREN
 * Zugangsrechte eines Nutzers löschen
 * Sicherheitsabfrage vor mail.blockieren
 *
 * für alle Admins zugänglich
 * @TODO Mailadresse löschen funktion
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if (!( ($zugriff == 'all') OR ($zugriff == 'announce') OR ($zugriff =='verify') OR ($zugriff == 'finance') )) { header('location: ../home.php'); exit; }


		
// Zu erledigende Arbeit
    if(!isset($_POST["id"])) {
        $error = "Nutzer nicht gefunden.";
        include ('index.inc.php'); exit;
    }

	$weg = mysqli_real_escape_string( $db_link, esc($_POST['id'] ) );
	// Soll ein Admin geblockt werden? (unmöglich)
	$sql = "SELECT * FROM `abi_admin` WHERE `user_id` = '$weg' LIMIT 1";
	$db_erg = mysqli_query($db_link, $sql);
	if( ($menge = mysqli_num_rows($db_erg)) != 0 ) {
        $error = "Administratoren können nicht geblockt werden!";
        include ('index.inc.php'); exit; }
		
	// Wenn nicht allmächtig - ist der User schon verifiziert?
	$sql = "SELECT * FROM `abi_user` WHERE `id` = '$weg' LIMIT 1";
		$db_erg = mysqli_query($db_link, $sql);
		$result = mysqli_fetch_array($db_erg, MYSQL_ASSOC);	
	if ($zugriff != 'all') {
		if ( $result['verified'] != "mail" ) {
			$error = "Der User darf von dir nicht blockiert werden.";
			include('index.inc.php'); exit;
		}
	}
	
//Content
include('../back-end/design_alpha.inc.php');
include ('../back-end/design_beta.inc.php');

	echo ("
		<h2>User Blockieren</h2>
		User: ".$result['Vorname']." ".$result['Nachname']."<br>
		<span style='font-size: 12pt;'>(Sollte eine nichtgültige Mail-Adresse angeben sein, so verwende als Grund bitte \"Fake E-Mail-Adresse\"!)</span><br>
		<form name='Yes_Id".$weg."' action='mail.blockieren.php' method='post'>");
	echo("		<input type='text' size='8' maxlength='8' name='id' style='display: none;' value='".$weg."'>
			<textarea name='begruendung' cols='50' rows='10' >Bitte hier Begr&uuml;ndung angeben! Kopie wird an Webmaster verschickt.</textarea><br>
			<input type='submit' value='Mail Abschicken'>
		</form> ");
		
	include ('../back-end/design_gamma.inc.php');
	
