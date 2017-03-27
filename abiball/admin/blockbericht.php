<?php
/*
 * BLOCKBERICHT
 * Uebersicht aller geblockten User bzw. Detailansicht
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; }  if ($zugriff != 'all') { header('location: ../home.php'); exit; }

// Content
	
	include('../back-end/design_alpha.inc.php');
	include ('../back-end/design_beta.inc.php');
		
// Zu erledigende Arbeit

	if (isset($_GET['id'])) {
        // Wenn nur ein Fall gefragt ist
        $id = mysqli_real_escape_string( $db_link, esc($_GET['id']) );
        // Daten sammeln
            // Grund und Datum herausfinden
            $sql = mysqli_query($db_link, "SELECT * FROM `abi_blocked` WHERE `user_id` = '$id'");
            $datensatz = mysqli_fetch_array($sql, MYSQLI_ASSOC);
            $admin_id = $datensatz['admin_id'];
            $date = $datensatz['datum'];
            $begr = $datensatz['Grund'];
            // Admin herausfinden
            $sql = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$admin_id'");
            $datensatz = mysqli_fetch_array($sql, MYSQLI_ASSOC);
            $admin = $datensatz['Vorname']." ".$datensatz['Nachname'];
            $admin_vn = $datensatz['Vorname'];
            $sql = mysqli_query($db_link, "SELECT * FROM `abi_admin` WHERE `user_id` = '$admin_id'");
            $datensatz = mysqli_fetch_array($sql, MYSQLI_ASSOC);
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
            // User herausfinden
            $sql = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$id'");
            $datensatz = mysqli_fetch_array($sql, MYSQLI_ASSOC);
            $user = $datensatz['Vorname']." ".$datensatz['Nachname'];
            $user_vn = $datensatz['Vorname'];

        // Ausgeben
            echo "<h2>Blockierungs-Protokoll ".$date."-".$id."</h2>
            Der User <a href=useruebersicht.php?id=".$id."><i>".$user."</i></a> mit der ID ".$id." wurde geblockt am <i>".$date."</i>.<br>
            Dabei wurde von dem Administrator <i>".$admin."</i> mit der ID ".$admin_id." die folgende Begr&uuml;ndung angegeben:<br><i>";
            echo $begr."</i><br><br>";
            echo "Der Administrator ist dabei die folgenden Rechte: ".$admin_rights." <br><br>" ;
            echo "<table> <tr>";
            echo "<td><form name='Rehab_ID".$id."' action='rehab.php' method='get'>
                        <input type='text' size='8' maxlength='8' name='id' style='display: none;' value='".$id."'>
                        <input type='submit' value='".$user_vn." wieder freischalten'> </form> </td>";
            echo "<td> <form name='Del_ID".$id."' action='delete.php' method='get'>
                        <input type='text' size='8' maxlength='8' name='id' style='display: none;' value='".$id."'>
                        <input type='submit' value='".$user_vn." endg&uuml;ltig l&ouml;schen'> </form> </td>";
            echo "<td> <form name='Entadmin_ID".$admin_id."' action='noadmin.php' method='get'>
                        <input type='text' size='8' maxlength='8' name='id' style='display: none;' value='".$admin_id."'>
                        <input type='submit' value='".$admin_vn." Adminrechte entziehen'> </form> </td>";
            echo "</tr></table><br>";
	}
    else {
		$db_erg = mysqli_query($db_link, "SELECT * FROM `abi_blocked` ORDER BY `datum`");
        // Alle Auflisten
        echo " <h2>Blockierungs-Protokoll</h2>
		<table border=1>
			<tr><th>Protokoll Nr.</th><th>User</th><th>Von dem Admin</th><th>Begr&uuml;ndung</th><th>Rehabilitieren</th></tr>";
        while ( $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC) ) {
            // Grund und Datum herausfinden
            $admin_id = $datensatz['admin_id'];
            $user_id = $datensatz['user_id'];
            $date = $datensatz['datum'];
            $begr = $datensatz['Grund'];
            // Admin herausfinden
            $sql = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$admin_id'");
            $datensatz = mysqli_fetch_array($sql, MYSQLI_ASSOC);
            $admin = $datensatz['Vorname']." ".$datensatz['Nachname'];
            // User herausfinden
            $sql = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$user_id'");
            $datensatz = mysqli_fetch_array($sql, MYSQLI_ASSOC);
            $user = $datensatz['Vorname']." ".$datensatz['Nachname'];

            // Tabelle auflisten
            echo "<tr>";
            echo "<td> <a href='?id=".$user_id."'>".$date."-".$user_id."</a> </td>";
            echo "<td> <a href='useruebersicht.php?id=".$user_id."'>".$user."</a> </td>";
            echo "<td>".$admin."</td>";
            echo "<td>".$begr."</td>";
            echo "<td>";
            echo "<form name='Rehab_ID".$datensatz['id']."' action='rehab.php' method='get'>
					<input type='text' size='8' maxlength='8' name='id' style='display: none;' value='".$datensatz['id']."'>
					<input type='submit' value='Wieder freischalten'> </form> </td>";
            echo "</tr>"; }
        echo "</table><br>"; }



	echo "<a href='index.php'>Zur&uuml;ck zur Admin-Konsole</a>";
	
	include ('../back-end/design_gamma.inc.php');
	