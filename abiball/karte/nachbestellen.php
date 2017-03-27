<?php
/*
 * BESTELLUNG
 * für die Nachbestellung
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }

include ("../back-end/txt/pages/karten2.php");

// Heute schon Karten bestellt?
	$bestellt = false;
	$sql = "SELECT * FROM `abi_bestellung` WHERE `user_id` = ".$user_id;
	$result = mysqli_query($db_link, $sql);
	while ( $datensatz = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
		if ( $datensatz['datum'] == date("Y-m-d") ) { $bestellt = true; }
	}
	if ($bestellt) {
		include('../back-end/design_alpha.inc.php');
		include ('../back-end/design_beta.inc.php');
		echo encode($bausteine[0]);
		include ('../back-end/design_gamma.inc.php');
		exit;
	}
	
// werden gerade Daten reserviert?
	if ($logInCheck['reservierend'] == "true") {
		// Gültigkeit wurde bereits überprüft
		// es muss nichts mehr geändert werden
		
	} else {
// fals nicht:
	// Noch Karten verfügbar?
		$sql = "SELECT * FROM `abi_0_kartenfreischalt` WHERE `timestamp` < ".time()." AND `uebrig` > 0 AND `reserviert` <= `uebrig` LIMIT 1;";
		$db_erg = mysqli_query($db_link, $sql);
		$datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
		$timestamp = $datensatz['timestamp'];
		$menge = mysqli_num_rows($db_erg);
		if ($menge == "1") {
			// Karten reservieren
				$resAlt = $datensatz['reserviert'];
				$resNeu = $resAlt + 2;
				if ($resNeu > $datensatz['uebrig'])
					{ $eineKarte = 1; } else { $eineKarte = 2; } // gibt es noch 2 Karten?
				$resNeu = $resAlt + $eineKarte;
				$time = $datensatz['timestamp'];
				$sql = "UPDATE `abi_user` SET `reservierend` = 'true' WHERE `id` = '$user_id'";
				mysqli_query($db_link, $sql);
				$sql = "UPDATE `abi_0_kartenfreischalt` SET `reserviert` = ".$resNeu." WHERE `timestamp` = ".$time.";";
				mysqli_query($db_link, $sql);
				// neue Reservierung anlegen
				$ablaufzeit = time()+5*60;
				$sql = "INSERT INTO `abi_reservierung` (`user_id`, `ablauf`, `anz`) VALUES ('$user_id', '$ablaufzeit', '$eineKarte');";
				$reservieren = mysqli_query($db_link, $sql);
				
		} else {
			// Keine Karten mehr :(
			include('../back-end/design_alpha.inc.php');
			echo '<link rel="stylesheet" type="text/css" href="../back-end/errors.css">';
			include ('../back-end/design_beta.inc.php');
			echo "<p class='error' style='display: block; font-weight: bold'>".encode($bausteine[1])."</p>";
			include ('../back-end/design_gamma.inc.php');
			exit;
		}
		
	}

// Content
	
	include('../back-end/design_alpha.inc.php');
	
	echo '<script src="nachbestellen.js"></script>
	<link rel="stylesheet" type="text/css" href="../back-end/errors.css">
	<meta http-equiv="refresh" content="300; URL=nachbestellung_cancel.php">'; // In 5 Minuten reservierung vorbei sein tun
	
	include ('../back-end/design_beta.inc.php');
	
	echo '<h1 id="title">Kartenbestellung</h1>
	<form name="Kartenbestellung" action="nachbestellenaufgeben.php" method="post" onsubmit="return chkFormular()">
	'.encode($bausteine[2]).'<br><br>';

	if ($eineKarte == 1) { 
		echo encode($bausteine[3]).' <input type="number" min="1" max="1" name="anz" value="1" style="width: 50px"><br>';
	} else {
        echo encode($bausteine[3]).' <input type="number" min="1" max="2" name="anz" value="2" style="width: 50px"><br>'; }

    echo encode($bausteine[4]).'<br>
	Karte 1: <input type="text" size="20" maxlength="32" name="VorN1"> <input type="text" size="25" maxlength="32" name="NachN1"><br>';
	if ($eineKarte == 1) { echo '
	<input type="hidden" size="20" maxlength="32" name="VorN2" value=""> <input type="hidden" size="25" maxlength="32" name="NachN2" value=""><br>';
	} else { echo '
	Karte 2: <input type="text" size="20" maxlength="32" name="VorN2"> <input type="text" size="25" maxlength="32" name="NachN2"><br>';}  echo '
	
	<p class="error" id="namen">Bitte alle Namen angeben!</p>
	<br><br>

	<input type="reset" value="'.encode($bausteine[5]).'"> <input type="submit" value="'.encode($bausteine[6]).'">
	</form><br><br>
	<p><a href="nachbestellung_cancel.php">'.encode($bausteine[7]).'</a></p>';
	
	include ('../back-end/design_gamma.inc.php');

