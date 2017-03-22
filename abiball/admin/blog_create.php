<?php
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if (!( ($zugriff == 'all') OR ($zugriff == 'announce') )) { header('location: ../home.php'); exit; }

$prev = false;
if (isset ($_POST['titel'])) {
	// von der Preview zurückkommend
	$prev = true;
	$titel = mysqli_real_escape_string( $db_link, esc ($_POST['titel']));
	$text = mysqli_real_escape_string( $db_link, esc ($_POST['text']));
    $text = str_replace("%nZ%", "\r\n", $text);
	$teaser = mysqli_real_escape_string( $db_link, esc ($_POST['teaser']));
    $teaser = str_replace("%nZ%", "\r\n", $teaser);
} else {
    $prev = false;
    $titel = $text = $teaser = null;
}


// Content
	
	include('../back-end/design_alpha.inc.php');
	echo '<script src="blog_values.js"></script>';
	include ('../back-end/design_beta.inc.php');
	
	echo '<h1>Neuer Blog-Eintrag</h1>';
	 // Admin raussuchen
		$writer = $Vorname." ".$Nachname;
	 // latest edit
		$data = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = ".$datensatz['edit_id']);
		$data = mysqli_fetch_array($data, MYSQL_ASSOC);
		$editor = $data['Vorname']." ".$data['Nachname'];
		
	if ($prev) {
		echo '
		<p><i>'.date("d. M Y - H:i").' - '.$writer.'</i></p>
		<form name="edit" action="blog_prev.php" method="post">
			TITLE: <input type="text" size="32" maxlength="64" name="titel" value="'.$titel.'"> <br>
			TEASER: <br>
			<textarea name="teaser" cols="90" rows="10" style="font-family: Arial,sans-serif; font-size: 14pt;">'.$teaser.'</textarea>
			<br><br>
			TEXT: <br>
			<textarea name="text" cols="90" rows="10" style="font-family: Arial, sans-serif; font-size: 14pt;">'.$text.'</textarea>
			';
	} else {
		echo '
		<p><i>'.date("d. M Y - H:i").' - '.$writer.'</i></p>
		<form name="edit" action="blog_prev.php" method="post">
			TITLE: <input type="text" size="32" maxlength="64" name="titel"> <br>
			TEASER: <br>
			<textarea name="teaser" cols="90" rows="10" style="font-family: Arial, sans-serif; font-size: 14pt;"></textarea>
			<br><br>
			TEXT: <br>
			<textarea name="text" cols="90" rows="10" style="font-family: Arial,sans-serif; font-size: 14pt;"></textarea>
			';
	}
	
	include ('blog_values.inc.php');
		echo '<p> Zum Einfügen im Teaser-Text bitte einfach die Bausteine kopieren. </p>
		<br><br>
		<input type="submit" value="Vorschau anzeigen" style="font-weight: bold; color: green; font-size: 20pt;">
		</form>
	';

	
	
	include ('../back-end/design_gamma.inc.php');
	
