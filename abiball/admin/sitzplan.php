<?php
/*
 * DER SITZPLAN
 * sortiert nach (Abiturienten-)Name, Tisch und Nr.
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

// Header & Footer festlegen
require('../fpdf/fpdf.php');
class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Arial bold 15
        $this->AddFont('MontS','','Montserrat-Regular.php');
        $this->SetFont('MontS','',20);
        // Title
        $this->Cell(0,10,'Abiball 2015 Unterhaching - Sitzplatzreservierung',0,0,'C');
        // Line break
        $this->Ln(15);
    }

    // Page footer
    function Footer()
    {
        // Position at 2.5 cm from bottom
        $this->SetY(-25);
        $this->Ln();
        $this->SetFont('MontS','',15);
        // Kontoverbindungsdaten etc
        //Defintion
        $this->Cell(0,10,'Stand vom: '.date("d.m.Y H:i:s"),0,0,'L');
        $this->Cell(0,10,'Seite '.$this->PageNo().' von {nb}',0,0,'R');
    }
}



//PDF Erzeugen
$pdf = new PDF('P', 'mm', 'A4'); // horizontales A4; Maße in mm

// ### NACH KARTENNUMMER ###
    // PDF-Seite erstellen
    $pdf->AddPage();
    $pdf->SetFont('MontS','',15);
    $pdf->Cell(0,10,'Nach Kartennummer sortiert',0,1,'C'); //Titel
    $pdf->ln(); // Leere Zeile
    $pdf->SetFont('Times','',12);

    // Tabelle
    //Tabellenüberschrift
    $pdf->SetFont('', 'B', '');
    $pdf->Cell(20,5,'Kartennr.','BR', 0, 'L');
    $pdf->Cell(90,5,'Nachname & Vorname','BR', 0, 'L');
    $pdf->Cell(60,5,'Nachname Abiturient','BR', 0, 'L');
    $pdf->Cell(20,5,'Tischnr.','B', 0,'L');
    $pdf->ln();
    $pdf->SetFont('', '', '10');

    $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` ORDER BY `id`");
    while ( $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC) ) {
        // Daten sammeln
        // von der Karte
        $Nummer = $datensatz['id'];
        $VorN = $datensatz['Vorname'];
        $NachN = $datensatz['Nachname'];
        $Tisch = $datensatz["Tisch"];
        $id = $datensatz['user_id']; // Nur f�r intern
        $karteNr = $datensatz['karteNr']; // Nur f�r intern
        // Vom Besteller
        $result = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$id';");
        $result = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $user = $result['Nachname'];

        $pdf->Cell(20,5,$Nummer,'TBR', 0, 'L');
        $pdf->Cell(90,5,utf8_decode($NachN.' '.$VorN),'TBR', 0,'L');
        $pdf->Cell(60,5,utf8_decode($user),'TBR', 0, 'L');
        $pdf->Cell(20,5,$Tisch,'TB', 0, 'L');
        $pdf->ln();
    }

// ### NACH TISCHNUMMER ###
// PDF-Seite erstellen
$pdf->AddPage();
$pdf->SetFont('MontS','',15);
$pdf->Cell(0,10,'Nach Tischnummer sortiert',0,1,'C'); //Titel
$pdf->ln(); // Leere Zeile
$pdf->SetFont('Times','',12);

// Tabelle
//Tabellenüberschrift
$pdf->SetFont('', 'B', '');
$pdf->Cell(20,5,'Tischnr.','BR', 0,'L');
$pdf->Cell(20,5,'Kartennr.','BR', 0, 'L');
$pdf->Cell(90,5,'Nachname & Vorname','BR', 0, 'L');
$pdf->Cell(60,5,'Nachname Abiturient','B', 0, 'L');
$pdf->ln();
$pdf->SetFont('', '', '10');

$db_erg = mysqli_query($db_link, "SELECT * FROM `abi_karten` ORDER BY `Tisch` ASC, `Nachname` ASC;");
while ( $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC) ) {
    // Daten sammeln
    // von der Karte
    $Nummer = $datensatz['id'];
    $VorN = $datensatz['Vorname'];
    $NachN = $datensatz['Nachname'];
    $Tisch = $datensatz["Tisch"];
    $id = $datensatz['user_id']; // Nur f�r intern
    $karteNr = $datensatz['karteNr']; // Nur f�r intern
    // Vom Besteller
    $result = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$id';");
    $result = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $user = $result['Nachname'];

    $pdf->Cell(20,5,$Tisch,'TBR', 0, 'L');
    $pdf->Cell(20,5,$Nummer,'TBR', 0, 'L');
    $pdf->Cell(90,5,utf8_decode($NachN.' '.$VorN),'TBR', 0,'L');
    $pdf->Cell(60,5,utf8_decode($user),'TB', 0, 'L');
    $pdf->ln();
}


//Meta Tags
$pdf->AliasNbPages();
$pdf->SetCreator('Abiball 2015 LMGU');
$pdf->SetSubject('Auflistung der Namen mit Tischen');
$pdf->SetTitle('Sitzplan Abiball 2015');

//$pdf->Output('Sitzplan.pdf', 'D'); // Datei zum Speichern ausgeben
$pdf->Output(); //Kontrollausgabe im Fenster
