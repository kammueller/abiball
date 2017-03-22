<?php
/*
 * BESTELLUNG FREISCHALTEN
 * erzeugt eine neue Welle an freizuschaltenden Karten
 * und zeigt die Woche der bisherigen an
 * (Anm.: die erste Welle hat den Timestamp 100 und keine Karten-begrenzung - diese kann auch hier�ber beendet werden
 *
 * BEN�TIGT h�chste Adminrechte
 */

include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../home.php'); exit; }

if(isset($_POST['action'])) {
    $ende = mysqli_real_escape_string($db_link, esc($_POST['action']));
// Soll die Garantie-Phase beendet werden?
    if ($ende == "garantieEndeJetzt") {
        $sql = "UPDATE `abi_0_kartenfreischalt` SET `uebrig` = '0' WHERE `timestamp` = 100;";
        $db_erg = mysqli_query($db_link, $sql);
        if ($db_erg) {
            $success = "Garantie-Phase erfolgreich beendet.<br>
		Bestellungen, dir gerade im Vorgang sind, werden erst in max. 10 Minuten beendet";
        } else {
            $error = "Ups, es ist zu einem Fehler gekommen.<br>
		Bitte versuche es erneut.";
        }
    }
}

if(isset($_POST['action'])) {
    $action = mysqli_real_escape_string($db_link, esc($_POST['action']));
// Soll ein neuer Kartenschwall freigegeben werden?
    if ($action == "neueBestellung") {
        if(isset($_POST["tag"]) && isset($_POST["anz"])) {
            $start = mysqli_real_escape_string($db_link, esc($_POST['tag']));
            $ende = mysqli_real_escape_string($db_link, esc($_POST['tag'] + 24 * 60 * 60));
            $freischalten = rand($start, $ende);
            $anzahl = mysqli_real_escape_string($db_link, esc($_POST['anz']));
            $sql = "INSERT INTO `abi_0_kartenfreischalt` (`timestamp`, `anzahl`, `uebrig`, `reserviert`) VALUES ('$freischalten', '$anzahl', '$anzahl', '0');";
            $db_erg = mysqli_query($db_link, $sql);
            if ($db_erg) {
                $success = "Neue Bestellung erfolgreich angelegt.<br>
		        Achtung: Neu laden gibt einen neuen Schwall frei!";
            } else {
                $error = "Ups, es ist zu einem Fehler gekommen.<br>
		        Bitte versuche es erneut.";
            }
        }
    }
// Soll ein Kartenschwung doch nicht freigegeben werden? 
    if ($action == "SchwungVerhindern") {
        if(isset($_POST["time"])) {
            $delete = mysqli_real_escape_string($db_link, esc($_POST['time']));
            $sql = "DELETE FROM `abi_0_kartenfreischalt` WHERE `timestamp` = '$delete'";
            $db_erg = mysqli_query($db_link, $sql);
            if ($db_erg) {
                $success = "Bestellung-M&ouml;glichkeit erfolgreich gel&ouml;scht.<br>
		        Ggf. bitte im Blog updaten!";
            } else {
                $error = "Ups, es ist zu einem Fehler gekommen.<br>
		        Bitte versuche es erneut.";
            }
        }
    }
}


// Gibt es übrige Karten, die jetzt schon freigeschaltet sind?
	$sql = "SELECT * FROM `abi_0_kartenfreischalt` WHERE `timestamp` < ".time()." AND `uebrig` > 0 AND `reserviert` < `uebrig` LIMIT 1;";
	$db_erg = mysqli_query($db_link, $sql);
	$datensatz = mysqli_fetch_array($db_erg, MYSQL_ASSOC);
	$timestamp = $datensatz['timestamp'];
	$menge = mysqli_num_rows($db_erg);
	
	if ($menge == "0") {
		// Keine Tickets mehr
		$momentan = "<p>Leider gibt es zur Zeit keine Tickets</p>";
	} else {
		// Tickets verf&uuml;gbar
		// erste Bestellungsmarge? (TIMESTAMP: 100)
		if ($timestamp == "100") {
			$momentan = "<p>Wir sind momentan in der ersten Bestellungsrunde.<br>
			Hier erh&auml;lt jeder bis zu 4 Karten garantiert.</p>";
		} else {
			$momentan =  "<p>In diesem Moment werden Zusatzkarten vergeben.</p>";
		}
	}

