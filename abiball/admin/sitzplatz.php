<?php
/*
 * SITZPLÄTZE HINZUFÜGEN
 */

include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../home.php'); exit; }

//Hinzufügen
if(isset($_POST["anz"])) {
    $anzahl = mysqli_real_escape_string($db_link, esc($_POST['anz']));
    $sql = "INSERT INTO `abi_tische` (`Plaetze`, `Frei`) VALUES ('$anzahl', '$anzahl');";
    $db_erg = mysqli_query($db_link, $sql);
    if ($db_erg) {
        $success = "Neuer Tisch hinzugefügt<br>
            Bearbeiten nur in der DB möglich!<br><!-- todo change this -->
            NEU LADEN LEGT NEUEN TISCH AN!";
    } else {
        $error = "Ups, es ist zu einem Fehler gekommen.<br>
		        Bitte versuche es erneut.";
    }
}

include('../back-end/design_alpha.inc.php');
echo '<link rel="stylesheet" type="text/css" href="message.css">
	<script src="message.js"></script>';
include ('design_beta.admin.inc.php');

if ( isset($success) ) { echo ('
	<div class="success" id="message">
		'.$success.'
	</div>'); }
if ( isset($error) ) { echo ('
	<div class="error" id="message">
		'.$error.'
	</div>'); }

// BISHERIGE
$sql = "SELECT * FROM `abi_tische`;";
$db_erg = mysqli_query($db_link, $sql);
/** @var STRING $table_drop
 * Dropdown für die Tische
 */
$table_table = "";
while ( $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC) ) {
    $t_Nummer = $datensatz["Nummer"];
    $t_Plaetze = $datensatz["Plaetze"];
    $t_Frei = $datensatz["Frei"];
    if ($t_Frei < 10) { $t_Frei = "0".$t_Frei; }
    $table_table .= "<tr><td>Tisch ".$t_Nummer.":</td><td>".$t_Frei." von ".$t_Plaetze." Plätzen frei</td></tr>";
}
echo '<h1>Bestehende Tische</h1>
	<table>'.$table_table.'</table>';

echo '<h1>Nächsten Tisch hinzufügen</h1>
	<form name="Nächster Tisch" action="sitzplatz.php" method="post">
		Tisch-Nummer: <i>wird automatisch berechnet</i><br>
		Anzahl an Plätzen, die zur Verfügung stehen: <input name="anz" type="number" min="0" max="99"><br>
		<input type="submit" value="Tisch hinzufügen">
	</form><br><br>
	Der Sitzplan muss als PNG-File auf dem Server liegen unter /img/Sitzplan.PNG<br><br><br>
	<a href="sitzplan.php">Sitzplan als PDF</a>';

include ('../back-end/design_gamma.inc.php');