<?php
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if (!( ($zugriff == 'all') OR ($zugriff == 'announce') )) { header('location: ../home.php'); exit; }

// ### NEUEN BLOG EINTRAGEN ODER LÖSCHEN###
if(isset($_POST["delete"])) {
    $delete = mysqli_real_escape_string( $db_link, esc ($_POST["delete"]) );
    if ($delete == "do it! do it!") {
        // LÖSCHEN
        $id = mysqli_real_escape_string($db_link, esc($_POST["id"]));
        $sql = "DELETE FROM `abi_news` WHERE `id` = '$id';";
        $entry = mysqli_query($db_link, $sql);
        if ($entry) {
            $success = "Eintrag erfolgreich gelöscht!";
        } else {
            $error = "Es ist zu einem internen Fehler gekommen";
        }
    }
} else {
	if (isset($_POST['id'])) {
	// Bestehenden eintrag ändern
		$id = mysqli_real_escape_string( $db_link, esc ($_POST["id"]) );
		$text = mysqli_real_escape_string( $db_link, esc ($_POST['text']) );
		$teaser = mysqli_real_escape_string( $db_link, esc ($_POST['teaser']) );
		$sql = "UPDATE `abi_news` SET `Teaser` = '$teaser', `Text` = '$text', `edit_id` = '$user_id', `edit_time` = '".time()."' WHERE `id` = '$id';";
		$entry = mysqli_query($db_link, $sql);
		if ($entry) {
			$success = "Eintrag erfolgreich bearbeitet!";
		} else {
			$error = "Es ist zu einem internen Fehler gekommen";
		}
	}
	if (isset($_POST['titel'])) {
	// Bestehenden eintrag ändern
		$titel = mysqli_real_escape_string( $db_link, esc ($_POST['titel']) );
		$text = mysqli_real_escape_string( $db_link, esc ($_POST['text']) );
		$teaser = mysqli_real_escape_string( $db_link, esc ($_POST['teaser']) );
		$time = time();
		$sql = "INSERT INTO `abi_news` (`id`, `user_id`, `Titel`, `Teaser`, `Text`, `Timestamp`, `edit_id`, `edit_time`) VALUES (NULL, '$user_id', '$titel', '$teaser', '$text', '$time', '0', '$time');";
		$entry = mysqli_query($db_link, $sql);
		if ($entry) {
			$success = "Eintrag erfolgreich erstellt!";
		} else {
			$error = "Es ist zu einem internen Fehler gekommen";
		}
	}
}



// ### ANSICHT ###

// alle Blogs ziehen
$db_erg = mysqli_query($db_link, "SELECT * FROM `abi_news` ORDER BY `edit_time` DESC");

// Content
	
	include('../back-end/design_alpha.inc.php');
	echo '<link rel="stylesheet" type="text/css" href="message.css">
	<script src="message.js"></script>';
	include ('design_beta.admin.inc.php');
	
	if ( isset($success) ) { echo ('
	<div class="success" id="message">
		'.$success.'
	</div>'); }
	if ( isset($error) ) { echo ('
	<div class="error" id="message">
		'.$error.'
	</div>'); }
	
	
	
	echo '<h1>Blog-Bearbeitung</h1>
	<p>Entweder einen Artikel bearbeiten (siehe Auswahl weiter unten) oder <a href="blog_create.php">einen neuen Blog-Eintrag erstellen</a>
	';
	
	while ( $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC) ) {
	// Admin raussuchen
		$data = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = ".$datensatz['user_id']);
		$data = mysqli_fetch_array($data, MYSQLI_ASSOC);
		$writer = $data['Vorname']." ".$data['Nachname'];
	// latest edit
		$data = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = ".$datensatz['edit_id']);
		$data = mysqli_fetch_array($data, MYSQLI_ASSOC);
		$editor = $data['Vorname']." ".$data['Nachname'];
	// Text vorbereiten
		$Text  = encode(esc($datensatz['Teaser']));
	echo '
		
		<br><br>
		<table><tr><td>
		<h2>'.$datensatz['Titel'].' &nbsp; [ID '.$datensatz['id'].']</h2></td>';
		// Eintrag bearbeiten
		echo '<td> &nbsp; <button style="font-weight: bold; color: green;" onclick="document.location = \'blog_edit.php?id='.$datensatz['id'].'\'">Bearbeiten</button></td>';
		// Eintrag löschen?!
		if ($zugriff == "all") { // Benötigt allmacht
			echo '<td> <form name="delete" action="blog.php" method="post">
					<input type="hidden" name="id" value="'.$datensatz['id'].'">
					<input type="hidden" name="delete" value="do it! do it!">
					<input type="submit" value="Löschen" style="font-weight: bold; color: red;">
				</form> </td>';
		}
		echo '</tr></table>
		<p><i>'.date("d. M Y - H:i", $datensatz['Timestamp']).' - '.$writer.' --- Zuletzt bearbeitet: '.date("d. M Y - H:i", $datensatz['edit_time']).' - '.$editor.'</i></p>
		<p>
			'.$Text.'
			<a href="/blog_detail.php?id='.$datensatz['id'].'">[ weiter lesen ]</a> <br></p> ';			
		
	}
	
	include ('../back-end/design_gamma.inc.php');
	
