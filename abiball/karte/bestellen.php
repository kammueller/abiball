<?php
/*
 * BESTELLUNG
 * für die erste Marge
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }

include("../back-end/txt/pages/karten1.php");

// Schon bestellt?
	$sql = "SELECT * FROM `abi_bestellung` WHERE `user_id` = ".$user_id;
	$result = mysqli_query($db_link, $sql);
	$menge = mysqli_num_rows($result);
	if ($menge != "0") {
		include('../back-end/design_alpha.inc.php');
		include ('../back-end/design_beta.inc.php');
		echo encode($bausteine[5]);
		include ('../back-end/design_gamma.inc.php');
		exit;
	}

// Content
	
	include('../back-end/design_alpha.inc.php');
	
	echo '<script src="karte.js"></script>
	<link rel="stylesheet" type="text/css" href="../back-end/errors.css">';
	
	include ('../back-end/design_beta.inc.php');
	
	echo '<h1 id="title">Kartenbestellung</h1>
	<form name="Kartenbestellung" action="bestellungaufgeben.php" method="post" onsubmit="return chkFormular()">
	'.encode($bausteine[6]).'<br><br>
	'.encode($bausteine[7]).' <input type="number" min="0" max="10" name="anz" value="4" style="width: 50px"><br>
	'.encode($bausteine[8]).'<br><br>
	
	'.encode($bausteine[9]).'<br>
	Karte 1: <input type="text" size="20" maxlength="32" name="VorN1" value="'.$Vorname.'" style="display: none">
	<input type="hidden" size="25" maxlength="32" name="NachN1" value="'.$Nachname.'"> '.$Vorname.' '.$Nachname.encode($bausteine[10]).'<br>
	Karte 2: <input type="text" size="20" maxlength="32" name="VorN2" placeholder="Vorname"> <input type="text" size="25" maxlength="32" name="NachN2" placeholder="Nachname"><br>
	Karte 3: <input type="text" size="20" maxlength="32" name="VorN3" placeholder="Vorname"> <input type="text" size="25" maxlength="32" name="NachN3" placeholder="Nachname"><br>
	Karte 4: <input type="text" size="20" maxlength="32" name="VorN4" placeholder="Vorname"> <input type="text" size="25" maxlength="32" name="NachN4" placeholder="Nachname"><br>
	<p class="error" id="namen">Bitte alle Namen angeben!</p>
	<br>

    <script>
        function KommiWeg() {
        if (document.Kartenbestellung.kommi.value == "'.encode($bausteine[11]).'") {
            document.Kartenbestellung.kommi.value = "";
            document.Kartenbestellung.kommi.focus();}
        document.Kartenbestellung.kommi.style.color = "#000";
        document.Kartenbestellung.kommi.style.fontStyle = "normal";
        }
    </script>
	<textarea name="kommi" cols="50" rows="5" id="input" onfocus="KommiWeg();">'.encode($bausteine[11]).'</textarea><br><br>

	<input type="reset" value="'.encode($bausteine[12]).'"> <input type="submit" value="'.encode($bausteine[13]).'">
	</form>';
	
	include ('../back-end/design_gamma.inc.php');

