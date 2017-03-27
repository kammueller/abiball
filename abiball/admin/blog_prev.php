<?php
/**
 * BLOG PREVIEW
 * zeigt, wie der Artikel aussehen würde
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; }  if (!( ($zugriff == 'all') OR ($zugriff == 'announce') )) { header('location: ../home.php'); exit; }

if (isset ($_POST['id'])) {
// Edit eines existierenden
	$id =   mysqli_real_escape_string( $db_link, esc($_POST['id'] ) );
	$db_erg = mysqli_query($db_link, "SELECT * FROM `abi_news` WHERE `id` = '$id'");
	$datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
	$text_neu =   mysqli_real_escape_string( $db_link, esc($_POST['text'] ) );
	$teaser_neu =  mysqli_real_escape_string( $db_link, esc($_POST['teaser'] ) );

	include('../back-end/design_alpha.inc.php');
	include ('../back-end/design_beta.inc.php');
	
	
	 // Admin raussuchen
		$data = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = ".$datensatz['user_id']);
		$data = mysqli_fetch_array($data, MYSQLI_ASSOC);
		$writer = $data['Vorname']." ".$data['Nachname'];
		
		
	// Teaser vorschau
	echo '<h1>Neuigkeiten</h1>
	<p> Herzlich Willkommen bei unserem Blog!<br>
	Dies hier ist natürlich nur eine Vorschau.</p>
	';
		// Text vorbereiten
		$text_output  = encode($teaser_neu);
	echo '
		<br><br>
		<h2>'.$datensatz['Titel'].'</h2>
		<p><i>'.date("d. M Y - H:i", $datensatz['Timestamp']).' - '.$writer.'</i></p>
		<p>
			'.$text_output.'
			<a href="/blog_detail.php?id='.$datensatz['id'].'">[ weiter lesen ]</a> <br>
		</p>
		
		<br><br><br>
		<hr>
	';
	
	// Text Vorschau
	echo '<h1>Neuigkeiten - '.$datensatz['Titel'].'</h1>';
		// Text vorbereiten
		$text_output  = encode($text_neu);
		
		
	echo '
		<p><i>'.date("d. M Y - H:i", $datensatz['Timestamp']).' - '.$writer.'</i></p>
		<p>
			'.$text_output.'
		</p>
	';
		// latest edit
		echo '<br>
		<p><i>Zuletzt bearbeitet: '.date("d. M Y - H:i").' - '.$Vorname.' '.$Nachname.'</i></p>
		';
	
	echo '
		<br><br>
		<p><a href="blog.php">Zurück zur Übersicht</a></p>
		<br>
		
		<br><br><br>
		<hr>';
		
	// ABSENDEN oder ZURÜCK?
	echo '
		<table width="90%"><tr>
			<td>
				<form name="back" action="blog_edit.php" method="post">
					<input type="hidden" name="id" value="'.$id.'">
					<input type="hidden" name="text" value="'.$text_neu.'">
					<input type="hidden" name="teaser" value="'.$teaser_neu.'">
					<input type="submit" value="Zurück zur Bearbeitung" style="font-weight: bold; color: red; font-size: 16pt;">
				</form>
			</td>			
			<td style="text-align: right">
				<form name="confirm" action="blog.php" method="post">
					<input type="hidden" name="id" value="'.$id.'">
					<input type="hidden" name="text" value="'.$text_neu.'">
					<input type="hidden" name="teaser" value="'.$teaser_neu.'">
					<input type="submit" value="Absenden" style="font-weight: bold; color: green; font-size: 16pt;">
				</form>
			</td>
		</tr></table>
	';
	
	
	include ('../back-end/design_gamma.inc.php');

} else {
// neuen Artikel anzeigen
	$titel =  mysqli_real_escape_string( $db_link, esc($_POST['titel']));
	$text =  mysqli_real_escape_string( $db_link, esc($_POST['text']));
	$teaser =  mysqli_real_escape_string( $db_link, esc($_POST['teaser']));
	$writer = $Vorname." ".$Nachname;

	include('../back-end/design_alpha.inc.php');
	include ('../back-end/design_beta.inc.php');
		
		
	// Teaser vorschau
	echo '<h1>Neuigkeiten</h1>
	<p> Herzlich Willkommen bei unserem Blog!<br>
	Dies hier ist natürlich nur eine Vorschau.</p>
	';
		// Text vorbereiten
		$text_output = encode($teaser);
	echo '
		<br><br>
		<h2>'.$titel.'</h2>
		<p><i>'.date("d. M Y - H:i").' - '.$writer.'</i></p>
		<p>
			'.$text_output.'
			<a href="/blog_detail.php?id='.$datensatz['id'].'">[ weiter lesen ]</a> <br>
		</p>
		
		<br><br><br>
		<hr>
	';
	
	// Text Vorschau
	echo '<h1>Neuigkeiten - '.$titel.'</h1>';
		// Text vorbereiten
		$text_output  = encode($text);
		
		
	echo '
		<p><i>'.date("d. M Y - H:i").' - '.$writer.'</i></p>
		<p>
			'.$text_output.'
		</p>
	';
	
	echo '
		<br><br>
		<p><a href="blog.php">Zurück zur Übersicht</a></p>
		<br>
		
		<br><br><br>
		<hr>';
		
	// ABSENDEN oder ZURÜCK?
	echo '
		<table width="90%"><tr>
			<td>
				<form name="back" action="blog_create.php" method="post">
					<input type="hidden" name="titel" value="'.$titel.'">
					<input type="hidden" name="text" value="'.$text.'">
					<input type="hidden" name="teaser" value="'.$teaser.'">
					<input type="submit" value="Zurück zur Bearbeitung" style="font-weight: bold; color: red; font-size: 16pt;">
				</form>
			</td>			
			<td style="text-align: right">
				<form name="confirm" action="blog.php" method="post">
					<input type="hidden" name="titel" value="'.$titel.'">
					<input type="hidden" name="text" value="'.$text.'">
					<input type="hidden" name="teaser" value="'.$teaser.'">
					<input type="submit" value="Absenden" style="font-weight: bold; color: green; font-size: 16pt;">
				</form>
			</td>
		</tr></table>
	';
	
	
	include ('../back-end/design_gamma.inc.php');



}