<?php
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }

include ("../back-end/txt/pages/karten2.php");
include ("../back-end/txt/karten_links.php");

// Karten reserviert??
	$sql = "SELECT * FROM `abi_user` WHERE `id` = '$user_id'";
	$resCheck = mysqli_query($db_link, $sql);
	$resData = mysqli_fetch_array($resCheck, MYSQLI_ASSOC);
	// nicht reserviert
	if ( $resData['reservierend'] != "true" ) {
		include('../back-end/design_alpha.inc.php');
		include ('../back-end/design_beta.inc.php');
		echo encode($bausteine[8]);
		include ('../back-end/design_gamma.inc.php');
		exit; }
	// Gültigkeit der Reservierung wurde bereits gecheckt
	
	
// Reservierung löschen
		$gueltig1 = mysqli_query($db_link, "SELECT * FROM `abi_reservierung` WHERE `user_id` = '$user_id'");
		$gueltig2 = mysqli_fetch_array($gueltig1, MYSQLI_ASSOC);
		$eineKarte = $gueltig2['anz'];
	$sql = "SELECT * FROM `abi_0_kartenfreischalt` WHERE `timestamp` < ".time()." AND `uebrig` > 0 LIMIT 1;";
	$resAr = mysqli_query($db_link, $sql);
	$res = mysqli_fetch_array($resAr, MYSQLI_ASSOC);
	$resAlt = $res['reserviert'];
	$resNeu = $resAlt - $eineKarte;
	$verfuegbar = $res['uebrig'];
	$time = $res['timestamp'];
	$sql = "UPDATE `abi_user` SET `reservierend` = 'false' WHERE `id` = '$user_id'";
	mysqli_query($db_link, $sql);
	$sql = "UPDATE `abi_0_kartenfreischalt` SET `reserviert` = ".$resNeu." WHERE `timestamp` = ".$time.";";
	mysqli_query($db_link, $sql);
	$gueltig1 = mysqli_query($db_link, "DELETE FROM `abi_reservierung` WHERE `user_id` = '$user_id'");

	   
// Abarbeiten
	// Bestellungsnummer generieren
		// Monat, Tag, Drei Zufallszahlen, Summe der Zufallszahlen
		$date = date("md");
		$a = rand(0, 9);
		$b = rand(0, 9);
		$c = rand(0, 9);
		$check = $a + $b + $c;
			if ($check < 10) { //Null davorsetzen
				$check = "0".$check; }
		$Nummer = $date . $a. $b . $c . $check ;
		// Nummer schon vorhanden?
		$result = mysqli_query($db_link, "SELECT * FROM `abi_bestellung` WHERE `BestellNr` = '$Nummer'");
		$menge = mysqli_num_rows($result);
		while ($menge != 0) {
			$a = rand(0, 9);
			$b = rand(0, 9);
			$check = $a + $b;
			$Nummer = $a . $date . $b . $check ;
			$result = mysqli_query($db_link, "SELECT * FROM `abi_bestellung` WHERE `BestellNr` = '$Nummer'");
			$menge = mysqli_num_rows($result); }
	// Daten des Formulars aufnehmen
	$VorN1 = mysqli_real_escape_string( $db_link, esc($_POST['VorN1']));
		$NachN1 = mysqli_real_escape_string( $db_link, esc($_POST['NachN1']));
	$VorN2 = mysqli_real_escape_string( $db_link, esc($_POST['VorN2']));
		$NachN2 = mysqli_real_escape_string( $db_link, esc($_POST['NachN2']));
	$wunsch = mysqli_real_escape_string( $db_link, esc($_POST['anz']));


