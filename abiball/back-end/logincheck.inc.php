<?php
/*
 * LOGINCHECK
 * neuer Logincheck, setzt die Variable "loggedIn" auf "speak Friend and Enter" - dies muss dann abgefragt werden
 * und (falls ein Admin) "zugriff" auf den entsprechenden Parameter
 * funktioniert �ber Cookies, l�st das Session-Problem (diese werden um 10 Minuten verl�ngert)
 * stellt zudem die Variablen Vorname, Nachname und Mail zur Verf�gung.
 * 
 * SOLL IN JEDER DATEI ALS ERSTES INKLUDIERT WERDEN!
 * if ($loggedIn != "speak Friend and Enter") { $message = "Fehlermeldung"; include ('/login.php'); exit; }
 */
	// ### STANDARD-ZEUG ###
    include ('txt/errors.php'); // Text
    include ('txt/headerdata.php');
    include ('db_encode.inc.php');
    include('db_connect.inc.php'); // Datenbank-Verbindung
    include('db_escape.inc.php');  // Escape-Funktion
	header ('Content-type: text/html; charset=utf-8'); // Header setzen
	
	
	// ### VERALTETE SESSIONS LOESCHEN ###
		$sql = "DELETE FROM `abi_session` WHERE `time` < ".time();
		$db_erg = mysqli_query($db_link, $sql); // veraltetete Sessions löschen
	
	
	// ### USER-LOGIN-PROZESS ###
	// USER ID heraussuchen, Gültigkeit überprüfen
	if (isset($_COOKIE["ID"])) { // falls kein Cookie gesetzt, wird dies übersprungen
		$session_id = $_COOKIE["ID"];
		$db_erg = mysqli_query($db_link, "SELECT * FROM `abi_session` WHERE `id` = '$session_id'");
		$sessionCheck = mysqli_fetch_array($db_erg, MYSQL_ASSOC);
		$user_id = $sessionCheck['user_id'];
		// Vorname überprüfen
		$db_erg = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$user_id'");
		$logInCheck = mysqli_fetch_array($db_erg, MYSQL_ASSOC);
		$Vorname = $logInCheck['Vorname'];
		$Nachname = $logInCheck['Nachname'];
		$Mail = $logInCheck['Mail'];
		$value = md5($Vorname);
		if (!isset($_COOKIE["US"])) { // falls das Cookie fehlt
			$_COOKIE["US"] = "dies ist kein Wert"; }
		if ( $value == $_COOKIE["US"] ) {
			if ($logInCheck['verified'] != 'true') { $message = "Du wurdest geblockt!"; include ('../login.php'); exit; }
            /** @var STRING $loggedIn
             * Setzt den Status auf angemeldet*/
            $loggedIn = "speak Friend and Enter"; // Zugriff erlauben
			setcookie("US", $value, time()+600, "/"); // MD5 verl�ngern
			$session_id = uniqid().rand(999,9999999);
			setcookie("ID", $session_id, time()+600, "/"); // ID-Cookie verl�ngern
			$ablauf = time() + 600;
			$sql = "UPDATE `abi_session` SET `time` = '$ablauf', `id` = '$session_id' WHERE `user_id` = '$user_id';";
			$db_erg = mysqli_query($db_link, $sql); // Session verl�ngern
			
			// ADMIN?!
			$zugriff = null;
			$result = mysqli_query($db_link, "SELECT * FROM `abi_admin` WHERE `user_id` = '$user_id'");
			$menge = mysqli_num_rows($result);
			if ($menge == 1) {
				$adminCheck = mysqli_fetch_array($result, MYSQL_ASSOC);
				$zugriff = $adminCheck['rechte']; }
		}


    }
	
	
	// ### VERALTETE RESERVIERUNGEN L�SCHEN ###
		$gueltig1 = mysqli_query($db_link, "SELECT * FROM `abi_reservierung`;");
		while ($gueltig2 = mysqli_fetch_array($gueltig1, MYSQL_ASSOC)) {
			if ( $gueltig2['ablauf'] < time() ) {
			// Wenn das Ding abgelaufen is, wird gel�scht (ganz unten aber erst)
				$besteller = $gueltig2['user_id'];
				$schub = $gueltig2['bestellung'];
			// die Reservierungsanzahl runtersetzen	
				$sql = "SELECT * FROM `abi_0_kartenfreischalt` WHERE `timestamp` = ".$schub.";";
				$resAr = mysqli_query($db_link, $sql);
				$res = mysqli_fetch_array($resAr, MYSQL_ASSOC);
				$resAlt = $res['reserviert'];
				$resNeu = $resAlt - 2;
				$sql = "UPDATE `abi_0_kartenfreischalt` SET `reserviert` = ".$resNeu." WHERE `timestamp` = ".$schub.";";
				$result = mysqli_query($db_link, $sql);
			// User auf reservierend = false setzen
				$sql = "UPDATE `abi_user` SET `reservierend` = 'false' WHERE `id` = '$besteller';";
				mysqli_query($db_link, $sql);
			}
		}
		// alle veralteten Reservierungen loeschen
		$loeschen = mysqli_query($db_link, "DELETE FROM `abi_reservierung` WHERE `ablauf` < ".time().";");


