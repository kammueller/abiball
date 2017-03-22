<?php
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../home.php'); exit; }

if (isset($_POST["Vorname"]) && isset($_POST["Nachname"])) {
    $Vorname1 = mysqli_real_escape_string($db_link, esc($_POST["Vorname"]));
    $Nachname1 = mysqli_real_escape_string($db_link, esc($_POST["Nachname"]));
    // schon vorhanden?
    $result = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `Vorname` LIKE '$Vorname1' AND `Nachname` LIKE '$Nachname1'");
    $menge = mysqli_num_rows($result);
    if($menge == 0) {
        $eintrag = "INSERT INTO `abi_user` (password, Vorname, Nachname, Mail, verified) VALUES ('Neu', '$Vorname1', '$Nachname1', '---', 'false')";
        $eintragSQL = mysqli_query($db_link, $eintrag);

        if ($eintragSQL == true) {
            $erstellt = "Der Benutzer <b> ".$Vorname1 . " " . $Nachname1 . "</b> wurde erstellt.";
        } else {
            $erstellt = "Ups, da ist ein Fehler passiert";
        }
    } else {
        $erstellt = "Der Nutzer ist schon vorhanden!";
    }
} else {
    $erstellt = "";
}

include ('../back-end/design_alpha.inc.php');
include ('../back-end/design_beta.inc.php');
echo ('<h1>Neuen Nutzer anlegen</h1>
    '.$erstellt.'<br>
	<form name="Zurueck" action="100_newuser.php" method="post">
	<b>Bitte hier Vor- & Nachname des Nutzers eintragen</b><br>
	Vorname:	<input type="text" size="32" maxlength="32"	name="Vorname"><br>
	Nachname:	<input type="text" size="32" maxlength="32"	name="Nachname"><br>

	<input type="submit" value="Nutzer anlegen">
	</form>
');
include ('../back-end/design_gamma.inc.php');
