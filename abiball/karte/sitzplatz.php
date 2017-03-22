<?php
/**
 * Sitzplatzreservierung wählen
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }


// LOGIK-KRIMSKRAMS: Tische suchen
$sql = "SELECT * FROM `abi_tische`;";
$db_erg = mysqli_query($db_link, $sql);
/** @var STRING $table_drop
 * Dropdown für die Tische
 */
$table_drop = "";
/** @var STRING $table_table
 * Tabelle für die Tische
 */
$table_table = "";
while ( $datensatz = mysqli_fetch_array($db_erg, MYSQL_ASSOC) ) {
    $t_Nummer = $datensatz["Nummer"];
    $t_Plaetze = $datensatz["Plaetze"];
    $t_Frei = $datensatz["Frei"];
    if ($t_Frei < 10) { $t_Frei = "0".$t_Frei; }

    $table_drop .= "<option value='".$t_Nummer."'>Tisch ".$t_Nummer." - ".$t_Frei." freie Plätze</option>";
    $table_table .= "<tr><td>Tisch ".$t_Nummer.":</td><td>".$t_Frei." von ".$t_Plaetze." Plätzen frei</td></tr>";
}

include('../back-end/design_alpha.inc.php');

/* echo '<script src="nachbestellen.js"></script>
    <link rel="stylesheet" type="text/css" href="../back-end/errors.css">'; */

include ('../back-end/design_beta.inc.php');

echo '<h1 id="title">Sitzplatzreservierung</h1>
	<form name="Sitzplatz" action="sitzplatzaufgeben.php" method="post"> <!--onsubmit="return chkFormular()"-->
	<a href="../img/sitzplan.PNG" target="_blank" style="float: left; width: 50%;"><img src="../img/sitzplan.PNG" width="100%"></a>
	<b>Folgende Tische haben folgende Anzahl an freien Plätzen:</b>
	<table>'.$table_table.'</table>
	<br><br>
	<table border="1">
	    <tr><th>Kartennr.</th></th><th>Karteninhaber</th><th>Tischnummer</th></tr>';



	// Alle Kartenbestellungen
	$sql = "SELECT * FROM `abi_bestellung`  WHERE `user_id` = '$user_id';";
	$db_erg = mysqli_query($db_link, $sql);
    $zaehl = 1;
	while ( $datensatz = mysqli_fetch_array($db_erg, MYSQL_ASSOC) ) {
		$k1 = $datensatz['karte1'];
			if ($k1 != 0) { // Vorname und Nachname ziehen
				$result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k1';");
				$karte = mysqli_fetch_array($result, MYSQL_ASSOC);
				$VorN1 = $karte['Vorname'];
				$NachN1 = $karte['Nachname'];
                $BisherZ = $karte['Tisch']; if ($BisherZ == "") {$Bisher = "--- Bitte wählen ---";} else {$Bisher = "reserviert: Tisch ".$BisherZ;}
				echo ' <tr><td>'.$k1.'</td><td>'.$VorN1.' '.$NachN1.'</td><td> <select name="karte_'.$zaehl.'">
				    <option selected="selected" value="'.$BisherZ.'">'.$Bisher.'</option>'.$table_drop.'</select>
				    <input name="k'.$zaehl.'" value="'.$k1.'" type="hidden">';
                $zaehl ++;
            }
		$k2 = $datensatz['karte2'];
			if ($k2 != 0) { // Vorname und Nachname ziehen
				$result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k2';");
				$karte = mysqli_fetch_array($result, MYSQL_ASSOC);
				$VorN2 = $karte['Vorname'];
				$NachN2 = $karte['Nachname'];
                $BisherZ = $karte['Tisch']; if ($BisherZ == "") {$Bisher = "--- Bitte wählen ---";} else {$Bisher = "reserviert: Tisch ".$BisherZ;}
                echo ' <tr><td>'.$k2.'</td><td>'.$VorN2.' '.$NachN2.'</td><td> <select name="karte_'.$zaehl.'">
				    <option selected="selected" value="'.$BisherZ.'">'.$Bisher.'</option>'.$table_drop.'</select>
				    <input name="k'.$zaehl.'" value="'.$k2.'" type="hidden">';
                $zaehl ++;
            }
		$k3 = $datensatz['karte3'];
			if ($k3 != 0) { // Vorname und Nachname ziehen
				$result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k3';");
				$karte = mysqli_fetch_array($result, MYSQL_ASSOC);
				$VorN3 = $karte['Vorname'];
				$NachN3 = $karte['Nachname'];
                $BisherZ = $karte['Tisch']; if ($BisherZ == "") {$Bisher = "--- Bitte wählen ---";} else {$Bisher = "reserviert: Tisch ".$BisherZ;}
                echo ' <tr><td>'.$k3.'</td><td>'.$VorN3.' '.$NachN3.'</td><td> <select name="karte_'.$zaehl.'">
				    <option selected="selected" value="'.$BisherZ.'">'.$Bisher.'</option>'.$table_drop.'</select>
				    <input name="k'.$zaehl.'" value="'.$k3.'" type="hidden">';
                $zaehl ++;
            }
		$k4 = $datensatz['karte4'];
			if ($k4 != 0) { // Vorname und Nachname ziehen
				$result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k4';");
				$karte = mysqli_fetch_array($result, MYSQL_ASSOC);
				$VorN4 = $karte['Vorname'];
				$NachN4 = $karte['Nachname'];
                $BisherZ = $karte['Tisch']; if ($BisherZ == "") {$Bisher = "--- Bitte wählen ---";} else {$Bisher = "reserviert: Tisch ".$BisherZ;}
                echo ' <tr><td>'.$k4.'</td><td>'.$VorN4.' '.$NachN4.'</td><td> <select name="karte_'.$zaehl.'">
				    <option selected="selected" value="'.$BisherZ.'">'.$Bisher.'</option>'.$table_drop.'</select>
				    <input name="k'.$zaehl.'" value="'.$k4.'" type="hidden">';
                $zaehl ++;
            }
	}
echo '</table>
Bitte beachte: Die Plätze können in der Zwischenzeit von anderen reserviert worden sein.
Du erhältst auf der nächsten Seite eine Bestätigung.
<input type="submit" value="Sitzplätze reservieren">
</form>';

include ('../back-end/design_gamma.inc.php');