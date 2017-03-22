<?php
/*
 * ADMIN BLOCKIEREN
 * Rechte eines Admins löschen
 * Sicherheitsabfrage vor badaction
 *
 * BENÖTIGT höchste Adminrechte
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../home.php'); exit; }

	include('../back-end/design_alpha.inc.php');
	include ('../back-end/design_beta.inc.php');
		
// Zu erledigende Arbeit
	// Daten Sammeln
	$del = mysqli_real_escape_string( $db_link, esc($_GET["id"]));
	$sql = "SELECT * FROM `abi_user` WHERE `id` = '$del' LIMIT 1";
	$db_erg = mysqli_query($db_link, $sql);
	$result = mysqli_fetch_array($db_erg, MYSQL_ASSOC);	
	$VornameA = $result['Vorname'];
	$NachnameA = $result['Nachname'];
	
	
	// Will man sich gerade selber kicken?
	if ($del == $user_id) {
		echo "<p>Du kannst dich nicht selber kicken!<br><br>
		<a href='index.php'>Zur&uuml;ck</a></p>";
		include ('../back-end/design_gamma.inc.php');
		exit;
	}
	
// Sicherheitsabfrage
	echo "<p>Bist Du dir sicher, dass dem Account von ".$VornameA." ".$NachnameA." die Admin-Rechte entzogen werden sollen?</p>";
	echo "<table> <tr>";
		echo "<td> <form name='Quit' action='index.php'>
					<input type='submit' value='Nein'> </form> </td>";
		echo "<td> <form name='Delete' action='badaction.php' method='post'>
					<input type='text' size='8' maxlength='8' name='id' style='display: none;' value='".$del."'>
					<input type='text' size='8' maxlength='8' name='action' style='display: none;' value='noadmin'>
					<input type='submit' value='Ja'> </form> </td>";
		echo "</tr></table><br>";
		
	include ('../back-end/design_gamma.inc.php');


