<?php
/*
 * LOGIN CREATE
 * erzeugt die Cookies, muss ALS ERSTES in ein weiteres File eingebunden werden
 */
	header ('Content-type: text/html; charset=utf-8');
    include ('db_encode.inc.php');
    include ('txt/errors.php');
    include('txt/pages/cookie.php');
    include ('txt/headerdata.php');
	include('db_connect.inc.php');
    include('db_escape.inc.php');

    $JSding = false;
	if ( isset($_POST["Vorname"]) && isset($_POST["Nachname"]) && isset($_POST["password"]) ){
		$Vorname = mysqli_real_escape_string( $db_link, esc( $_POST["Vorname"]) );
		$Nachname = mysqli_real_escape_string( $db_link, esc( $_POST["Nachname"]) );
		$passwort = mysqli_real_escape_string( $db_link, esc( $_POST["password"]) );
	} else {
		$Vorname = $Nachname = $passwort = null;
	}
	
	$sql = "SELECT * FROM `abi_user` WHERE `Nachname` LIKE '$Nachname' AND `Vorname` LIKE '$Vorname' LIMIT 1";
	$db_erg = mysqli_query($db_link, $sql);
	$datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
	if ($datensatz['id'] == "") { // Kein gültiger Nutzer
        $message = encode($error_pw);
/* DIE FOLGENDE ELSE-IF-SCHLEIFE IST HIER NUR FÜR DAS EIGENE PROJEKT!! */
    } elseif ($datensatz['password'] == "Neu") { // "Neuer" Nutzer
        // include('../admin/file-edit/recaptchalib.php');
        include ('db_captcha.php');
        $publickey = publickey;
        $message = 'Herzlich Willkommen auf dieser Website.<br> Bitte gib hier Deine Mail-Adresse und Dein zukünftiges Passwort an:<br>
                    <script src="/eintragen.js"></script>
	                <link rel="stylesheet" type="text/css" href="/eintragen.css">
                    <form name="Anmeldung" action="/eintragen.php" method="post"  onsubmit="return chkPass()">
                        <input type="hidden" size="32" maxlength="32" name="Vorname" value="'.$Vorname.'"><br>
                        <input type="hidden" size="32" maxlength="32" name="Nachname" value="'.$Nachname.'"><br>

                        E-Mail-Adresse:<br> <input type="text" size="32" maxlength="64" name="mail"><br>
                        <div class="smallError" id="mailA"><p>Bitte g&uuml;ltige Mail-Adresse eingeben!</p>
                        <p style="font-size: 10pt">(gültige Zeichen sind Klein-&Großbuchstaben ohne Umlaute sowie - _ . und natürlich @. Benutzen Sie ggf. bitte Punycode)</p></div>

                        Passwort: <span style="font-style: italic; font-size: 12pt;">Mindestens 8 Zeichen, 1 Gro&szlig;buchstabe, 1 Kleinbuchstabe, 1 Ziffer</span><br>
                        <input type="password" size="32" maxlength="64" name="passwort"><br>
                        <p class="smallError" id="eins">Bitte Passwort eingeben!</p>
                        <p class="smallError" id="zwei">Das Passwort ist zu kurz.</p>
                        <p class="smallError" id="drei">Das Passwort muss eine Zahl enthalten!</p>
                        <p class="smallError" id="vier">Das Passwort muss Gro&szlig;- und Kleinbuchstaben enthalten!</p>

                        Passwort wiederholen:<br> <input type="password" size="32" maxlength="64" name="passwort2"><br>
                        <p class="smallError" id="fuenf">Bitte das Passwort korrekt wiederholen!</p><br>
						';
					// Fortsetzung in landing.php
/* ENDE */
    } elseif ( password_verify($passwort, $datensatz['password']) ) { // gültiger Login
		switch ($datensatz['verified']) {
			case 'false':
				$message = encode($bausteine[0]);
				break;
			case 'mail':
				$message = encode($bausteine[1]);
				break;
			case 'geblockt':
				$message = encode($bausteine[2]);
				break;
			case 'newMail':
				$message = encode($bausteine[3]);
				break;
			case 'true':
				$message = "Hallo ".$datensatz['Vorname']."!<br>
				".encode($bausteine[4]);
                $JSding = true;
				
				// COOKIES SETZEN	
				$value = md5($Vorname);
				$session_id = uniqid().rand(999,9999999);
				$user_id = $datensatz['id'];
				$ablaufen = time()+600;
				setcookie("US", $value, time()+600, "/"); // md5 vom Vornamen
				setcookie("ID", $session_id, time()+600, "/");
				// COOKIE IN DATENBANK VALIDIEREN
				$sql = "INSERT INTO `abi_session` (`id`, `user_id`, `time`) VALUES ('$session_id', '$user_id', '$ablaufen')";
				$db_erg = mysqli_query($db_link, $sql);
				if (!$db_erg) {
                    // falls man noch angemeldet ist ö.ä.
                    $message = "<span style='color: #FF8700; font-weight: bold; font-size: 20pt;'>";
                    if(isset($error_session)){$message .= encode($error_session)."</span>";} else {$message .= "Interner Fehler.<br> Bitte probiere es in 10 Minuten erneut!</span>";}
                }
				// Login-Fails zurücksetzen
				setcookie("failed", "0", time()+300*24*60*60, "/");
				$failing = mysqli_query($db_link, "UPDATE `abi_user` SET `failed` = '0' WHERE `id`=".$datensatz['id']);
					
				// ADMIN?!
				$result = mysqli_query($db_link, "SELECT * FROM `abi_admin` WHERE `user_id` = '$user_id'");
				$menge = mysqli_num_rows($result);
				if ($menge == 1) {
					$adminCheck = mysqli_fetch_array($result, MYSQLI_ASSOC);
					$zugriff = $adminCheck['rechte']; }
		
				break;
			}

	} else { // falsches Passwort
        $message = encode($error_pw);
        // Falscher Login Versuch einspeichern
        $failed = $datensatz['failed'] + 1;
        setcookie("failed", $failed, time()+300*24*60*60, "/");
        $failing = mysqli_query($db_link, "UPDATE `abi_user` SET `failed` = '$failed' WHERE `id`=".$datensatz['id']);
        if ($failed > 3) { include("loginwrong.inc.php"); }
	}
