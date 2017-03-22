<?php
/**
 * SITZPLATZRESERVIERUNG AUFGEBEN
 * landing page - aktualisiert die entsprechende Karte und gibt eine Rückmeldung
 */

include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }

// Daten ziehen
echo $_POST["0"];
$i = 1;
$rueckmeldung = "";
while (isset ($_POST["k".$i])) {
    $karten_id = mysqli_real_escape_string($db_link, esc($_POST["k".$i]));
// Deine Karte?!
    $check = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$karten_id';");
    $datensatz = mysqli_fetch_array($check, MYSQL_ASSOC);
    if ($datensatz['user_id'] != $user_id) {
        include('../back-end/design_alpha.inc.php');
        include('../back-end/design_beta.inc.php');
        echo '<h1 id="title">Sitzplatzreservierung</h1>
		Diese Karte gehört nicht dir!!';
        /* @TODO CMS */
        include('../back-end/design_gamma.inc.php');
        exit;
    }
    $neuer_platz = mysqli_real_escape_string($db_link, esc($_POST["karte_".$i]));
    if (!is_numeric($neuer_platz)) {
        $neuer_platz = "NULL";      // Wenn keine Zahl als Tischnummer angegeben wurde
    } else {
        // Tischnummer gültig?
        $tisch = mysqli_fetch_array(mysqli_query($db_link, "SELECT * FROM `abi_tische` WHERE `Nummer` = ".$neuer_platz), MYSQL_ASSOC);
        if ($tisch["Nummer"]=="") {
            include('../back-end/design_alpha.inc.php');
            include('../back-end/design_beta.inc.php');
            echo '<h1 id="title">Sitzplatzreservierung</h1>
            Fehler in der Tischnummer!';
            /* @TODO CMS */
            include('../back-end/design_gamma.inc.php');
            exit;
        }
        // Liegt eine Änderung vor?
        if ($neuer_platz == $datensatz["Tisch"]) {
            $rueckmeldung .= "Die Karte Nummer <b>".$karten_id."</b> hat ihren Sitzplatz behalten.<br>";
            $neuer_platz = "---";
        } else {
            // Ist der Sitzplatz frei?
            if ($tisch["Frei"] == "0") {
                // falls nein - beibehalten!
                $rueckmeldung .= "Der Karte Nummer <b>" . $karten_id . "</b> konnte der Sitzplatz <b>nicht zugewiesen werden</b>.
                Bitte versuche es erneut mit einem anderen Tisch.<br>";
                $neuer_platz = "---";
            } else {
                $frei = $tisch["Frei"] - 1;
                mysqli_query($db_link, "UPDATE `abi_tische` SET `Frei` = '" . $frei . "' WHERE `Nummer` = " . $tisch["Nummer"] . ";");
                $rueckmeldung .= "Der Karte Nummer  <b>" . $karten_id . "</b> wurde ein Sitzplatz am Tisch Nummer
            <b>" . $tisch["Nummer"] . "</b> zugewiesen werden. <br>";
            }
        }

    }
    if ($neuer_platz != "---") {
        mysqli_query($db_link, "UPDATE `abi_karten` SET `Tisch` = " . $neuer_platz . " WHERE `abi_karten`.`id` = '" . $karten_id . "';");
    }
    $i ++;
}


include('../back-end/design_alpha.inc.php');
include ('../back-end/design_beta.inc.php');

echo '<h1 id="title">Kartentausch</h1>
	Es wurden Sitzplätze für die Karten wie folgt reserviert:<br><br>
	'.$rueckmeldung.'<br><br>
	Sollte etwas nicht geklappt haben, probier es einfach <a href="sitzplatz.php">nochmal</a>.<br>
	Die Sitzplätze können noch beliebig geändert werden.';

include ('../back-end/design_gamma.inc.php');