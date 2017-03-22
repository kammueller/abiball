<?php
/* 
 * USER LÖSCHEN
 * Sicherheitsabfrage vor badaction
 *
 * BENÖTIGT höchste Adminrechte
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; }  if ( $zugriff != 'all' ) { header('location: ../home.php'); exit; }

// Content
	
	include('../back-end/design_alpha.inc.php');
	include ('../back-end/design_beta.inc.php');
		
// Zu erledigende Arbeit
	// Daten Sammeln
	$del = mysqli_real_escape_string( $db_link, esc($_GET["id"]));
	$sql = "SELECT * FROM `abi_user` WHERE `id` = '$del' LIMIT 1";
	$db_erg = mysqli_query($db_link, $sql);
	$result = mysqli_fetch_array($db_erg, MYSQL_ASSOC);	
	$Vorname = $result['Vorname'];
	$Nachname = $result['Nachname'];
	// Darf der Account gel�scht werden?
		//Ist der Account geblockt?
		if ( $result['verified'] != 'geblockt' )
		{ echo "Es d&uuml;rfen nur geblockte Accounts gelöscht werden! <br>
		<a href='index.php'>Zur&uuml;ck zur Admin-Konsole</a><br>"; exit; }
		//Ist der Account schon 7 Tage blockiert?
		$sql = "SELECT * FROM `abi_blocked` WHERE `user_id` = '$del'";
		$db_erg = mysqli_query($db_link, $sql);
		$result = mysqli_fetch_array($db_erg, MYSQL_ASSOC);
		$blockdate = strtotime( $result['datum'] );
		$early_del = $blockdate + 60*60*24*7;  // fr�hestes Blockierdatum
		if ( mktime() < $early_del ) {
			echo "Ein Account muss erst Sieben Tage blockiert sein, bevor er gelöscht werden darf!<br>
			<a href='index.php'>Zur&uuml;ck zur Admin-Konsole</a><br>";
			exit;
		}
	
// Sicherheitsabfrage
	echo "Bist Du dir sicher, dass der Account von ".$Vorname." ".$Nachname." endg&uuml;ltig gel&ouml;scht werden soll?";
	echo "<table> <tr>";
		echo "<td> <form name='Quit' action='index.php'>
					<input type='submit' value='Nein'> </form> </td>";
		echo "<td> <form name='Delete' action='badaction.php' method='post'>
					<input type='text' size='8' maxlength='8' name='id' style='display: none;' value='".$del."'>
					<input type='text' size='8' maxlength='8' name='action' style='display: none;' value='delete'>
					<input type='submit' value='Ja'> </form> </td>";
		echo "</tr></table><br>";
		
	include ('../back-end/design_gamma.inc.php');


