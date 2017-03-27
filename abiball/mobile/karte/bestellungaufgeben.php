<?php
/**
 * BESTELLUNG SPEICHERN
 * von der ersten Bestellphase
 */
include('../../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }

include("../../back-end/txt/pages/karten1.php");
include ("../../back-end/txt/karten_links.php");

// Schon bestellt?
    $sql = "SELECT * FROM `abi_bestellung` WHERE `user_id` = ".$user_id;
    $result = mysqli_query($db_link, $sql);
    $menge = mysqli_num_rows($result);
    if ($menge != "0") {
        include('../design_alpha.inc.php');
        include ('../design_beta.inc.php');
        echo encode($bausteine[5], true);
        include ('../design_gamma.inc.php');
        exit;
    }

	   
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
	$VorN3 = mysqli_real_escape_string( $db_link, esc($_POST['VorN3']));
		$NachN3 = mysqli_real_escape_string( $db_link, esc($_POST['NachN3']));
	$VorN4 = mysqli_real_escape_string( $db_link, esc($_POST['VorN4']));
		$NachN4 = mysqli_real_escape_string( $db_link, esc($_POST['NachN4']));
	$wunsch = mysqli_real_escape_string( $db_link, esc($_POST['anz']));
	$erklaerung = mysqli_real_escape_string( $db_link, esc($_POST['kommi']));
	if ( ($erklaerung == "Hier kannst Du weitere Kommentare hinterlassen") OR ($erklaerung == "") ) { 
		//Wenn Keine Erkl�rung angegben worden ist
		$erklaerung = "keine Erklaerung"; }
	// Die erste Karte muss f�r den Abiturienten sein
	$result = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$user_id'");
	$datensatz = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$VorN = $datensatz['Vorname']; $NachN = $datensatz['Nachname'];
	if ( ($VorN1 != $VorN) OR ($NachN1 != $NachN) ) {
		include ('../design_alpha.inc.php');
		include ('../design_beta.inc.php');
		echo "Du musst eine Karte (die erste) f&uuml;r dich selber bestellen.<br>
		Da kommst du auch mit HTML-Kenntnissen nicht drum herum ;-)<br><br>
		<a href='index.php'>Zur&uuml;ck</a>";
		include ('../design_gamma.inc.php');
		exit; }

