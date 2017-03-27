<?php
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; }  if (!( ($zugriff == 'all') OR ($zugriff == 'announce') )) { header('location: ../home.php'); exit; }


// Welcher Eintrag?
$prev = false;
if (isset ($_GET['id'])) {
	$id =  mysqli_real_escape_string( $db_link, esc ($_GET['id']));
	$db_erg = mysqli_query($db_link, "SELECT * FROM `abi_news` WHERE `id` = '$id'");
} else {
	if (isset ($_POST['id'])) {
		// von der Preview zurückkommend
		$prev = true;
		$id =  mysqli_real_escape_string( $db_link, esc( $_POST['id']));
        $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_news` WHERE `id` = '$id'");
	} else {
		// wenn keins gefragt ist, das aktuellste nehmen
		$db_erg = mysqli_query($db_link, "SELECT * FROM `abi_news` LIMIT 1");
        $id = 0;
	}
}
$datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
	


// Content
	
	include('../back-end/design_alpha.inc.php');
	echo '<script src="blog_values.js"></script>';
	include ('../back-end/design_beta.inc.php');

	echo '<h1>Blog-Edit - '.$datensatz['Titel'].'</h1>';
	 // Admin raussuchen
		$data = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = ".$datensatz['user_id']);
		$data = mysqli_fetch_array($data, MYSQLI_ASSOC);
		$writer = $data['Vorname']." ".$data['Nachname'];
	 // latest edit
		$data = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = ".$datensatz['edit_id']);
		$data = mysqli_fetch_array($data, MYSQLI_ASSOC);
		$editor = $data['Vorname']." ".$data['Nachname'];
		
	if ($prev) {
        // Daten ziehen
        $text =  mysqli_real_escape_string( $db_link, esc($_POST['text']));
        $text = str_replace("%nZ%", "\r\n", $text);
        $teaser =  mysqli_real_escape_string( $db_link, esc($_POST['teaser']));
        $teaser = str_replace("%nZ%", "\r\n", $teaser);
		echo '
		<p><i>'.date("d. M Y - H:i", $datensatz['Timestamp']).' - '.$writer.' --- Zuletzt bearbeitet: '.date("d. M Y - H:i", $datensatz['edit_time']).' - '.$editor.'</i></p>
		<form name="edit" action="blog_prev.php" method="post" style="width: 90%;">
			TEASER: <br>
			<textarea name="teaser" rows="10" style="width: 100%; font-family: Arial, sans-serif; font-size: 14pt;">'.$teaser.'</textarea>
			<br><br>
			TEXT: <br>
			<textarea name="text" rows="10" style="width: 100%; font-family: Arial,sans-serif; font-size: 14pt;">'.$text.'</textarea>
			<input type="hidden" name="id" value="'.$id.'">
			';
	} else {
		echo '
		<p><i>'.date("d. M Y - H:i", $datensatz['Timestamp']).' - '.$writer.' --- Zuletzt bearbeitet: '.date("d. M Y - H:i", $datensatz['edit_time']).' - '.$editor.'</i></p>
		<form name="edit" action="blog_prev.php" method="post" style="width: 90%;">
			TEASER: <br>
			<textarea name="teaser" rows="10" style="width: 100%; font-family: Arial, sans-serif; font-size: 14pt;">'.str_replace("%nZ%", "\r\n", $datensatz['Teaser']).'		</textarea>
			<br><br>
			TEXT: <br>
			<textarea name="text" rows="10" style="width: 100%; font-family: Arial, sans-serif; font-size: 14pt;">'.str_replace("%nZ%", "\r\n", $datensatz['Text']).'</textarea>
			<input type="hidden" name="id" value="'.$datensatz['id'].'">
			';
	}
	include ('blog_values.inc.php');
		echo '<p> Zum Einfügen im Teaser-Text bitte einfach die Bausteine kopieren. </p>
		<br><br>
		<input type="submit" value="Vorschau anzeigen" style="font-weight: bold; color: green; font-size: 20pt;">
		</form>
	';

	
	
	include ('../back-end/design_gamma.inc.php');
