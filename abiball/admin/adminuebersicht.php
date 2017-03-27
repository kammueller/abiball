<?php
/*
 * ADMINÜBERSICHT
 * zeigt sämtliche Admins an
 * und ermöglicht es, neue zu ernennen
 *
 * BENÖTIGT höchste Admin-Rechte
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../home.php'); exit; }

		
// Zu erledigende Arbeit
// Abarbeiten
    if((isset($_POST["id"]) && isset($_POST["rights"]))) {
        $neu = mysqli_real_escape_string($db_link, esc($_POST['id']));
        $rechte = mysqli_real_escape_string($db_link, esc($_POST['rights']));
        // Admin ernennen
        if ($neu != "") {
            $sql = "INSERT INTO `abi_admin` (`user_id`, `rechte`) VALUES ('$neu', '$rechte')"; // geht nur 1x
            $db_erg = mysqli_query($db_link, $sql);
            if ($db_erg) {
                include("mail.admin.inc.php");
                if ($funzt) {
                    $success = "Administrator wurde ernannt und benachrichtigt";
                } else {
                    $error = "Ups, es ist zu einem Fehler gekommen.<br> Die Mail konnte nicht versendet werden.";
                }
            } else {
                $error = "Ups, es ist zu einem Fehler gekommen.<br>
			Bitte versuche es erneut.";
            }
        }
    }
		
		
	// Datenliste abrufen
	$db_erg = mysqli_query($db_link, "SELECT * FROM `abi_admin` ORDER BY `user_id`");	
	

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
	
	
	echo "<h2>Admin&uuml;bersicht</h2>";
	
	// existierende Admins
	echo "<table border=1>
		<tr><th>id</th><th>Vorname</th><th>Nachname</th><th>Mail</th><th>Rechte</th><th>Account sperren</th></tr>";
	while ( $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC) ) {
		$admin_id = $datensatz['user_id'];
		$result = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$admin_id'");
		$data = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo "<tr>";
		echo "<td>".$admin_id."</td>";
		echo "<td>".$data['Vorname']."</td>";
		echo "<td><a href=useruebersicht.php?id=".$admin_id.">".$data['Nachname']."</a></td>";
		echo "<td>".$data['Mail']."</td>";
		echo "<td>";
			// Was für Rechte?
			switch ($datensatz['rechte']) {
			case 'all':
				echo "alle verf&uuml;gbaren Rechte";
				break;
			case 'finance':
				echo "finanzler";
				break;
			case 'announce':
				echo "Administrator mit Seiten-Editierungsrecht";
				break;
			case 'verify':
				echo "Blo&szlig; Verifizierungsrechte";
				break; }				
		echo "</td>";
		echo "<td>";
			// Admin-Rechte entziehen
			echo "<form name='Entadmin_ID".$admin_id."' action='noadmin.php' method='get'>
				<input type='text' size='8' maxlength='8' name='id' style='display: none;' value='".$admin_id."'>
				<input type='submit' value='Adminrechte entziehen'> </form>";
		echo "</td>";
		echo "</tr>";
	}
	echo "</table><br><br>";
	//neuer Admin
	echo "<b>Neuen Admin anlegen:</b>";
	$db_erg = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `verified` = 'true' ORDER BY `Nachname`");
	echo "<form name='Neuer_Admin' action='adminuebersicht.php' method='post'>
	<table> <tr> <td> <select name='id'>";		
	while ( $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC) ) {
		// Schon Admin?
		$check = mysqli_query($db_link, "SELECT * FROM `abi_admin` WHERE `user_id` = '".$datensatz['id']."'");
		if( ($menge = mysqli_num_rows($check)) == 0 ) {
			echo "<option value='".$datensatz['id']."'>".$datensatz['Vorname']." ".$datensatz['Nachname']."</option>"; }
	}
	echo "</td> <td>
	<select name='rights'> <option value='verify'>Blo&szlig; Verifizierungsrechte</option> <option value='announce'>Administrator mit Seiten-Editierungsrecht</option>  <option value='finance'>Finanzler</option> <option value='all'>alle verf&uuml;gbaren Rechte</option>";	
	echo "</td> <td> <input type='submit' value='Adminrechte verleihen'> </form> </td>  </tr> </table><br><br>";
	
	echo "<a href='index.php'>Zur&uuml;ck zur Admin-Konsole</a><br>";
	
	include ('../back-end/design_gamma.inc.php');
	
	