// Je nach Anzahl Karten
// Je nach Anzahl Karten
switch ($wunsch) {
    case '0': {
        //Keine Karten gewünscht
        $nachricht = encode($bausteine[14]);
        $k1 = 0; $k2 = 0; $k3 = 0; $k4 = 0;
        $kosten = 0;
        break; }
    case '1': { // Eine Karte
        // Karte registieren
        $sql= "INSERT INTO `abi_karten` (`user_id`, `karteNr`, `Vorname`, `Nachname`) VALUES ('$user_id', 'edit', '$VorN1', '$NachN1')";
        $db_erg = mysqli_query($db_link, $sql); // Einf�gen, einzigartig durch "edit"
        $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `karteNr` = 'edit'");
        $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
        $k1 = $datensatz['id']; // ID herausfiltern
        $sql = "UPDATE `abi_karten` SET `karteNr` = '1' WHERE `abi_karten`.`id` = '$k1'";
        $db_erg = mysqli_query($db_link, $sql); // karteNr richtigstellen
        $nachricht =  encode($bausteine[15], true);
        $k2 = 0; $k3 = 0; $k4 = 0;
        $kosten = 1;
        break; }
    case '2': {
        // Ist der Name angegeben?
        if ( ($NachN2 == "") OR ($VorN2 == "") ) {
            echo "bitte gebe alle benötigten Namen an.<br>
					<a href='index.php'>Zur&uuml;ck</a>"; exit; }
        // Karten registrieren
        // Karte 1
        $sql= "INSERT INTO `abi_karten` (`user_id`, `karteNr`, `Vorname`, `Nachname`) VALUES ('$user_id', 'edit', '$VorN1', '$NachN1')";
        $db_erg = mysqli_query($db_link, $sql); // Einf�gen, einzigartig durch "edit"
        $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `karteNr` = 'edit'");
        $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
        $k1 = $datensatz['id']; // ID herausfiltern
        $sql = "UPDATE `abi_karten` SET `karteNr` = '1' WHERE `abi_karten`.`id` = '$k1'";
        $db_erg = mysqli_query($db_link, $sql); // karteNr richtigstellen
        // Karte 2
        $sql= "INSERT INTO `abi_karten` (`user_id`, `karteNr`, `Vorname`, `Nachname`) VALUES ('$user_id', 'edit', '$VorN2', '$NachN2')";
        $db_erg = mysqli_query($db_link, $sql); // Einf�gen, einzigartig durch "edit"
        $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `karteNr` = 'edit'");
        $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
        $k2 = $datensatz['id']; // ID herausfiltern
        $sql = "UPDATE `abi_karten` SET `karteNr` = '2' WHERE `abi_karten`.`id` = '$k2'";
        $db_erg = mysqli_query($db_link, $sql); // karteNr richtigstellen

        $nachricht =  encode($bausteine[15], true);
        $k3 = 0; $k4 = 0;
        $kosten = 2;
        break; }
    case '3': {
        // Sind die Namen angegeben?
        if ( ($NachN2 == "") OR ($VorN2 == "") OR ($NachN3 == "") OR ($VorN3 == "") ) {
            echo "bitte gebe alle benötigten Namen an.<br>
					<a href='index.php'>Zur&uuml;ck</a>"; exit; }
        // Karten registrieren
        // Karte 1
        $sql= "INSERT INTO `abi_karten` (`user_id`, `karteNr`, `Vorname`, `Nachname`) VALUES ('$user_id', 'edit', '$VorN1', '$NachN1')";
        $db_erg = mysqli_query($db_link, $sql); // Einf�gen, einzigartig durch "edit"
        $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `karteNr` = 'edit'");
        $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
        $k1 = $datensatz['id']; // ID herausfiltern
        $sql = "UPDATE `abi_karten` SET `karteNr` = '1' WHERE `abi_karten`.`id` = '$k1'";
        $db_erg = mysqli_query($db_link, $sql); // karteNr richtigstellen
        // Karte 2
        $sql= "INSERT INTO `abi_karten` (`user_id`, `karteNr`, `Vorname`, `Nachname`) VALUES ('$user_id', 'edit', '$VorN2', '$NachN2')";
        $db_erg = mysqli_query($db_link, $sql); // Einf�gen, einzigartig durch "edit"
        $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `karteNr` = 'edit'");
        $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
        $k2 = $datensatz['id']; // ID herausfiltern
        $sql = "UPDATE `abi_karten` SET `karteNr` = '2' WHERE `abi_karten`.`id` = '$k2'";
        $db_erg = mysqli_query($db_link, $sql); // karteNr richtigstellen
        // Karte 3
        $sql= "INSERT INTO `abi_karten` (`user_id`, `karteNr`, `Vorname`, `Nachname`) VALUES ('$user_id', 'edit', '$VorN3', '$NachN3')";
        $db_erg = mysqli_query($db_link, $sql); // Einf�gen, einzigartig durch "edit"
        $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `karteNr` = 'edit'");
        $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
        $k3 = $datensatz['id']; // ID herausfiltern
        $sql = "UPDATE `abi_karten` SET `karteNr` = '3' WHERE `abi_karten`.`id` = '$k3'";
        $db_erg = mysqli_query($db_link, $sql); // karteNr richtigstellen

        $nachricht =  encode($bausteine[15], true);
        $k4 = 0;
        $kosten = 3;
        break; }
    case '4': {
        // Sind die Namen angegeben?
        if ( ($NachN2 == "") OR ($VorN2 == "") OR ($NachN3 == "") OR ($VorN3 == "") OR ($NachN4 == "") OR ($VorN4 == "") ) {
            echo "bitte gebe alle benötigten Namen an.<br>
					<a href='index.php'>Zur&uuml;ck</a>"; exit; }
        // Karten registrieren
        // Karte 1
        $sql= "INSERT INTO `abi_karten` (`user_id`, `karteNr`, `Vorname`, `Nachname`) VALUES ('$user_id', 'edit', '$VorN1', '$NachN1')";
        $db_erg = mysqli_query($db_link, $sql); // Einf�gen, einzigartig durch "edit"
        $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `karteNr` = 'edit'");
        $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
        $k1 = $datensatz['id']; // ID herausfiltern
        $sql = "UPDATE `abi_karten` SET `karteNr` = '1' WHERE `abi_karten`.`id` = '$k1'";
        $db_erg = mysqli_query($db_link, $sql); // karteNr richtigstellen
        // Karte 2
        $sql= "INSERT INTO `abi_karten` (`user_id`, `karteNr`, `Vorname`, `Nachname`) VALUES ('$user_id', 'edit', '$VorN2', '$NachN2')";
        $db_erg = mysqli_query($db_link, $sql); // Einf�gen, einzigartig durch "edit"
        $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `karteNr` = 'edit'");
        $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
        $k2 = $datensatz['id']; // ID herausfiltern
        $sql = "UPDATE `abi_karten` SET `karteNr` = '2' WHERE `abi_karten`.`id` = '$k2'";
        $db_erg = mysqli_query($db_link, $sql); // karteNr richtigstellen
        // Karte 3
        $sql= "INSERT INTO `abi_karten` (`user_id`, `karteNr`, `Vorname`, `Nachname`) VALUES ('$user_id', 'edit', '$VorN3', '$NachN3')";
        $db_erg = mysqli_query($db_link, $sql); // Einf�gen, einzigartig durch "edit"
        $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `karteNr` = 'edit'");
        $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
        $k3 = $datensatz['id']; // ID herausfiltern
        $sql = "UPDATE `abi_karten` SET `karteNr` = '3' WHERE `abi_karten`.`id` = '$k3'";
        $db_erg = mysqli_query($db_link, $sql); // karteNr richtigstellen
        // Karte 4
        $sql= "INSERT INTO `abi_karten` (`user_id`, `karteNr`, `Vorname`, `Nachname`) VALUES ('$user_id', 'edit', '$VorN4', '$NachN4')";
        $db_erg = mysqli_query($db_link, $sql); // Einf�gen, einzigartig durch "edit"
        $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `karteNr` = 'edit'");
        $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
        $k4 = $datensatz['id']; // ID herausfiltern
        $sql = "UPDATE `abi_karten` SET `karteNr` = '4' WHERE `abi_karten`.`id` = '$k4'";
        $db_erg = mysqli_query($db_link, $sql); // karteNr richtigstellen

        $kosten = 4;
        $nachricht =  encode($bausteine[15], true);
        break; }
    default: { // Wenn mehr als vier Karten gewünscht sind
    // Das selbe wie bei 4; Ausgeben, dass bloß 4 Karten, etc
    // Sind die Namen angegeben?
    if ( ($NachN2 == "") OR ($VorN2 == "") OR ($NachN3 == "") OR ($VorN3 == "") OR ($NachN4 == "") OR ($VorN4 == "") ) {
        echo "bitte gebe alle benötigten Namen an.<br>
					<a href='index.php'>Zur&uuml;ck</a>"; exit; } /*@TODO cms */
    // Karten registrieren
    // Karte 1
    $sql= "INSERT INTO `abi_karten` (`user_id`, `karteNr`, `Vorname`, `Nachname`) VALUES ('$user_id', 'edit', '$VorN1', '$NachN1')";
    $db_erg = mysqli_query($db_link, $sql); // Einf�gen, einzigartig durch "edit"
    $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `karteNr` = 'edit'");
    $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
    $k1 = $datensatz['id']; // ID herausfiltern
    $sql = "UPDATE `abi_karten` SET `karteNr` = '1' WHERE `abi_karten`.`id` = '$k1'";
    $db_erg = mysqli_query($db_link, $sql); // karteNr richtigstellen
    // Karte 2
    $sql= "INSERT INTO `abi_karten` (`user_id`, `karteNr`, `Vorname`, `Nachname`) VALUES ('$user_id', 'edit', '$VorN2', '$NachN2')";
    $db_erg = mysqli_query($db_link, $sql); // Einf�gen, einzigartig durch "edit"
    $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `karteNr` = 'edit'");
    $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
    $k2 = $datensatz['id']; // ID herausfiltern
    $sql = "UPDATE `abi_karten` SET `karteNr` = '2' WHERE `abi_karten`.`id` = '$k2'";
    $db_erg = mysqli_query($db_link, $sql); // karteNr richtigstellen
    // Karte 3
    $sql= "INSERT INTO `abi_karten` (`user_id`, `karteNr`, `Vorname`, `Nachname`) VALUES ('$user_id', 'edit', '$VorN3', '$NachN3')";
    $db_erg = mysqli_query($db_link, $sql); // Einf�gen, einzigartig durch "edit"
    $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `karteNr` = 'edit'");
    $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
    $k3 = $datensatz['id']; // ID herausfiltern
    $sql = "UPDATE `abi_karten` SET `karteNr` = '3' WHERE `abi_karten`.`id` = '$k3'";
    $db_erg = mysqli_query($db_link, $sql); // karteNr richtigstellen
    // Karte 4
    $sql= "INSERT INTO `abi_karten` (`user_id`, `karteNr`, `Vorname`, `Nachname`) VALUES ('$user_id', 'edit', '$VorN4', '$NachN4')";
    $db_erg = mysqli_query($db_link, $sql); // Einf�gen, einzigartig durch "edit"
    $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `karteNr` = 'edit'");
    $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
    $k4 = $datensatz['id']; // ID herausfiltern
    $sql = "UPDATE `abi_karten` SET `karteNr` = '4' WHERE `abi_karten`.`id` = '$k4'";
    $db_erg = mysqli_query($db_link, $sql); // karteNr richtigstellen

    $kosten = 4;
    $nachricht =  encode($bausteine[15], true)."<br>". encode($bausteine[16], true);
    }
}



// Bestellung einfügen
$datum = date("Y-m-d");
$sql = "INSERT INTO `abi_bestellung` (`BestellNr`, `user_id`, `karte1`, `karte2`, `karte3`, `karte4`, `Wunschkarten`, `Kommentar`, `datum`, `Bezahlt`) VALUES ('$Nummer', '$user_id', '$k1', '$k2', '$k3', '$k4', '$wunsch', '$erklaerung', '$datum', 'false');";
$db_erg = mysqli_query($db_link, $sql);
// if (!$db_erg) { echo "Ups, da ist wohl ein Fehler aufgetreten. Bitte versuche es sp&auml;ter oder morgen nochmal."; exit; } - TODO unnütz, besser bauen!!

// Falls 0 Karten, dann direkt bezahlt
if ($wunsch == 0) {
    $date = date("Y-m-d");
    $sql = mysqli_query($db_link, "UPDATE `abi_bestellung` SET `Bezahlt` = 'true', `BezAm` = '$date', `admin_id` = '0', `BezArt` = '0', `BezKom` = 'nicht notwendig' WHERE `BestellNr` = '$Nummer';");
    $db_erg = mysqli_query($db_link, $sql); }

// Ausgeben	
	include ('rechnung.inc.php'); // Rechnung speichern
	include ('../design_alpha.inc.php');
	include ('../design_beta.inc.php');
    echo ($nachricht."<br>".encode(str_ireplace("%RechnungsNummer%", $Nummer, $karten_bestellung_rechnung)));
	include ('rechnung.mail.inc.php'); // Mail versenden und Rechnung l�schen
	include ('../design_gamma.inc.php');
	
	
