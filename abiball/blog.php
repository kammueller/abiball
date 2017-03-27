<?php
include('back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('login.php'); exit; }

include('back-end/txt/pages/blog.php');
$db_erg = mysqli_query($db_link, "SELECT * FROM `abi_news` ORDER BY `edit_time` DESC");

// Content
	
	include ('back-end/design_alpha.inc.php');
	include ('back-end/design_beta.inc.php');
	
	echo '<h1>Neuigkeiten</h1>
    '.encode($bausteine[0]).'
	';
	
	while ( $datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC) ) {
	// Admin raussuchen
		$data = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = ".$datensatz['user_id']);
		$data = mysqli_fetch_array($data, MYSQLI_ASSOC);
		$writer = $data['Vorname']." ".$data['Nachname'];
	// Text vorbereiten
		$Text  = encode(esc($datensatz['Teaser']));
	echo '
		
		<br><br>
		<h2>'.$datensatz['Titel'].'</h2>
		<p><i>'.date("d. M Y - H:i", $datensatz['Timestamp']).' - '.$writer.'</i></p>
		<p>
			'.$Text.'
			<a href="blog_detail.php?id='.$datensatz['id'].'">[ weiter lesen ]</a> <br>
		</p>
	';
	}
	
	include ('back-end/design_gamma.inc.php');
	
