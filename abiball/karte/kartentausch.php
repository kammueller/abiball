<?php
/**
 * KARTENTAUSCH
 * schenke einem anderen Abiturienten deine Karte und gib den Namen des Adressaten an
 */
 
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }

include("../back-end/txt/pages/karten1.php");
include ("../back-end/txt/karten_links.php");

// Content
	
	include('../back-end/design_alpha.inc.php');
	
	echo '<script src="nachbestellen.js"></script>
	<link rel="stylesheet" type="text/css" href="../back-end/errors.css">';
	
	include ('../back-end/design_beta.inc.php');
	
	echo '<h1 id="title">Kartentausch</h1>
	<form name="Kartenbestellung" action="kartentauschaufgeben.php" method="post" onsubmit="return chkFormular()">
	'.encode($bausteine[17]).'<br>
    '.encode($bausteine[18]).' <select name="hergeben">';
	
	// Alle Kartenbestellungen 
	$sql = "SELECT * FROM `abi_bestellung`  WHERE `user_id` = '$user_id';";
	$db_erg = mysqli_query($db_link, $sql);
	while ( $datensatz = mysqli_fetch_array($db_erg, MYSQL_ASSOC) ) {
		$k1 = $datensatz['karte1'];
			if ($k1 != 0) { // Vorname und Nachname ziehen
				$result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k1';");
				$karte = mysqli_fetch_array($result, MYSQL_ASSOC);
				$VorN1 = $karte['Vorname'];
				$NachN1 = $karte['Nachname'];
				echo '<option value="'.$k1.'">'.$VorN1.' '.$NachN1.'</option>'; }
		$k2 = $datensatz['karte2'];
			if ($k2 != 0) { // Vorname und Nachname ziehen
				$result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k2';");
				$karte = mysqli_fetch_array($result, MYSQL_ASSOC);
				$VorN2 = $karte['Vorname'];
				$NachN2 = $karte['Nachname'];
				echo '<option value="'.$k2.'">'.$VorN2.' '.$NachN2.'</option>';}
		$k3 = $datensatz['karte3'];
			if ($k3 != 0) { // Vorname und Nachname ziehen
				$result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k3';");
				$karte = mysqli_fetch_array($result, MYSQL_ASSOC);
				$VorN3 = $karte['Vorname'];
				$NachN3 = $karte['Nachname'];
				echo '<option value="'.$k3.'">'.$VorN3.' '.$NachN3.'</option>'; }
		$k4 = $datensatz['karte4'];
			if ($k4 != 0) { // Vorname und Nachname ziehen
				$result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k4';");
				$karte = mysqli_fetch_array($result, MYSQL_ASSOC);
				$VorN4 = $karte['Vorname'];
				$NachN4 = $karte['Nachname'];
				echo '<option value="'.$k4.'">'.$VorN4.' '.$NachN4.'</option>'; }
	}	
	echo '
	</select> &nbsp; &nbsp;
	<input type="hidden" name="anz" value="1" style="width: 50px"><!-- Kartenbeschränkung für JS -->
	<br>
	'.encode($bausteine[19]).' <input type="text" size="20" maxlength="32" name="VorN1" placeholder="Vorname"> <input type="text" size="25" maxlength="32" name="NachN1" placeholder="Nachname"><br>
	
	<p class="error" id="namen">Bitte alle Namen angeben!</p>

	<input type="reset" value="'.encode($bausteine[20]).'"> <input type="submit" value="'.encode($bausteine[21]).'">
	</form>';
	
	include ('../back-end/design_gamma.inc.php');
 
 