// Content
	
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
	
	echo '<h1>Momentan vergebene Karten</h1>';
	echo $momentan."<br><br>";
	
	if ($timestamp == "100") {
	echo "<h1>Garantie-Runde beenden</h1>
	<p>Hiermit kannst du die erste Runde (in der jeder bis zu vier Karten bestellen kann) beenden.<br>
	Bitte beachte, dass diese Entscheidung endg&uuml;ltig ist und nur in der Datenbank r&uuml;ckg&auml;ngig gemacht werden kann!</p>
	<form name='garantieende' action='bestellungfreischalten.php' method='post'>
		<input type='hidden' size='8' maxlength='30' name='action' value='garantieEndeJetzt'>
	<input type='submit' value='JETZT BEENDEN'> </form> <br><br>"; }
	
	echo '<h1>An folgenden Tagen werden Karten freigegeben:</h1>
	<p>(Die Garantie-Phase ausgeschlossen)</p>
	<table border=1>
		<tr><th>Tag</th><th>Menge</th><th>davon sind &uuml;brig</th><th>momentan reserviert</th><th></th></tr>';
	$db_erg = mysqli_query($db_link, "SELECT * FROM `abi_0_kartenfreischalt` WHERE `timestamp` > 100");
	while ( $datensatz = mysqli_fetch_array($db_erg, MYSQL_ASSOC) ) {
		echo '<tr><td>'.date("d.m.Y", $datensatz["timestamp"]).'</td><td>'.$datensatz["anzahl"].'</td><td>'.$datensatz["uebrig"].'</td><td>'.$datensatz["reserviert"].'</td>';
		if ( mktime(date("d.m.Y", $datensatz["timestamp"])) < time() ) {
			echo '<td><form  action="bestellungfreischalten.php" method="post">
				<input type="hidden" size="8" maxlength="12" name="time" value="'.$datensatz["timestamp"].'">
				<input type="hidden" size="8" maxlength="30" name="action" value="SchwungVerhindern">
				<input type="submit" value="Wieder l&ouml;schen"> </form></td>';
		} else { echo '<td></td>'; }
		echo '</tr>';
	}
	echo "</table>
	<br><br>";
		
	
	$eins = mktime(0, 0, 0, date("m") , date("d")+1, date("Y"));
	$zwei = mktime(0, 0, 0, date("m") , date("d")+2, date("Y"));
	$drei = mktime(0, 0, 0, date("m") , date("d")+3, date("Y"));
	$vier = mktime(0, 0, 0, date("m") , date("d")+4, date("Y"));
	$fuenf = mktime(0, 0, 0, date("m") , date("d")+5, date("Y"));
	$sechs = mktime(0, 0, 0, date("m") , date("d")+6, date("Y"));
	$sieben = mktime(0, 0, 0, date("m") , date("d")+7, date("Y"));
	echo '<h1>Neuen Kartenschwall freigeben</h1>
	<form name="neueKarten" action="bestellungfreischalten.php" method="post">
		An welchem Tag sollen die Karten freigegeben werden?
		<select name="tag" size="0">
			<option value="'.$eins.'">'.date('d.m.y', $eins).'</option>
			<option value="'.$zwei.'">'.date('d.m.y', $zwei).'</option>
			<option value="'.$drei.'">'.date('d.m.y', $drei).'</option>
			<option value="'.$vier.'">'.date('d.m.y', $vier).'</option>
			<option value="'.$fuenf.'">'.date('d.m.y', $fuenf).'</option>
			<option value="'.$sechs.'">'.date('d.m.y', $sechs).'</option>
			<option value="'.$sieben.'">'.date('d.m.y', $sieben).'</option>
		</select><br>
		Wie viele Karten sollen freigegeben werden? <input type="number" min="1" max="100" name="anz" value="20" style="width: 50px"><br>
		<i>Anmerkung:</i> Pro Tag kann jeder blo&szlig; 2 Karten bestellen. Die Karten werden irgendwann an oben gew&auml;hltem Tag freigeschaltet.<br>
		<input type="hidden" size="8" maxlength="30" name="action" value="neueBestellung"> <input type="submit" value="Kartenschub anlegen">
	</form><br><br>';
	
	include ('../back-end/design_gamma.inc.php');

