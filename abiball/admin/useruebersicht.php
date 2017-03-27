<?php
/*
 * USERÜBERSICHT
 * Übersicht aller User bzw. Detailansicht
 * mit Direktzugriff auf Validierung und Sperrung
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../home.php'); exit; }

	include('../back-end/design_alpha.inc.php');
	include ('../back-end/design_beta.inc.php');
		
// Ggf. User bestätigen
    if (isset($_POST['id'])) {
        $weg = mysqli_real_escape_string( $db_link, esc($_POST['id']));
		$sql = mysqli_query($db_link, "UPDATE `abi_user` SET `verified` = 'true' WHERE `id` = '$weg' AND `verified` = 'mail'");
		if (mysqli_affected_rows($db_link) == 1) {
		    include ("mail.freischalten.inc.php");
		} else { echo "E-Mail wurde bereits versendet!"; }
    }


	if (isset($_GET['id'])) {
    // Einzelansicht
        $id = mysqli_real_escape_string($db_link, esc($_GET['id']));
        // Daten sammeln
            // User herausfinden
            $sql = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$id'");
            $datensatz = mysqli_fetch_array($sql, MYSQLI_ASSOC);
            $user = $datensatz['Vorname']." ".$datensatz['Nachname'];
            $user_vn = $datensatz['Vorname'];
            $mail = $datensatz['Mail'];
			$blockiert = false;
            switch ($datensatz['verified']) {
                case 'false':
                    $verify = "Mailadresse muss noch best&auml;tigt werden<br>";
                    break;
                case 'mail' :
                    $verify = "<form name='Yes_Id".$datensatz['id']."' action='useruebersicht.php' method='post'>
                    <input type='text' size='8' maxlength='8' name='id' style='display: none;' value='".$datensatz['id']."'>
                    <input type='submit' value='Validieren'> </form>";
                    break;
                case 'true' :
                    $verify = "Account ist aktiviert<br>";
                    break;
                case 'geblockt' :
                    $verify = "Account wurde gesperrt<br>";
					$blockiert = true;
                    break;
                case 'newMail' :
                    $verify = "Mailadresse wurde ge&auml;ndert<br>";
                    break;
            }
            // Sperren bzw. Sperrbericht
            if ( $datensatz['verified'] == 'geblockt') {
                $block = "<a href='blockbericht.php?id=".$datensatz['id']."'>Sperrbericht ansehen</a><br><br>";
            } else {
                $block = "<form name='No_Id".$datensatz['id']."' action='ablehnen.php' method='post'>
                <input type='text' size='8' maxlength='8' name='id' style='display: none;' value='".$datensatz['id']."'>
                <input type='submit' value='User blockieren'> </form>";		}
            // Bestellungen herausfinden
            $sql = mysqli_query($db_link, "SELECT * FROM `abi_bestellung` WHERE `user_id` ='$id'");
            $menge = mysqli_num_rows($sql);
            if ($menge == '0') {
                $karten = "Es wurden noch keine Kartenbestellungen in Auftrag gegeben.<br>";
            } else {
                $karten = "Folgende Bestellungen wurden in Auftrag gegeben: ";
                while ( $datensatz = mysqli_fetch_array($sql, MYSQLI_ASSOC) ) {
                    $karten .= "<a href='bestelluebersicht.php?nr=".$datensatz['BestellNr']."'>".$datensatz['BestellNr']."</a> "; }
                $karten .= "<br>
                <a href='rechnungen.php?id=".$id."'>Alle Rechnungen als PDF</a><br>"; }

        // Ausgeben
            echo "<h1>User&uuml;bersicht ".$user."</h1>";
            echo $user_vn." ist bei uns mit der Mailadresse ".$mail." registriert.<br>
            <b>Accountstatus</b>: ".$verify." &nbsp; &nbsp; &nbsp; ".$block."
            ".$karten."<br><br>";
            // Email-Adresse ändern
			if (!$blockiert) {
            echo ('
                <h2>Mail-Adresse ändern</h2>
                <form name="changeMail" action="user_newMail.php" method="post" onsubmit="return chkMail()" id="mail">
                    <input type="hidden" name="user" value="'.$id.'">
                    <input type="text" size="32" maxlength="32"	name="newMail" value="neue Mail-Adresse" onfocus="LeerenMail()"><input type="submit" value="Bestätigungs-Mail zuschicken" id="submit" style="font-size: 12pt;"><br>
                    <i>Hinweis:</i> Der User kann sich wieder anmelden, wenn er diese E-Mail-Adresse best&auml;tigt hat!<br>
                </form>
            '); }
            // Passwort ändern
            echo ('
                <h2>Passwort ändern</h2>
                <form name="changePass" action="user_newPass.php" method="post" onsubmit="return chkPass()">
                    Der Benutzer bekommt ein zufallsgeneriertes Passwort per Mail zugesendet.
                    <input type="hidden" name="user" value="'.$id.'">
                    <input type="submit" value="Passwort &auml;ndern" id="submit" style="font-size: 12pt;"><br>
                </form>
            ');
            echo "<a href='index.php'>Zur&uuml;ck zur Admin-Konsole</a><br>";
			
	} else {
    // Gesamtübersicht
        //Daten sammeln
        if (isset($_GET["sort"])) {
            if ($_GET['sort'] != "") {
                $sort = "`" . $_GET['sort'] . "`";
            } else {
                $sort = "`Nachname`";
            }
            $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_user` ORDER BY " . $sort);
        } else {
            $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_user`;");
        }
        // Ausgeben
        echo "<h2>User&uuml;bersicht</h2>";
        if( ($menge = mysqli_num_rows($db_erg)) != 0 ) {
            echo "
			<table border=1>
				<tr>
					<th><a href='?sort=id'>id</a></th>
					<th><a href='?sort=Vorname'>Vorname</a></th>
					<th><a href='?sort=Nachname'>Nachname</a></th>
					<th><a href='?sort=Mail'>Mail</a></th>
					<th><a href='?sort=verified'>G&uuml;ltiger Account?</a></th><th>Account sperren</th>
				</tr>";
            while ( $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC) ) {
                echo "<tr>";
                echo "<td>".$datensatz['id']."</td>";
                echo "<td>".$datensatz['Vorname']."</td>";
                echo "<td><a href=?id=".$datensatz['id'].">".$datensatz['Nachname']."</a></td>";
                echo "<td>".$datensatz['Mail']."</td>";
                echo "<td>";
                // Gültiger Account?
                switch ($datensatz['verified']) {
                    case 'false':
                        echo "Mailadresse muss noch best&auml;tigt werden";
                        break;
                    case 'mail' :
                        echo "<form name='Yes_Id".$datensatz['id']."' action='useruebersicht.php' method='post'>
							<input type='text' size='8' maxlength='8' name='id' style='display: none;' value='".$datensatz['id']."'>
							<input type='submit' value='Validieren'> </form>";
                        break;
                    case 'true' :
                        echo "Account ist aktiviert";
                        break;
                    case 'geblockt' :
                        echo "Account wurde gesperrt";
                        break;
                    case 'newMail' :
                        echo "Mailadresse wurde ge&auml;ndert";
                        break;
                }
                echo "</td>";
                echo "<td>";
                // Sperren bzw. Sperrbericht
                if ( $datensatz['verified'] == 'geblockt') {
                    echo "<a href='blockbericht.php?id=".$datensatz['id']."'>Sperrbericht ansehen</a>";
                } else {
                    echo "<form name='No_Id".$datensatz['id']."' action='ablehnen.php' method='post'>
						<input type='text' size='8' maxlength='8' name='id' style='display: none;' value='".$datensatz['id']."'>
						<input type='submit' value='User blockieren'> </form>";
                }
                echo "</td>";
                echo "</tr>";
            }
            echo "</table><br><br>";
            echo "<a href='index.php'>Zur&uuml;ck zur Admin-Konsole</a><br>";
        } else {
            echo "Oh, du Gl&uuml;cklicher, es gibt keine Arbeit zu tun<br>
			<a href='index.php'>Zur&uuml;ck zur Admin-Konsole</a><br>"; } }

	
	include ('../back-end/design_gamma.inc.php');
		
	
