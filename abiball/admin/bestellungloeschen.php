<?php
/*
 * BESTELLUNG LOESCHEN - SICHERHEITSABFRAGE
 *
 * leitet weiter an badaction.php
 * BENOETIGT allmaechtige Rechte
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../home.php'); exit; }

// Content
	
	include('../back-end/design_alpha.inc.php');
	include ('../back-end/design_beta.inc.php');
		
// Zu erledigende Arbeit
	// Daten Sammeln
	$Nummer = mysqli_real_escape_string( $db_link, esc($_POST["nr"]) );
	$sql = "SELECT * FROM `abi_bestellung` WHERE `BestellNr` = '$Nummer'";
	$db_erg = mysqli_query($db_link, $sql);
	$result = mysqli_fetch_array($db_erg, MYSQL_ASSOC);	
	// Darf die Bestellung gelöscht werden?
		//Ist die Bestellung bezahlt?
		if ( $result['Bezahlt'] == 'true' )
		{ echo "Es d&uuml;rfen nur Bestellungen gelöscht werden, die noch nicht bezahlt sind! <br>
		<a href='index.php'>Zur&uuml;ck zur Admin-Konsole</a><br>"; exit; }
	
// Sicherheitsabfrage
	echo "Bist Du dir sicher, dass die Rechnung ".$Nummer." endg&uuml;ltig gel&ouml;scht werden soll?";
	echo "<table> <tr>";
		echo "<td> <form name='Quit' action='index.php'>
					<input type='submit' value='Nein'> </form> </td>";
		echo "<td> <form name='Delete' action='badaction.php' method='post'>
					<input type='hidden' size='8' maxlength='8' name='nr' value='".$Nummer."'>
					<input type='hidden' size='8' maxlength='14' name='action' value='bestellungWeg'>
					<input type='hidden' size='8' maxlength='14' name='id' value='0'>
					<input type='submit' value='Ja'> </form> </td>";
		echo "</tr></table><br>";
		
	include ('../back-end/design_gamma.inc.php');

