<?php
/*
 * Checkt, ob es noch Karten gibt / ob schon welche bestellt wurden.
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }

include("../back-end/txt/pages/karten1.php");
include ("../back-end/txt/karten_links.php");

// Gibt es übrige Karten, die jetzt schon freigeschaltet sind?
	$sql = "SELECT * FROM `abi_0_kartenfreischalt` WHERE `timestamp` < ".time()." AND `uebrig` > 0 AND `reserviert` < `uebrig` LIMIT 1;";
	$db_erg = mysqli_query($db_link, $sql);
	$datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
	$timestamp = $datensatz['timestamp'];
	$menge = mysqli_num_rows($db_erg);

				
// Content
	
	include('../back-end/design_alpha.inc.php');
	
	//echo '<script src="karte.js"></script>
	//<link rel="stylesheet" type="text/css" href="errors.css">';
	
	include ('../back-end/design_beta.inc.php');
	echo "<h1>Kartenbestellung</h1>
	".encode($bausteine[0])."<br><br>
	";
	
	// werden gerade Daten reserviert?
	if ($logInCheck['reservierend'] == "true") {
		echo str_ireplace("%link*%nachbestellen%", '<a href="nachbestellen.php">', encode($karten_index_reserviert));
	} else {
	
	if ($menge == "0") {
		// Keine Tickets mehr
		echo encode($bausteine[1]);
	} else {
		// Tickets verf&uuml;gbar
		// erste Bestellungsmarge? (TIMESTAMP: 100)
		if ($timestamp == "100") {
			echo encode($bausteine[2])."<br><br>";
			// schon bestellt?
			$sql = "SELECT * FROM `abi_bestellung` WHERE `user_id` = ".$user_id;
			$result = mysqli_query($db_link, $sql);
			$menge = mysqli_num_rows($result);
			if ($menge != "0") {
				// schon Karten bestellt
				echo encode($bausteine[3]);
			} else {
				echo str_ireplace("%link*%bestellen%", '<a href="bestellen.php">', encode($karten_index_ersterunde));;
			}
		} else {
			// Heute schon Karten bestellt?
			$bestellt = false;
			$sql = "SELECT * FROM `abi_bestellung` WHERE `user_id` = ".$user_id;
			$result = mysqli_query($db_link, $sql);
			
			while ( $datensatz = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
				if ( $datensatz['datum'] == date("Y-m-d") ) { $bestellt = true; }
			}
			if ($bestellt) {
				echo encode($bausteine[4]);
			} else {
				echo str_ireplace("%link*%nachbestellen%", '<a href="nachbestellen.php">', encode($karten_index_nachbestellen));
			}
		}
	}
	}

    echo "<br><br>
    <a href='sitzplatz.php'>Sitzplätze reservieren!</a> <br>";

	// Karten tauschen
	echo str_ireplace("%link*%tauschen%", '<a href="kartentausch.php">', encode($karten_index_tauschen));
	
	include ('../back-end/design_gamma.inc.php');

