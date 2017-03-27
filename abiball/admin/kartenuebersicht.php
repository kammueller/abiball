<?php
/* 
 * KARTEN�BERSICHT
 * �bersicht �ber alle Karten bzw. Detailansicht
 */

include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if ($zugriff != 'all') { header('location: ../home.php'); exit; }

// Content
	
	include('../back-end/design_alpha.inc.php');
	include ('../back-end/design_beta.inc.php');

	// Aus Datenbank ziehen
    if(isset($_GET['sort'])) {
        if ($_GET['sort'] != "") {
            $sort = "`" . $_GET['sort'] . "`";
        } else {
            $sort = "`id`";
        }  // Sortierung
        $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` ORDER BY " . $sort);
    } else {
        $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten`;");
    }
	
	
	// Alle Auflisten
	$Gesamt = 0; $BezGes = 0;
	echo " <h1>Kartenbestellungs-&Uuml;bersicht</h1>
	<table border=1>
		<tr>
			<th><a href='?sort=id'>Kartennr.</a></th>
			<th><a href='?sort=Vorname'>Vorname</a></th>
			<th><a href='?sort=Nachname'>Nachname</a></th>
			<th><a href='?sort=Tisch'>Tischnummer</a></th>
			<th><a href='?sort=user_id'>Besteller (sort by ID)</a></th>
			<th>Rechnungsnr.</th>
			<th>Bestelldatum</th>
			<th>Bezahlt?</th>
		</tr>";
		while ( $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC) ) {
			// Daten sammeln
				// von der Karte
				$Nummer = $datensatz['id'];
				$VorN = $datensatz['Vorname'];
				$NachN = $datensatz['Nachname'];
				$id = $datensatz['user_id']; // Nur f�r intern
				$karteNr = $datensatz['karteNr']; // Nur f�r intern
				// Vom Besteller
				$result = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$id';");
				$result = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$user = $result['Vorname']." ".$result['Nachname'];
				// Von der Bestellung
                $kartenSpalte = "karte".$karteNr;
				$rech = mysqli_query($db_link, "SELECT * FROM `abi_bestellung` WHERE `user_id` = '$id' AND `".$kartenSpalte."` = '$Nummer';");
				$rech = mysqli_fetch_array($rech, MYSQLI_ASSOC);
				$Bestellung = $rech['BestellNr'];
				$Datum = $rech['datum'];
					$Date = date_create($Datum);
					$Datum = date_format($Date, 'd.m.Y');
				$Bezahlt = $rech['Bezahlt'];
				
				
			
			// Tabelle auflisten
			echo "<tr>";
			echo "<td> ".$Nummer." </td>";
			echo "<td> ".$VorN." </td>";
			echo "<td> ".$NachN." </td>";
            echo "<td> ".$datensatz["Tisch"]." </td>";
			echo "<td> <a href='useruebersicht.php?id=".$id."'>".$user."</a> </td>";
			echo "<td> <a href='bestelluebersicht.php?nr=".$Bestellung."'>".$Bestellung."</a> </td>";
			echo "<td> ".$Datum." </td>";
			if ($Bezahlt == "true") {
				echo "<td> ja </td></tr>";
				$BezGes ++;
			} else {
				echo "<td> nein </td></tr>";
			}
			
			$Gesamt ++;

		}
		echo "</table><br>
		<p>Insgesamt wurden ".$Gesamt." Karten verkauft. Davon wurden bislang ".$BezGes." bezahlt.<br><br>
		<i>Hinweis: Die Bestellnummer setzt sich aus dem Datum (Monat, Tag), drei einstelligen Zufallszahlen und der zweistelligen Summe der Zufallszahlen zusammen.</i><br><br><br></p>";

	
	include ('../back-end/design_gamma.inc.php');