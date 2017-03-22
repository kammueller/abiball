<?php
include('back-end/db_connect.inc.php');
header ('Content-type: text/html; charset=utf-8');
include('back-end/db_escape.inc.php');
include('back-end/db_encode.inc.php');
include('back-end/txt/headerdata.php');
include('back-end/txt/pages/verify.php');

if (!( isset($_GET["u"]) && isset ($_GET["v"]) )) {
	echo encode($bausteine[0]); exit; }

$id = mysqli_real_escape_string( $db_link, esc($_GET["u"]) );
$veri = mysqli_real_escape_string( $db_link, esc($_GET["v"]) );

//ID und Hash raussuchen
$sql = "SELECT * FROM `abi_verify` WHERE `user_id` = '$id' LIMIT 1";
$db_erg = mysqli_query($db_link, $sql);
$result = mysqli_fetch_array($db_erg, MYSQL_ASSOC);
$hash = $result['hash'];
$funzt = mysqli_num_rows($db_erg);

if ( ($funzt == 1) && ($hash == $veri) ) {
	//Datensatz updaten
	$sql = "UPDATE `abi_user` SET `verified` = 'mail' WHERE `id` = '$id'";
	$db_erg = mysqli_query($db_link, $sql);
	if($db_erg) {
		//Eintrag in "verify" l�schen
		$sql = "DELETE FROM `abi_verify` WHERE `user_id` = '$id'";
		$db_erg = mysqli_query($db_link, $sql);
		$out = encode($bausteine[3]);
	} else {
		$message =  encode($bausteine[1]); }
} else {
	$message = encode($bausteine[0]); }
	
echo ('
	<!doctype html>
	<html>
	<head>
		
		<title>'.html_title.'</title>
		<link rel="stylesheet" type="text/css" href="/back-end/fonts/fonts.css">
		<link rel="stylesheet" type="text/css" href="/login.css">
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
		
		<!-- JQuery -->
		<script async src="/back-end/jquery.js"></script>
		<!-- Auf Aufl�sung �berpr�fen, DIVS positionieren, �nderungen �berwachen -->
		<script src="/verify.js"></script>
		
	</head>
	<body onload="resize();  loading();">
		<!-- <script type="text/javascript">
		/* �berwachung von Internet Explorer initialisieren */
		if (!window.Weite && document.body && document.body.offsetWidth) {
		  window.onresize = neuAufbau();
		  Weite = Fensterweite();
		  Hoehe = Fensterhoehe();
		}
		</script> -->

		<div id="bg"><img id="backgroundimage" src="/img/login.jpg"></div>
		
		<div id="header">
			<span id="header_title">'.header.'</span>
			<hr id="header_line">
			<span id="header_sub">'.sub_head.'</span>
		</div>');
	
		if ( isset($message) ) { echo ('
		<div class="error" id="message">
			'.$message.'
		</div>'); }
		if ( isset($out) ) { echo ('
		<div class="out" id="message">
			'.$out.'
		</div>'); }

		echo ('
		
	</body>
	</html> ');

		
