<?php
/**DIE VARIANTE ZUR DYNAMISCHEN AUSGABE ALLER RECHNUNGEN
 *  Wunschkartenanzahl wird angegeben, mehr Details nicht
 *
 * @TODO CMS erweitern?
 * @TODO 50€ variabel machen?!
 */

include('../../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }

// Datenbank
$sql = "SELECT * FROM `abi_bestellung`  WHERE `user_id` = '$user_id';";
$db_erg = mysqli_query($db_link, $sql); // Unten wird dann für jede gespeicherte Bestellung eine Seite hinzugefügt

// Textblöcke
include("../../back-end/txt/pages/karten3.php");
$info = utf8_decode(str_ireplace("%nZ%", "\n", $bausteine[6]));

$recht = utf8_decode(str_ireplace("%nZ%", "\n", $bausteine[7]));

// Header & Footer festlegen
require('../../fpdf/fpdf.php');
class PDF extends FPDF
{

    // Page header
    function Header()
    {
        include("../../back-end/txt/pages/karten3.php");
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
        include("../../back-end/txt/pages/karten3.php");
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
        $NachN1 = $karte['Nachname'];
    }
    $k2 = $datensatz['karte2'];
    if ($k2 != 0) { // Vorname und Nachname ziehen
        $result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k2';");
        $karte = mysqli_fetch_array($result, MYSQL_ASSOC);
        $VorN2 = $karte['Vorname'];
        $NachN2 = $karte['Nachname'];
    }
    $k3 = $datensatz['karte3'];
    if ($k3 != 0) { // Vorname und Nachname ziehen
        $result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k3';");
        $karte = mysqli_fetch_array($result, MYSQL_ASSOC);
        $VorN3 = $karte['Vorname'];
        $NachN3 = $karte['Nachname'];
    }
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
        $pdf->Cell(120,5,utf8_decode('Persönliche Eintrittskarte für '.$VorN1.' '.$NachN1),'BR', 0,'L');
        $pdf->Cell(30,5,$preis,'B', 0, 'L');
        $pdf->ln();
        $kosten = $kosten + 1; }
    //Zweite Karte
    if ($k2 != 0) {
        $pdf->Cell(40,5,$k2,'BR', 0, 'R');
        $pdf->Cell(120,5,utf8_decode('Persönliche Eintrittskarte für '.$VorN2.' '.$NachN2),'BR', 0,'L');
        $pdf->Cell(30,5,$preis,'B', 0, 'L');
        $pdf->ln();
        $kosten = $kosten + 1; }
    //Dritte Karte
    if ($k3 != 0) {
        $pdf->Cell(40,5,$k3,'BR', 0, 'R');
        $pdf->Cell(120,5,utf8_decode('Persönliche Eintrittskarte für '.$VorN3.' '.$NachN3),'BR', 0,'L');
        $pdf->Cell(30,5,$preis,'B', 0, 'L');
        $pdf->ln();
        $kosten = $kosten + 1; }
    //Vierte Karte
    if ($k4 != 0) {
        $pdf->Cell(40,5,$k4,'BR', 0, 'R');
        $pdf->Cell(120,5,utf8_decode('Persönliche Eintrittskarte für '.$VorN4.' '.$NachN4),'BR', 0,'L');
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
        $write = utf8_decode("Diese Rechnung wurde bereits am ".$Zahltag." beglichen.".str_ireplace("%nZ%", "\n", $bausteine[11]));
        $pdf->MultiCell(0,5,$write);
        $pdf->SetFont('', '', '');
        $write = utf8_decode(str_ireplace("%nZ%", "\n", $bausteine[12]));
        $pdf->MultiCell(0,5,$write);
    } else {
        $pdf->MultiCell(0,5,$info); }
}

// Letzte Seite, Rechtliches
if ($bausteine[7] != "") {
    $pdf->AddPage();
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 5, 'Rechtliche Hinweise', 0, 1, 'C');
    $pdf->Ln();
    $pdf->SetFont('', '', '10');
    $pdf->MultiCell(0, 5, $recht);
}


//Meta Tags
$pdf->AliasNbPages();
$pdf->SetCreator($bausteine[8]);
$pdf->SetSubject('Rechnungen mit den Nummern '.$Nummern.' zur Kartenbestellung');
$pdf->SetTitle('Kartenbestellung Abiball 2015');

$pdf->Output('Kartenbestellung'.$Nummern.'.pdf', 'D'); // Datei zum Speichern ausgeben
//$pdf->Output(); //Kontrollausgabe im Fenster
