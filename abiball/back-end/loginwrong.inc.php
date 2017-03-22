<?php
/*
 * BEI FALSCHEN LOGIN
 * blockt den User
 */
 
if (!isset($failed)) { exit; } 

if ($failed > 3) {
		$weg = $datensatz['id'];
		$begr = "4x falsches Passwort";
	// Ist die Begr�ndung vorhanden?
		$sql = "SELECT * FROM `abi_user` WHERE `id` = '$weg' LIMIT 1";
		$db_erg = mysqli_query($db_link, $sql);
		$result = mysqli_fetch_array($db_erg, MYSQL_ASSOC);	
		$MailE = $result['Mail'];
		$VornameE = $result['Vorname'];
		$NachnameE = $result['Nachname'];
		
	// Ist der User schon geblockt?
	if ( $result['verified'] == "geblockt" ) {
		$error = "Der Benutzer wurde bereits geblockt.";
	} else {
		
		// Blockieren in der Datenbank	
		$sql1 = mysqli_query($db_link, "UPDATE `abi_user` SET `verified` = 'geblockt' WHERE `id` = '$weg'");
		$db_erg1 = mysqli_query($db_link, $sql1);
		// Begr�ndung speichern
		$date = date("Y-m-d");
		$sql = mysqli_query($db_link, "INSERT INTO `abi_blocked` (`user_id`, `admin_id`, `Grund`, `datum`) VALUES ('$weg', '0', '$begr', '$date' )");
		$db_erg = mysqli_query($db_link, $sql);
		
		
		
	// Nachricht senden
		$empfaenger = utf8_decode($VornameE." ".$NachnameE)." <".$MailE.">";
		//echo $empfaenger;
		

		// Die Nachricht
		$nachricht = '
		<html>
		<head>
		  <title>Best&auml;tigung des Accounts</title>
		</head>
		<body>
		  Hallo '.$VornameE.',<br><br>
		  Da du dich mehrfach mit dem falschen Passwort angemeldet hast, wurde dein Account aus Sicherheitsgr&uuml;nden gesperrt<br>
		  Bitte melde dich bei uns, um ihn wieder freischalten zu lassen.<br><br>
		  Dein Abiball-Team<br><br>
		  Von Dir angegebene Daten:<br>
		  Name: '.$VornameE.' '.$NachnameE.' <br>
		  E-Mail: '.$MailE.' <br>
		</body>
		</html>';

		//Infos
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$header .= 'From: Abiball 2015 LMGU <noreply@lmgu-abiball.de>' . "\r\n" .
			'Reply-To: Abiball 2015 LMGU <webmaster@lmgu-abiball.de>' . "\r\n" .
			'Bcc: Admin <info@kammueller.eu>' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
			
			

		// Send
		mail($empfaenger, 'Dein Account wurde gesperrt', $nachricht, $header);
	}
}

