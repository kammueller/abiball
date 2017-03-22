<?php
// Versendet das PDF im Anhang

header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }

include ("../back-end/txt/mail.php");

// Datenbank
	$sql = "SELECT * FROM `abi_user` WHERE `id` = '$user_id' LIMIT 1";
	$db_erg = mysqli_query($db_link, $sql);
	$result = mysqli_fetch_array($db_erg, MYSQL_ASSOC);	
	$Mail = $result['Mail'];
	$Vorname = $result['Vorname'];
	$Nachname = $result['Nachname'];

// Mail versenden
	require '../PHPMailer/PHPMailerAutoload.php';

	$mail = new PHPMailer;

	$mail->From = admin_mail;
	$mail->FromName = header;
	$mail->addAddress($Mail, utf8_decode($Vorname." ".$Nachname));     // Add a recipient


	$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
	$mail->addAttachment($pdfname.'.pdf', 'Kartenbestellung '.$Nummer.'.pdf');    // Anhang
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'Rechnung Nummer '.$Nummer;
	$mail->Body    =
		'<html>
          <head>
            <meta http-equiv="content-type" content="text/html; charset=utf-8">
          </head>
          <body>
            Hallo '.utf8_decode($Vorname).',<br><br>
            '.utf8_decode(encode($mail_karten_rechnung)).'
            <br><br>
            Von Dir angegebene Daten:<br>
            Name: '.utf8_decode($Vorname.' '.$Nachname).' <br>
            E-Mail: '.utf8_decode($Mail).'
          </body>
		</html>';

// Send
	$funzt = $mail->send();
	if ($funzt){ /* Rechnung vom Server löschen */ unlink($pdfname.".pdf"); }
	else {echo encode($error_mail);}



 