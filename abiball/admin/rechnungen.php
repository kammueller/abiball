<?php
/*
 * RECHNUNGEN EINES NUTZERS
 * PDF mit sämtlichen Rechnungen
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if (!( ($zugriff == 'all') OR ($zugriff == 'announce') OR ($zugriff =='verify') OR ($zugriff == 'finance') )) { header('location: ../home.php'); exit; }
	   
// Datenbank
	$user_id = mysqli_real_escape_string( $db_link, esc($_GET["id"]));
	$sql = "SELECT * FROM `abi_bestellung`  WHERE `user_id` = '$user_id';";
	$db_erg = mysqli_query($db_link, $sql); // Unten wird dann für jede gespeicherte Bestellung eine Seite hinzugefügt

// Fixe Textblöcke
	// Zur Bezahlung
	$info = utf8_decode("Bitte überweisen Sie oben genannte Summe innerhalb der nächsten 14 Tage auf das unten stehende Konto oder bezahlen Sie es bei einem der Repräsentanten des Abiball-Teams in Bar. \nNach Eingang und Registrierung der Zahlung werden Sie von uns per E-Mail benachrichtigt. \nBitte heben Sie diese Rechnung auf, um Missverständnisse klären oder Karten tauschen zu können. \nBitte beachten Sie, dass dies keine Rechnung im herkömmlichen Sinne darstellt, sondern viel mehr eine Reservierung. Die rechtlichen Genauigkeiten finden Sie auf der letzten Seite. \n \n
	Bitte beachten Sie, dass keine Teilzahlungen möglich sind, sondern die Summe gesammelt auf einmal gezahlt werden muss!	\n\n
	\nMit freundlichen Grüßen, \nMatthias Kammüller");
	// Rechtlliches
	$recht = utf8_decode("Blablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablablabla");

	// Header & Footer festlegen
	require('../fpdf/fpdf.php');
	class PDF extends FPDF
		{
		// Page header
		function Header()
		{
			// Arial bold 15
			$this->AddFont('MontS','','Montserrat-Regular.php');
			$this->SetFont('MontS','',15);
			// Title
			$this->Cell(0,10,'Abiball 2015 Unterhaching',0,0,'L');
			// Line break
			$this->Ln(15);
		}

		// Page footer
		function Footer()
		{
			// Position at 2.5 cm from bottom
			$this->SetY(-25);
			$this->SetFont('MontS','',8);
			// Kontoverbindungsdaten etc
				//Defintion
				$kontakt = utf8_decode("Kontakt \n
				Abiball 2015 LMGU \n
				Erreichbar unter www.lmgu-abiball.de \n
				E-Mail: webmaster@lmgu-abiball.de");
				$konto1 = utf8_decode("Konto \n
				Kontoinhaber: Matthias Kammüller \n
				IBAN: DE15 7025 0150 0027 7938 68 \n
				BIC: BYLADEM1KMS \n ");
				$konto2 = utf8_decode("\n
				Konto-Nr. 27793868 \n
				BLZ 702 501 50 \n
				Kreissparkasse München-Land ");
			$this->MultiCell(0,2,$kontakt);
			$this->SetXY(80,-25);
			$this->MultiCell(0,2,$konto1);
			$this->SetXY(150,-25);
			$this->MultiCell(0,2,$konto2);
			// Page number
			$this->SetX(10);
			$this->Cell(0,10,'Rechnung erstellt am '.date("d.m.Y H:i:s"),0,0,'L');
			$this->Cell(0,10,'Seite '.$this->PageNo().' von {nb}',0,0,'R');
		}
		}
		
		

//PDF Erzeugen
	$pdf = new PDF('P', 'mm', 'A4'); // horizontales A4; Maße in mm
	$Nummern = "";
		
	// Für jede Bestellung eine Seite
	while ( $datensatz = mysqli_fetch_array($db_erg, MYSQL_ASSOC) ) {
	// Daten sammeln
		// (`BestellNr`, `user_id`, `karte1`, `karte2`, `karte3`, `karte4`, `Wunschkarten`, `AlternativAnzahl`, `Kommentar`, `datum`, `Bezahlt`)
		// Datenbankendaten
		$Nummer = $datensatz['BestellNr'];
		$Nummern .= ", ".$Nummer;
		$Datum = $datensatz['datum'];
			$Date = date_create($Datum);
			$Datum = date_format($Date, 'd.m.Y');
		$Bezahlt = $datensatz['Bezahlt'];
		$Zahltag = $datensatz['BezAm'];
			$Date = date_create($Zahltag);
			$Zahltag = date_format($Date, 'd.m.Y');
		$KartenAnzahl = $datensatz['Wunschkarten'];

        // Namen leer setzen
        $VorN1 = $VorN2 = $VorN3 = $VorN4 = null;
        $NachN1 = $NachN2 = $NachN3 = $NachN4 = null;

		$k1 = $datensatz['karte1'];
			if ($k1 != 0) { // Vorname und Nachname ziehen
				$result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k1';");
				$karte = mysqli_fetch_array($result, MYSQL_ASSOC);
				$VorN1 = $karte['Vorname'];
				$NachN1 = $karte['Nachname']; }
		$k2 = $datensatz['karte2'];
			if ($k2 != 0) { // Vorname und Nachname ziehen
				$result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k2';");
				$karte = mysqli_fetch_array($result, MYSQL_ASSOC);
				$VorN2 = $karte['Vorname'];
				$NachN2 = $karte['Nachname']; }
		$k3 = $datensatz['karte3'];
			if ($k3 != 0) { // Vorname und Nachname ziehen
				$result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k3';");
				$karte = mysqli_fetch_array($result, MYSQL_ASSOC);
				$VorN3 = $karte['Vorname'];
				$NachN3 = $karte['Nachname']; }
		$k4 = $datensatz['karte4'];
			if ($k4 != 0) { // Vorname und Nachname ziehen
				$result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k4';");
				$karte = mysqli_fetch_array($result, MYSQL_ASSOC);
				$VorN4 = $karte['Vorname'];
				$NachN4 = $karte['Nachname']; }
		
		$kosten = 0; // Wird pro Karte erhöht

		$auftrag = utf8_decode("\n
		Kunde: ".$Vorname." ".$Nachname." \n
		Bestellnummer: ".$Nummer."\n
		Auftragsdatum: ".$Datum );
		$preis = iconv('UTF-8', 'windows-1252', '50,00€');

		
	
	// PDF-Seite erstellen
		$pdf->AddPage();
		$pdf->SetFont('MontS','',24);
		$pdf->Cell(0,10,'Rechnung Kartenbestellung',0,1,'C'); //Titel
		$pdf->ln(); // Leere Zeile
		$pdf->SetFont('Times','',12);
		$pdf->Cell(10,3); // Einrückung
		$pdf->MultiCell(0,3,$auftrag,0,'L'); //Auftragsbeschreibung
		$pdf->Ln(); $pdf->Ln(); $pdf->Ln();
		// Tabelle
			//Tabellenüberschrift
				$pdf->SetFont('', 'B', '');
				$pdf->Cell(40,5,'Kartennummer','BR', 0, 'R');
				$pdf->Cell(120,5,'Kartenbeschreibung','BR', 0,'L');	
				$pdf->Cell(30,5,'Preis','B', 0, 'L');
				$pdf->ln();
				$pdf->SetFont('', '', '10');
			//Erste Karte
			if ($k1 != 0) {
				$pdf->Cell(40,5,$k1,'BR', 0, 'R');
				$pdf->Cell(120,5,utf8_decode('Persönliche Eintrittskarte für ').$VorN1.' '.$NachN1,'BR', 0,'L');	
				$pdf->Cell(30,5,$preis,'B', 0, 'L');
				$pdf->ln();
				$kosten = $kosten + 1; }
			//Zweite Karte
			if ($k2 != 0) {
				$pdf->Cell(40,5,$k2,'BR', 0, 'R');
				$pdf->Cell(120,5,utf8_decode('Persönliche Eintrittskarte für ').$VorN2.' '.$NachN2,'BR', 0,'L');	
				$pdf->Cell(30,5,$preis,'B', 0, 'L');
				$pdf->ln();
				$kosten = $kosten + 1; }
			//Dritte Karte
			if ($k3 != 0) {
				$pdf->Cell(40,5,$k3,'BR', 0, 'R');
				$pdf->Cell(120,5,utf8_decode('Persönliche Eintrittskarte für ').$VorN3.' '.$NachN3,'BR', 0,'L');	
				$pdf->Cell(30,5,$preis,'B', 0, 'L');
				$pdf->ln(); 
				$kosten = $kosten + 1; }
			//Vierte Karte
			if ($k4 != 0) {
				$pdf->Cell(40,5,$k4,'BR', 0, 'R');
				$pdf->Cell(120,5,utf8_decode('Persönliche Eintrittskarte für ').$VorN4.' '.$NachN4,'BR', 0,'L');	
				$pdf->Cell(30,5,$preis,'B', 0, 'L');
				$pdf->ln(); 
				$kosten = $kosten + 1; }
			//Summe
				$summe = $kosten * 50;	$summe = iconv('UTF-8', 'windows-1252', $summe.',00€'); // Berechnen
				$pdf->SetFont('', 'B', '12');
				$pdf->Cell(160,6,'Summe:', 'R' , 0, 'R');	
				$pdf->Cell(30,6, $summe ,0 , 1, 'L');
			
		// Überweisungsauftrag
		$pdf->Cell(0,5, '', 0, 1); // Platzhalter
		$pdf->SetFont('', '', '10');	
		$pdf->Cell(0,10, '', 0, 1); // Platzhalter	
		if ( $Bezahlt == 'true' ) { // Wenn die Rechnung schon bezahlt wurde
			$pdf->SetFont('', 'B', '');
			$write = utf8_decode("Diese Rechnung wurde bereits am ".$Zahltag." beglichen. Bitte überweisen Sie das Geld NICHT nochmals.
			Die Bestellung wird hier bloß aus Gründen der Vollständigkeit und zum Verfügungstellen der Daten aufgeführt.");
			$pdf->MultiCell(0,5,$write);
			$pdf->SetFont('', '', '');
			$write = utf8_decode("Vielen Dank für ihre Bestellung.");
			$pdf->MultiCell(0,5,$write);
		} else {
			$pdf->MultiCell(0,5,$info); }
	}
	
	// Letzte Seite, Rechtliches
	$pdf->AddPage();
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(0,5,'Rechtliche Details',0,1,'C');
	$pdf->Ln();
	$pdf->SetFont('', '', '10');
	$pdf->MultiCell(0,5,$recht);
	
	
	//Meta Tags
		$pdf->AliasNbPages();
		$pdf->SetCreator('Abiball 2015 LMGU');
		$pdf->SetSubject('Rechnungen mit den Nummern '.$Nummern.' zur Kartenbestellung');
		$pdf->SetTitle('Kartenbestellung Abiball 2015');

	$pdf->Output('Kartenbestellung'.$Nummern.'.pdf', 'D'); // Datei zum Speichern ausgeben
		//$pdf->Output(); //Kontrollausgabe im Fenster
