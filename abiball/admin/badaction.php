<?php
/*
 * BADACTION
 * Sicherheitsformular für alle schwerwiegenden Eingriffe:
 *  -> User löschen
 *  -> Admin-Rechte entziehen
 *  -> Zahlungen löschen
 *  -> Kartenbestellung löschen
 * (benötigt validen Input, leitet sonst weiter)
 *
 * BENÖTIGT höchste Admin-Rechte
 */

include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../home.php'); exit; }

include('../back-end/txt/mail.php');

// Zu erledigende Arbeit
if(!(isset($_POST["id"]) && isset($_POST["action"]))) {
    $error = "nicht genügend Daten angegeben!";
    include('index.inc.php'); exit;
}
	// Daten Sammeln
	$del = mysqli_real_escape_string( $db_link, esc($_POST["id"] ) );
	$wastun = mysqli_real_escape_string( $db_link, esc($_POST["action"] ) );
    // include ("../back-end/txt/headerdata.php");  $absender = header.' <'.admin_mail.'>'; /*@TODO unschön gelöst*/

	 switch ( $wastun ) {
         case 'delete': {
			// Einen User-Account löschen
				
			/* BERECHTIGUNGEN */ 
			
				// Daten sammeln
				$sql = "SELECT * FROM `abi_user` WHERE `id` = '$del' LIMIT 1";
				$db_erg = mysqli_query($db_link, $sql);
				$result = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
				$MailE = $result['Mail'];
				$VornameE = $result['Vorname'];
				$NachnameE = $result['Nachname'];
				// ist der Account schon gelöscht?
				if ($result['id'] == "") { $error = "Der User wurde schon gel&ouml;scht."; include ('index.inc.php'); exit; }
				// nochmals überprüfen: Darf der Account gelöscht werden?
					//Ist der Account geblockt?
					if ( $result['verified'] != 'geblockt' )
					{ $error = "Es d&uuml;rfen nur geblockte Accounts gelöscht werden! ";
                        include('index.inc.php'); exit; }
					//Ist der Account schon 7 Tage blockiert?
					$sql = "SELECT * FROM `abi_blocked` WHERE `user_id` = '$del'";
					$db_erg = mysqli_query($db_link, $sql);
					$result = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
					$blockdate = strtotime( $result['datum'] );
					$early_del = $blockdate + 60*60*24*7;  // frühestes Blockierdatum
					if ( mktime() < $early_del ) {
                        $error = "Nutzer darf noch nicht gelöscht werden!";
                        include('index.inc.php');
						exit;
					}
				
				
			/* VERKNÜPFTE DATEN LÖSCHEN */
				
				// Blockbericht löschen
				$sql = "DELETE FROM `abi_blocked` WHERE `user_id` = '$del'";
				$db_erg = mysqli_query($db_link, $sql);
				
				// User löschen
				$sql = "DELETE FROM `abi_user` WHERE `id` = '$del'";
				$db_erg = mysqli_query($db_link, $sql);
				
				// Kartenbestellung löschen
					$sql = "DELETE FROM `abi_karten` WHERE `user_id` = '$id'";
					$db_erg = mysqli_query($db_link, $sql);
					$sql = "DELETE FROM `abi_bestellung` WHERE `user_id` = '$id'";
					$db_erg = mysqli_query($db_link, $sql);
				
			
			/* BENACHRICHTIGEN */ 
			
				$empfaenger = utf8_decode($VornameE." ".$NachnameE)." <".$MailE.">";

				// Die Nachricht
				$nachricht = '
				<html>
				<head>
				  <title>L&ouml;schung des Accounts</title>
				  <meta http-equiv="content-type" content="text/html; charset=utf-8">
				</head>
				<body>
				  Hallo '.$VornameE.',<br><br>
				  '.encode($mail_accountdelete).'
				</body>';

				//Infos
				$header  = 'MIME-Version: 1.0' . "\r\n";
				$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $header .= 'From: '.$absender . "\r\n" .
                    'Bcc: '.admin_mail;

				// Send
				$funzt = mail($empfaenger, 'Dein Account wurde =?UTF-8?Q?gel=c3=b6scht?=', $nachricht, $header);

				// Rückmeldung geben
				if ($funzt){$success = "Mail wurde versendet<br>";}
				else {$error = "Die E-Mail konnte nicht versendet werden. Bitte schau nach, was sonst noch nicht geklappt hat!";}
				include ('index.inc.php');
				
				break;
		}
		
		case 'noadmin': {
			// Einem User die Admin-Rechte entziehen
			
			
			// Will man sich gerade selber kicken?
				if ($del == $user_id) {
					$error = "<p>Du kannst dich nicht selber kicken!<br><br>
					<a href='index.php'>Zur&uuml;ck</a></p>";
					include ('index.inc.php');
					exit;
				}
				
			// Datenbankenarbeit
				// Daten sammeln
				$sql = "SELECT * FROM `abi_user` WHERE `id` = '$del' LIMIT 1";
				$db_erg = mysqli_query($db_link, $sql);
				$result = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
				$MailE = $result['Mail'];
				$VornameE = $result['Vorname'];
				$NachnameE = $result['Nachname'];
			// is der überhaupt noch Admin?
				$nochAdmin = mysqli_query($db_link, "SELECT * FROM `abi_admin` WHERE `user_id` = '$del'");
				$check = mysqli_fetch_array($nochAdmin, MYSQLI_ASSOC);
				if ($check['user_id'] == "") { $error = "Dieser Vorgang wurde bereits ausgeführt."; include ('index.inc.php'); exit; }
				
			// Admin-Eintrag löschen
				$sql = "DELETE FROM `abi_admin` WHERE `user_id` = '$del'";
				$db_erg = mysqli_query($db_link, $sql);
				$db_erg = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
			
			// Nachricht senden
				$empfaenger = utf8_decode($VornameE." ".$NachnameE)." <".$MailE.">";

				// Die Nachricht
				$nachricht = '
				<html>
				<head>
				  <title>L&ouml;schung des Accounts</title>
				  <meta http-equiv="content-type" content="text/html; charset=utf-8">
				</head>
				<body>
				  Hallo '.$VornameE.',<br><br>
				  '.encode($mail_noadmin).'<br><br>
				  Von Dir angegebene Daten:<br>
				  Name: '.$VornameE.' '.$NachnameE.' <br>
				  E-Mail: '.$MailE.' <br>
				</body>';

				//Infos
				$header  = 'MIME-Version: 1.0' . "\r\n";
				$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $header .= 'From: '.$absender . "\r\n" .
                    'Bcc: '.admin_mail;

				// Send
				$funzt = mail($empfaenger, 'Dein Account wurde =?UTF-8?Q?eingeschr=c3=a4nkt?=', $nachricht, $header);

				// Rückmeldung geben
				if ($funzt){$success =  "Mail wurde versendet";}
				else {$error =  "Es ist zu einem internen Fehler gekommen. Bitte wende Dich an den Webmaster und gib die ID ".$del." an. Danke.";}
				include ('index.inc.php');
				break;
		}
		
		case 'revidiereZahlung' : {
            if(!(isset($_POST["nr"]) && isset($_POST["begruendung"]))) {
                $error = "nicht genügend Daten angegeben!";
                include('index.inc.php'); exit;
            }
				// Daten Sammeln
				$Nummer = mysqli_real_escape_string( $db_link, esc($_POST["nr"]));
				$begr = mysqli_real_escape_string( $db_link, esc($_POST['begruendung']));
				
			// Ist die Begründung vorhanden?
			if ($begr == "") {
				header ('location: zahlungrevidieren.php?nr='.$Nummer); exit;
			} else {
				
				$sql = mysqli_query($db_link, "SELECT * FROM `abi_bestellung` WHERE `BestellNr` = '$Nummer'");
				$datensatz = mysqli_fetch_array($sql, MYSQLI_ASSOC);
				$id = $datensatz['user_id'];
				$sql = "SELECT * FROM `abi_user` WHERE `id` = '$id' LIMIT 1";
				$db_erg = mysqli_query($db_link, $sql);
				$result = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
				$MailE = $result['Mail'];
				$VornameE = $result['Vorname'];
				$NachnameE = $result['Nachname'];
				
			// Wurde das bereits ausgeführt?
				if ($datensatz['Bezahlt'] == "false") { $error = "Dieser Vorgang wurde bereits ausgeführt."; include ('index.inc.php'); exit; }
				
			// Ausführen in Datenbank
				$sql1 = mysqli_query($db_link, "UPDATE `abi_bestellung` SET `Bezahlt` = 'false', `BezAm` = NULL, `admin_id` = NULL, `BezArt` = NULL, `BezKom` = NULL WHERE `BestellNr` = '$Nummer';");
				$db_erg1 = mysqli_query($db_link, $sql1);
					
			// Nachricht senden
				$empfaenger = utf8_decode($VornameE." ".$NachnameE)." <".$MailE.">";
				

				// Die Nachricht
                $such = array("%RechnungsNummer%", "%Begründung%");
                $ersetz = array($Nummer, $begr);
				$nachricht = '
				<html>
				<head>
				  <title>Zahlung wurde gel&ouml;scht</title>
				  <meta http-equiv="content-type" content="text/html; charset=utf-8">
				</head>
				<body>
				  Hallo '.$VornameE.',<br><br>
				  '.encode(str_ireplace($such, $ersetz, $mail_zahlungweg)).'<br><br>
				  Von Dir angegebene Daten:<br>
				  Name: '.$VornameE.' '.$NachnameE.' <br>
				  E-Mail: '.$MailE.' <br>
				</body>';

				//Infos
				$header  = 'MIME-Version: 1.0' . "\r\n";
				$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $header .= 'From: '.$absender . "\r\n" .
                    'Bcc: '.admin_mail;

				// Send
				$funzt = mail($empfaenger, 'Probelme mit der Bezahlung der Rechnung '.$Nummer , $nachricht, $header);

				if ($funzt){$success = "Mail wurde versendet.";}
				else {$error = "Die E-Mail konnte nicht versendet werden.<br> Bitte schau nach, ob die Zahlung revidiert wurde und benachrichtige den User ggf. pers&ouml;nlich!";}
				include ('index.inc.php'); 
			}
				break;
        }
				
		case 'bestellungWeg' : {
			// Eine Kartenbestellung l�schen
			
				$Nummer = mysqli_real_escape_string( $db_link, esc($_POST["nr"]));		
			// Datenbankenarbeit
				// Daten sammeln
				$sql = "SELECT * FROM `abi_bestellung` WHERE `BestellNr` = '$Nummer' LIMIT 1";
				$db_erg = mysqli_query($db_link, $sql);
				$datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
				$id = $datensatz["user_id"];
				$sql = "SELECT * FROM `abi_user` WHERE `id` = '$id' LIMIT 1";
				$db_erg = mysqli_query($db_link, $sql);
				$result = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
				$MailE = $result['Mail'];
				$VornameE = $result['Vorname'];
				$NachnameE = $result['Nachname'];
			
			// in DB l�schen
				$k1 = $datensatz['karte1'];
				$karte = 0;
					if ($k1 != 0) { // Vorname und Nachname ziehen
						$result = mysqli_query($db_link, "DELETE FROM `abi_karten` WHERE `id` = '$k1';");
						$karte = 1; }
				$k2 = $datensatz['karte2'];
					if ($k2 != 0) { // Vorname und Nachname ziehen
						$result = mysqli_query($db_link, "DELETE FROM `abi_karten` WHERE `id` = '$k2';");
						$karte  = 2;; }
				$k3 = $datensatz['karte3'];
					if ($k3 != 0) { // Vorname und Nachname ziehen
						$result = mysqli_query($db_link, "DELETE FROM `abi_karten` WHERE `id` = '$k3';");
						$karte = 3; }
				$k4 = $datensatz['karte4'];
					if ($k4 != 0) { // Vorname und Nachname ziehen
						$result = mysqli_query($db_link, "DELETE FROM `abi_karten` WHERE `id` = '$k4';");
						$karte = 4; }
				$sql = "DELETE FROM `abi_bestellung` WHERE `BestellNr` = '$Nummer'";
				$db_erg = mysqli_query($db_link, $sql);
			
			// Nachricht senden
				$empfaenger = utf8_decode($VornameE." ".$NachnameE)." <".$MailE.">";

				// Die Nachricht
                $such = array("%RechnungsNummer%", "%KartenZahl%");
                $ersetz = array($Nummer, $karte);
				$nachricht = '
				<html>
				<head>
				  <title>L&ouml;schung deiner Bestellung</title>
				   <meta http-equiv="content-type" content="text/html; charset=utf-8">
				</head>
				<body>
				  Hallo '.$VornameE.',<br><br>
				  '.encode(str_ireplace($such, $ersetz, $mail_kartenweg)).'<br><br>
				  Dein Abiball-Team<br><br>
				  Von Dir angegebene Daten:<br>
				  Name: '.$VornameE.' '.$NachnameE.' <br>
				  E-Mail: '.$MailE.' <br>
				</body>';

				//Infos
				$header  = 'MIME-Version: 1.0' . "\r\n";
				$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $header .= 'From: '.$absender . "\r\n" .
                    'Bcc: '.admin_mail;
				// Send
				$funzt = mail($empfaenger, 'Deine Bestellung wurde =?UTF-8?Q?gel=c3=b6scht?=', $nachricht, $header);

				// Rückmeldung geben
				if ($funzt){$success = "Mail wurde versendet<br>";}
				else {$error = "Die Mail konnte nicht versendet werden.<br> Bitte schau nach, ob bereits ein anderer Admin die Bestellung gel&ouml;scht hat und bernachrichtige ggf. den User direkt!";}
				include ('index.inc.php');
				break;
        }
				
		default: {
			// Nichts (gültiges) angegeben
			header('Location: index.php'); }
			
	}

	
	
	
