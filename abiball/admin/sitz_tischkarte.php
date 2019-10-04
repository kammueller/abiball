<?php
/*
 * TISCHKARTEN
 * für jeden einzelnen Tisch
 */
require __DIR__ . '../../vendor/autoload.php';
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if (!( ($zugriff == 'all') OR ($zugriff == 'announce') OR ($zugriff =='verify') OR ($zugriff == 'finance') )) { header('location: ../home.php'); exit; }

// Datenbank
$user_id = mysqli_real_escape_string( $db_link, esc($_GET["id"]));
$sql = "SELECT * FROM `abi_tische`;";
$db_erg = mysqli_query($db_link, $sql); // Unten wird dann für jede gespeicherte Bestellung eine Seite hinzugefügt




// Header & Footer festlegen
class PDF extends FPDF
{

    // Page header
    function Header()
    {
        $this->AddFont('MontS','','Montserrat-Regular.php');
        $this->AddFont('mono','','MTCORSVA.php');
        // Title
        //$this->Cell(0,10,'Abiball 2015 Unterhaching - Sitzplatzreservierung',0,0,'C');
        // Line break
        //$this->Ln(15);
    }

}



//PDF Erzeugen
$pdf = new PDF('L', 'mm', 'A5'); // vertikales A5; Maße in mm


$db_erg = mysqli_query($db_link, "SELECT * FROM `abi_tische` ORDER BY `Nummer`");
while ( $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC) ) {
    $pdf->AddPage();
    // Daten sammeln
    // vom Tisch
    $Nummer = $datensatz['Nummer'];
    $frei = $datensatz['Frei'];

    $pdf->ln();$pdf->ln();$pdf->ln();
    $pdf->SetFont('mono','',100);
    $pdf->Cell(0,30,$Nummer,0,0,'C');
    $pdf->ln();
    $pdf->SetFont('mono','',24);
    $pdf->Cell(0,5,utf8_decode("Anzahl an freien Plätzen:").$frei,0,0,'C');

    // Vom Besteller
    $result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `Tisch` = '$Nummer';");
    while ( $namenliste = mysqli_fetch_array($result, MYSQLI_ASSOC) ) {
        $VorN = $namenliste['Vorname'];
        $NachN = $namenliste['Nachname'];
        $pdf->Cell(0, 5, utf8_decode($VorN . ' ' . $NachN), 0, 0, 'C');
        $pdf->ln();
    }
}



//Meta Tags
$pdf->AliasNbPages();
$pdf->SetCreator('Abiball 2015 LMGU');
$pdf->SetSubject('Tischkarten');
$pdf->SetTitle('Sitzplan Abiball 2015');

//$pdf->Output('Sitzplan.pdf', 'D'); // Datei zum Speichern ausgeben
$pdf->Output(); //Kontrollausgabe im Fenster

