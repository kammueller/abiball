<?php
/** DIE INCLUDE VARIANTE ZUM MAIL VERSCHICKEN
 * incl. Angabe der Gewünschten Karten, Kommentare etc
 *
 * @TODO CMS erweitern?
 * @TODO 50€ variabel machen?!
 */

// include('/back-end/logincheck.inc.php');  nicht notwendig, da "INC"

require __DIR__ . '../../vendor/autoload.php';
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }

// Textblöcke
include("../back-end/txt/pages/karten3.php");
	$auftrag = utf8_decode("\n
	Kunde: ".$Vorname." ".$Nachname." \n
	Bestellnummer: ".$Nummer."\n
	Auftragsdatum: ".date('d.m.Y') );
	$preis = iconv('UTF-8', 'windows-1252', '50,00€');
	$summe = $kosten * 50;
	$summe = iconv('UTF-8', 'windows-1252', $summe.',00€');
	$info = utf8_decode(str_ireplace("%nZ%", "\n", $bausteine[6]));

	$recht = utf8_decode(str_ireplace("%nZ%", "\n", $bausteine[7]));

// Header & Footer festlegen

class PDF extends FPDF
{

	// Page header
	function Header()
	{
        include("../back-end/txt/pages/karten3.php");
		// Arial bold 15
		$this->AddFont('MontS','','Montserrat-Regular.php');
		$this->SetFont('MontS','',15);
		// Title
		$this->Cell(0,10,$bausteine[8],0,0,'L');
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
        include("../back-end/txt/pages/karten3.php");
        $kontakt = utf8_decode("Kontakt \n
                    ".$bausteine[8]." \n
                    Erreichbar unter ".$bausteine[9]." \n
                    E-Mail: ".$bausteine[10]);
        $konto1 = utf8_decode("Konto \n
                    Kontoinhaber: ".$bausteine[0]." \n
                    IBAN: ".$bausteine[1]." \n
                    BIC: ".$bausteine[2]." \n ");
        $konto2 = utf8_decode("\n
                    Konto-Nr. ".$bausteine[3]."  \n
                    BLZ ".$bausteine[4]."  \n
                    ".$bausteine[5]."  ");
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
	//Meta Tags
		$pdf->SetCreator($bausteine[8]);
		$pdf->SetSubject('Rechnung Nummer '.$Nummer.' zur Kartenbestellung');
		$pdf->SetTitle('Kartenbestellung '.$Nummer);
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
			$pdf->Cell(120,5,utf8_decode('Persönliche Eintrittskarte für '.$VorN1.' '.$NachN1),'BR', 0,'L');	
			$pdf->Cell(30,5,$preis,'B', 0, 'L');
			$pdf->ln(); }
		//Zweite Karte
		if ($k2 != 0) {
			$pdf->Cell(40,5,$k2,'BR', 0, 'R');
			$pdf->Cell(120,5,utf8_decode('Persönliche Eintrittskarte für '.$VorN2.' '.$NachN2),'BR', 0,'L');	
			$pdf->Cell(30,5,$preis,'B', 0, 'L');
			$pdf->ln(); }
		//Dritte Karte
		if ($k3 != 0) {
			$pdf->Cell(40,5,$k3,'BR', 0, 'R');
			$pdf->Cell(120,5,utf8_decode('Persönliche Eintrittskarte für '.$VorN3.' '.$NachN3),'BR', 0,'L');	
			$pdf->Cell(30,5,$preis,'B', 0, 'L');
			$pdf->ln(); }
		//Vierte Karte
		if ($k4 != 0) {
			$pdf->Cell(40,5,$k4,'BR', 0, 'R');
			$pdf->Cell(120,5,utf8_decode('Persönliche Eintrittskarte für '.$VorN4.' '.$NachN4),'BR', 0,'L');	
			$pdf->Cell(30,5,$preis,'B', 0, 'L');
			$pdf->ln(); }
		//Summe
			$pdf->SetFont('', 'B', '12');
			$pdf->Cell(160,6,'Summe:', 'R' , 0, 'R');	
			$pdf->Cell(30,6, $summe ,0 , 1, 'L');
		
	// Erklärungstext
	$pdf->Cell(0,5, '', 0, 1); // Platzhalter
	$pdf->SetFont('', '', '10');	
	$pdf->MultiCell(0,5,$info); // Überweisungsauftrag
	
	
	// Zweite Seite, Rechtliches
    if ($bausteine[7] != "") {
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 5, 'Rechtliche Hinweise', 0, 1, 'C');
        $pdf->Ln();
        $pdf->SetFont('', '', '10');
        $pdf->MultiCell(0, 5, $recht);
    }
	
	$pdf->AliasNbPages();

	$pdfname = md5('rechnung'.$user_id);
	$pdf->Output($pdfname.'.pdf', 'F');	// Datei zum Speichern ausgeben
		//$pdf->Output(); //Kontrollausgabe im Fenster
