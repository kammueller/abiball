<?php

include('back-end/db_connect.inc.php');
header ('Content-type: text/html; charset=utf-8');
include('back-end/db_escape.inc.php');
include ('back-end/db_encode.inc.php');
include('back-end/txt/pages/verify.php');

if (!( isset($_GET["u"]) && isset ($_GET["v"]) )) {
    echo encode($bausteine[0]);
    exit; }

$id = mysqli_real_escape_string( $db_link, esc($_GET["u"]));
$veri = mysqli_real_escape_string( $db_link, esc($_GET["v"]));

//ID und Hash raussuchen

$sql = "SELECT * FROM `abi_verify` WHERE `user_id` = '$id' LIMIT 1";
$db_erg = mysqli_query($db_link, $sql);
$result = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
$hash = $result['hash'];
$funzt = mysqli_num_rows($db_erg);

if ( ($funzt == 1) && ($hash == $veri) ) {
	//Datensatz updaten
	$sql = "UPDATE `abi_user` SET `verified` = 'true' WHERE `id` = '$id' AND `verified` = 'newMail'";
	$db_erg = mysqli_query($db_link, $sql);
	if($db_erg) {
		//Eintrag in "verify" l�schen
		$sql = "DELETE FROM `abi_verify` WHERE `user_id` = '$id'";
		$db_erg = mysqli_query($db_link, $sql);
		$out = encode($bausteine[2]);
		include('login.php');
	} else {
		echo encode($bausteine[1]); }
} else {
	echo encode($bausteine[0]); }
		