// Je nach Anzahl Karten
	switch ($wunsch) {
		case '1': { // Eine Karte
			// Ist der Name angegeben?
				if ( ($NachN1 == "") OR ($VorN1 == "") ) {
					echo "bitte gebe alle benötigten Namen an.<br>
					<a href='index.php'>Zur&uuml;ck</a>"; exit; }
			// Karte registieren
				$sql= "INSERT INTO `abi_karten` (`user_id`, `karteNr`, `Vorname`, `Nachname`) VALUES ('$user_id', 'edit', '$VorN1', '$NachN1')";
				$db_erg = mysqli_query($db_link, $sql); // Einfügen, einzigartig durch "edit"
				$db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `karteNr` = 'edit'");
				$datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
				$k1 = $datensatz['id']; // ID herausfiltern
				$sql = "UPDATE `abi_karten` SET `karteNr` = '1' WHERE `abi_karten`.`id` = '".$k1."'";
				$db_erg = mysqli_query($db_link, $sql); // karteNr richtigstellen				
			$nachricht =  encode($bausteine[9]);
			$k2 = 0; $k3 = 0; $k4 = 0;
			$kosten = 1;
			break; }
		case '2': {
			// Ist der Name angegeben?
				if ( ($NachN1 == "") OR ($VorN1 == "") OR ($NachN2 == "") OR ($VorN2 == "") ) {
					echo "bitte gebe alle benötigten Namen an.<br>
					<a href='index.php'>Zurück</a>"; exit; }
			// Karten registrieren
				// Karte 1
				$sql= "INSERT INTO `abi_karten` (`user_id`, `karteNr`, `Vorname`, `Nachname`) VALUES ('$user_id', 'edit', '$VorN1', '$NachN1')";
				$db_erg = mysqli_query($db_link, $sql); // Einfügen, einzigartig durch "edit"
				$db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `karteNr` = 'edit'");
				$datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
				$k1 = $datensatz['id']; // ID herausfiltern
				$sql = "UPDATE `abi_karten` SET `karteNr` = '1' WHERE `abi_karten`.`id` = '$k1'";
				$db_erg = mysqli_query($db_link, $sql); // karteNr richtigstellen	
				// Karte 2
				$sql= "INSERT INTO `abi_karten` (`user_id`, `karteNr`, `Vorname`, `Nachname`) VALUES ('$user_id', 'edit', '$VorN2', '$NachN2')";
				$db_erg = mysqli_query($db_link, $sql); // Einfügen, einzigartig durch "edit"
				$db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `karteNr` = 'edit'");
				$datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
				$k2 = $datensatz['id']; // ID herausfiltern
				$sql = "UPDATE `abi_karten` SET `karteNr` = '2' WHERE `abi_karten`.`id` = '$k2'";
				$db_erg = mysqli_query($db_link, $sql); // karteNr richtigstellen	
				
			$nachricht =  encode($bausteine[9]);
			$k3 = 0; $k4 = 0;
			$kosten = 2;
			break; }
        default: header('location: index.php'); exit;
	}
	
// Kartenbestand einschränken
	$verfuegbar = $verfuegbar - $kosten;
	$sql = "UPDATE `abi_0_kartenfreischalt` SET `uebrig` = ".$verfuegbar." WHERE `timestamp` = ".$time.";";
	$check = mysqli_query($db_link, $sql);
	if (!$check) {
		include('../back-end/design_alpha.inc.php');
		include ('../back-end/design_beta.inc.php');
		echo "<p>Sorry, es ist zu einem Fehler gekommen.<br><br>
		<a href='index.php'>Zur&uuml;ck</a></p>";
		include ('../back-end/design_gamma.inc.php');
		exit; }
	
	
// Bestellung einfügen
	$datum = date("Y-m-d");
	$erklaerung = "keine Erklaerung"; 
	$sql = "INSERT INTO `abi_bestellung` (`BestellNr`, `user_id`, `karte1`, `karte2`, `karte3`, `karte4`, `Wunschkarten`, `Kommentar`, `datum`, `Bezahlt`) VALUES ('$Nummer', '$user_id', '$k1', '$k2', '$k3', '$k4', '$wunsch', '$erklaerung', '$datum', 'false');";
	$db_erg = mysqli_query($db_link, $sql);	
	if (!$db_erg) { echo "Ups, da ist wohl ein Fehler aufgetreten. Bitte versuche es sp&auml;ter oder morgen nochmal."; exit; }

	
// Ausgeben	
	include ('rechnung.inc.php'); // Rechnung speichern
	include('../back-end/design_alpha.inc.php');
	include ('../back-end/design_beta.inc.php');
    include ('rechnung.mail.inc.php'); // Mail versenden und Rechnung löschen
	echo ($nachricht."<br>".encode(str_ireplace("%RechnungsNummer%", $Nummer, $karten_bestellung_rechnung)));
	include ('../back-end/design_gamma.inc.php');
