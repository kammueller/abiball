<?php
/*
 * VERIFIZIERUNGS-ÜBERSICHT
 * Übersicht aller noch nicht zugelassenen User
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if (!( ($zugriff == 'all') OR ($zugriff == 'announce') OR ($zugriff =='verify') OR ($zugriff == 'finance') )) { header('location: ../home.php'); exit; }

	include('../back-end/design_alpha.inc.php');
	include ('../back-end/design_beta.inc.php');
		
// Zu erledigende Arbeit
// Abarbeiten
	$weg = mysqli_real_escape_string( $db_link, esc($_POST['id']));
	if ($weg != "") {
		$sql = mysqli_query($db_link, "UPDATE `abi_user` SET `verified` = 'true' WHERE `id` = '$weg'");
		if (mysqli_affected_rows($db_link) == 1) {
			include ("mail.freischalten.inc.php"); 
			} else { echo "E-Mail wurde bereits versendet!"; }
		}
	// Datenliste abrufen
	$db_erg = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `verified` = 'mail'");
	
	

// Content	
	echo "<h2>Verifizierung</h2>";
	if( ($menge = mysqli_num_rows($db_erg)) != 0 ) {
		echo "
		<table border=1>
			<tr><th>Vorname</th><th>Nachname</th><th>Mail</th><th></th><th></th></tr>";
		while ( $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC) ) {
			echo "<tr>";
			echo "<td>".$datensatz['Vorname']."</td>";
			echo "<td>".$datensatz['Nachname']."</td>";
			echo "<td>".$datensatz['Mail']."</td>";
			echo "<td>
				<form name='Yes_Id".$datensatz['id']."' action='validate.php' method='post'>
				<input type='text' size='8' maxlength='8' name='id' style='display: none;' value='".$datensatz['id']."'>
				<input type='submit' value='Validieren'> </form>
				</td>";
			echo "<td>
				<form name='No_Id".$datensatz['id']."' action='ablehnen.php' method='post'>
				<input type='text' size='8' maxlength='8' name='id' style='display: none;' value='".$datensatz['id']."'>
				<input type='submit' value='Ablehnen'> </form>
				</td>";
			echo "</tr>";
		}
		echo "</table>";
	} else {
		echo "Oh, du Gl&uuml;cklicher, es gibt keine Arbeit zu tun<br>
		<a href='index.php'>Zur&uuml;ck zur Admin-Konsole</a><br>"; }
		
	include ('../back-end/design_gamma.inc.php');
	
