<?php
/*
 * BESTELLÜBERSICHT
 * Übersicht über alle Bestellungen bzw. Detailansicht
 *
 * TODO Fehler mit Gesamtzahl?!
 */

include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if (!( ($zugriff == 'all') OR ($zugriff == 'finance') )) { header('location: ../home.php'); exit; }

// Content
	
	include('../back-end/design_alpha.inc.php');
	include ('../back-end/design_beta.inc.php');

    if (isset($_GET['nr'])) {
    // EINZELANSICHT
        $Nummer = mysqli_real_escape_string( $db_link, esc($_GET['nr'] ) );

        // Bestellung heraussuchen
            $sql = mysqli_query($db_link, "SELECT * FROM `abi_bestellung` WHERE `BestellNr` = '$Nummer'");
            $datensatz = mysqli_fetch_array($sql, MYSQL_ASSOC);
            $id = $datensatz['user_id'];
            $wunsch = $datensatz['Wunschkarten'];
            $Kommi = $datensatz['Kommentar'];
            $datum_raw = $datensatz['datum'];
            $Date = date_create($datum_raw);
            $Datum = date_format($Date, 'd.m.Y');
            $Bezahlt = $datensatz['Bezahlt'];
            $Zahltag = $datensatz['BezAm'];
            $Date = date_create($Zahltag);
            $Zahltag = date_format($Date, 'd.m.Y');
            $admin_id = $datensatz['admin_id'];
            $Zahlart1 = $datensatz['BezArt'];
            $Zahlart2 = $datensatz['BezKom'];
            $mahnung = $datensatz['mahnung'];

        // Karten heraussuchen
            // Dummies setzen
                $KartenAnz = 0;
                $VorN1 = $VorN2 = $VorN3 = $VorN4 = null;
                $NachN1 = $NachN2 = $NachN3 = $NachN4 = null;

            $k1 = $datensatz['karte1'];
            if ($k1 != 0) { // Vorname und Nachname ziehen
                $result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k1';");
                $karte = mysqli_fetch_array($result, MYSQL_ASSOC);
                $VorN1 = $karte['Vorname'];
                $NachN1 = $karte['Nachname'];
                $KartenAnz = 1;	}
            $k2 = $datensatz['karte2'];
            if ($k2 != 0) { // Vorname und Nachname ziehen
                $result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k2';");
                $karte = mysqli_fetch_array($result, MYSQL_ASSOC);
                $VorN2 = $karte['Vorname'];
                $NachN2 = $karte['Nachname'];
                $KartenAnz = 2; }
            $k3 = $datensatz['karte3'];
            if ($k3 != 0) { // Vorname und Nachname ziehen
                $result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k3';");
                $karte = mysqli_fetch_array($result, MYSQL_ASSOC);
                $VorN3 = $karte['Vorname'];
                $NachN3 = $karte['Nachname'];
                $KartenAnz = 3; }
            $k4 = $datensatz['karte4'];
            if ($k4 != 0) { // Vorname und Nachname ziehen
                $result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k4';");
                $karte = mysqli_fetch_array($result, MYSQL_ASSOC);
                $VorN4 = $karte['Vorname'];
                $NachN4 = $karte['Nachname'];
                $KartenAnz = 4; }

        // Besteller herausfinden
            $sql = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$id'");
            $datensatz = mysqli_fetch_array($sql, MYSQL_ASSOC);
            $user = $datensatz['Vorname']." ".$datensatz['Nachname'];
            $user_vn = $datensatz['Vorname'];


        // AUSGEBEN
            echo "<h1>Kartenbestellung ".$Nummer."</h1>";
            if ($zugriff == 'all') { echo "
                <p>Der User <a href='?id=".$id."'><i>".$user."</i></a> hat am <i>".$Datum." ".$KartenAnz."</i> Karten bestellt.<br>";
            } else { echo "<p>Der User <i>".$user."</i> hat am <i>".$Datum." ".$KartenAnz."</i> Karten bestellt.<br>"; }
            echo "Dabei wurden folgende Karten bestellt:</p>
            <table border=1> <tr> <th>Kartennummer</th> <th>Ausgestellt auf:</th> </tr>";
            // Kartendetails
            if ($k1 != 0) {
                echo "<tr> <td>".$k1."</td> <td>".$VorN1." ".$NachN1."</td></tr>"; }
            if ($k2 != 0) {
                echo "<tr> <td>".$k2."</td> <td>".$VorN2." ".$NachN2."</td></tr>"; }
            if ($k3 != 0) {
                echo "<tr> <td>".$k3."</td> <td>".$VorN3." ".$NachN3."</td></tr>"; }
            if ($k4 != 0) {
                echo "<tr> <td>".$k4."</td> <td>".$VorN4." ".$NachN4."</td></tr>"; }
            echo "</table>";
            echo "<p>Die Bestellung wurde folgendermaßen kommentiert: <i>".encode($Kommi)."</i><br><br>"; // Wunschkarten
            if ($Bezahlt == 'true') {
                // Falls bezahlt wurde
                // Admin herausfinden, ...
                    $sql = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$admin_id'");
                    $datensatz = mysqli_fetch_array($sql, MYSQL_ASSOC);
                    $admin = $datensatz['Vorname']." ".$datensatz['Nachname'];
                    $admin_vn = $datensatz['Vorname'];
                    $sql = mysqli_query($db_link, "SELECT * FROM `abi_admin` WHERE `user_id` = '$admin_id'");
                    $datensatz = mysqli_fetch_array($sql, MYSQL_ASSOC);
                    switch ($datensatz['rechte']) {
                        case 'all':
                            $admin_rights = "alle verf&uuml;gbaren Rechte";
                            break;
                        case 'announce':
                            $admin_rights = "Administrator mit Seiten-Editierungsrecht";
                            break;
                        case 'verify':
                            $admin_rights = "Blo&szlig; Verifizierungsrechte";
                            break; }
                // ... Daten anzeigen ...
                    echo "Es wurde von dem Administrator <i>".$admin."</i> mit der ID ".$admin_id." am ".$Zahltag." folgende Zahlung registriert:<br>
                    Art der Zahlung: <i>".$Zahlart1."</i><br>
                    Kommentar zur Zahlung: <i>".$Zahlart2."</i><br><br>";
                    echo "Der Administrator ist dabei die folgenden Rechte: ".$admin_rights." <br><br></p>" ;
                // ... und R�ckg�ngig machen anbieten
                    if ($zugriff == 'all') {
                        echo "<table> <tr>";
                        echo "<td> <form name='Zur&uumlckziehen_Nr".$Nummer."' action='zahlungrevidieren.php' method='get'>
                                    <input type='text' size='8' maxlength='12' name='nr' style='display: none;' value='".$Nummer."'>
                                    <input type='submit' value='Zahlung f&uuml;r ".$Nummer." revidieren'> </form> </td>";
                        echo "<td> <form name='Entadmin_ID".$admin_id."' action='noadmin.php' method='get'>
                                    <input type='text' size='8' maxlength='8' name='id' style='display: none;' value='".$admin_id."'>
                                    <input type='submit' value='".$admin_vn." Adminrechte entziehen'> </form> </td> </table> <br>"; }

            } else {
                // sonst Möglichkeit zum Zahlungseingang bieten	...
                echo "<table> <tr>";
                echo "<td> <form name='Zahlung_Nr" . $Nummer . "' action='zahlungregistrieren.php' method='get'>
                        <input type='hidden' maxlength='12' name='nr' value='" . $Nummer . "'>
                        <input type='submit' value='Zahlung f&uuml;r " . $Nummer . " registrieren'> </form> </td>";
                // ... Wenn seit 14 Tagen unbezahlt / seit 7 Tagen nicht gemahnt:
                if (isset($mahnung)) {
                    // Vor 7 Tagen das letzte Mal gemahnt?
                    $mahnung1 = strtotime( $mahnung );
                    $early_mahn = $mahnung1 + 60*60*24*7;  // fr�hestes Blockierdatum
                    if ( mktime() > $early_mahn ) {
                        echo "<td> <form name='Mahnung_Nr" . $Nummer . "' action='mail.mahnung.php' method='post'>
                             <input type='hidden' maxlength='12' name='nr' value='" . $Nummer . "'>
                            <input type='submit' value='Benutzer ERNEUT abmahnen \n (letzte Mahnung: ".$mahnung.")'> </form> </td>";
                    } else {
                        echo "<td>Nutzer wurde gemahnt. (".$mahnung.")</td>";
                    }
                } else {
                    $mahnung = strtotime( $datum_raw );
                    $early_mahn = $mahnung + 60*60*24*14;
                    if ( mktime() > $early_mahn ) {
                        echo "<td> <form name='Mahnung_Nr" . $Nummer . "' action='mail.mahnung.php' method='post'>
                            <input type='hidden' maxlength='12' name='nr' value='" . $Nummer . "'>
                            <input type='submit' value='Benutzer abmahnen'> </form> </td>";
                    }
                }

                // ... und Bestellung l�schen
                if ($zugriff == 'all') {
                    echo "<td> <form name='Loeschen_Nr".$Nummer."' action='bestellungloeschen.php' method='post'>
                            <input type='hidden' size='8' maxlength='12' name='nr' value='".$Nummer."'>
                            <input type='submit' value='Bestellung ".$Nummer." l&ouml;schen'> </form> </td>"; }
                echo "</tr></table><br>"; }

    } else {
        // Sortierung
            if (isset($_GET['sort'])) { $sort = "`".$_GET['sort']."`"; } else { $sort = "`BestellNr`"; }
            $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_bestellung` ORDER BY ".$sort);

        // Alle Auflisten
            $Gesamt = 0; $BezGes = 0; $Verkauft = 0;
            echo " <h1>Kartenbestellungs-&Uuml;bersicht</h1>
            <table border=1>
                <tr>
                    <th><a href='?sort=BestellNr'>Bestellnr.</a></th>
                    <th><a href='?sort=user_id'>User (sort by ID)</a></th>
                    <th><a href='?sort=Wunschkarten'>Kartenanzahl</a></th>
                    <th><a href='?sort=Bezahlt'>Bezahlt?</a></th>
                    <th>Kommentar vorhanden?</th>
                </tr>";
            while ( $datensatz = mysqli_fetch_array($db_erg, MYSQL_ASSOC) ) {
                // Daten sammeln
                $Nummer = $datensatz['BestellNr'];
                $id = $datensatz['user_id'];
                $wunsch = $datensatz['Wunschkarten'];
                $Kommi = $datensatz['Kommentar'];
                $Datum = $datensatz['datum'];
                $Date = date_create($Datum);
                $Datum = date_format($Date, 'd.m.Y');
                $Bezahlt = $datensatz['Bezahlt'];
                $Zahltag = $datensatz['BezAm'];
                $Date = date_create($Zahltag);
                $Zahltag = date_format($Date, 'd.m.Y');
                $admin_id = $datensatz['admin_id'];
                $Zahlart1 = $datensatz['BezArt'];
                $Zahlart2 = $datensatz['BezKom'];
                // Karten heraussuchen
                $KartenAnz = 0;
                $k1 = $datensatz['karte1'];
                if ($k1 != 0) { // Vorname und Nachname ziehen
                    $result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k1';");
                    $karte = mysqli_fetch_array($result, MYSQL_ASSOC);
                    $VorN1 = $karte['Vorname'];
                    $NachN1 = $karte['Nachname'];
                    $KartenAnz = 1;	}
                $k2 = $datensatz['karte2'];
                if ($k2 != 0) { // Vorname und Nachname ziehen
                    $result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k2';");
                    $karte = mysqli_fetch_array($result, MYSQL_ASSOC);
                    $VorN2 = $karte['Vorname'];
                    $NachN2 = $karte['Nachname'];
                    $KartenAnz = 2; }
                $k3 = $datensatz['karte3'];
                if ($k3 != 0) { // Vorname und Nachname ziehen
                    $result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k3';");
                    $karte = mysqli_fetch_array($result, MYSQL_ASSOC);
                    $VorN3 = $karte['Vorname'];
                    $NachN3 = $karte['Nachname'];
                    $KartenAnz = 3; }
                $k4 = $datensatz['karte4'];
                if ($k4 != 0) { // Vorname und Nachname ziehen
                    $result = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$k4';");
                    $karte = mysqli_fetch_array($result, MYSQL_ASSOC);
                    $VorN4 = $karte['Vorname'];
                    $NachN4 = $karte['Nachname'];
                    $KartenAnz = 4; }
                // Falls bezahlt: Admin herausfinden
                if ($Bezahlt == 'true') {
                    $sql = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$admin_id'");
                    $userData = mysqli_fetch_array($sql, MYSQL_ASSOC);
                    $admin = $userData['Vorname']." ".$userData['Nachname'];
                    $admin_vn = $userData['Vorname'];
                    $sql = mysqli_query($db_link, "SELECT * FROM `abi_admin` WHERE `user_id` = '$admin_id'");
                    $adminData = mysqli_fetch_array($sql, MYSQL_ASSOC);
                    switch ($adminData['rechte']) {
                        case 'all':
                            $admin_rights = "alle verf&uuml;gbaren Rechte";
                            break;
                        case 'announce':
                            $admin_rights = "Administrator mit Seiten-Editierungsrecht";
                            break;
                        case 'verify':
                            $admin_rights = "Blo&szlig; Verifizierungsrechte";
                            break; } }
                // Kommentiert?
                if ($datensatz['Kommentar'] == "keine Erklaerung") {
                    $KommiDa = "nope"; } else { $KommiDa = "japp"; }
                // Besteller herausfinden
                $sql = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$id'");
                $datensatz = mysqli_fetch_array($sql, MYSQL_ASSOC);
                $user = $datensatz['Vorname']." ".$datensatz['Nachname'];
                $user_vn = $datensatz['Vorname'];


                // Tabelle auflisten
                echo "<tr>";
                echo "<td> <a href='?nr=".$Nummer."'>".$Nummer."</a> </td>";
                if ($zugriff == 'all') {
                    echo "<td> <a href='useruebersicht.php?id=".$id."'>".$user."</a> </td>";
                } else {
                    echo "<td> ".$user." </td>"; }

                echo "<td>".$wunsch."</td>";
                if ($Bezahlt == 'true') {
                    echo "<td>am ".$Zahltag." - <a href='?nr=".$Nummer."'>genaueres</a></td>";
                    $BezGes = $BezGes + $KartenAnz;
                } else {
                    echo "<td> <form name='Zahlung_Nr".$Nummer."' action='zahlungregistrieren.php' method='get'>
                        <input type='text' size='8' maxlength='8' name='nr' style='display: none;' value='".$Nummer."'>
                        <input type='submit' value='Zahlung f&uuml;r ".$Nummer." registrieren'> </form> </td> "; }
                echo "<td> ".$KommiDa."</td></tr>";

                //Gesamtzahl aufaddieren
                $Gesamt = $Gesamt + $wunsch;
                $Verkauft = $Verkauft + $KartenAnz;
            }
            echo "</table><br>
            <p>Insgesamt wurde der Wunsch nach ".$Gesamt." Karten ge&auml;u&szlig;ert und ".$Verkauft." Karten verkauft. Davon wurden bislang ".$BezGes." bezahlt.<br><br>
            <i>Hinweis: Die Bestellnummer setzt sich aus dem Datum (Monat, Tag), drei einstelligen Zufallszahlen und der zweistelligen Summe der Zufallszahlen zusammen.</i><br><br><br></p>";
    }

	include ('../back-end/design_gamma.inc.php');
