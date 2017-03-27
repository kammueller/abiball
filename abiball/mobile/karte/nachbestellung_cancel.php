<?php
/*
 * NACHBESTELLUNG CANCEL
 * l�scht die Reservierung der Karten
 */
include('../../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }

 $sql = "SELECT * FROM `abi_0_kartenfreischalt` WHERE `timestamp` < ".time()." AND `uebrig` > 0 LIMIT 1;";
	$resAr = mysqli_query($db_link, $sql);
	$res = mysqli_fetch_array($resAr, MYSQLI_ASSOC);
		$resAlt = $res['reserviert'];
		$resNeu = $resAlt + 2;
		if ($resNeu > $res['uebrig'])
			{$eineKarte = 1; } else { $eineKarte = 2; }
	$resNeu = $resAlt - $eineKarte;
	$verfuegbar = $res['uebrig'];
	$time = $res['timestamp'];
	$sql = "UPDATE `abi_0_kartenfreischalt` SET `reserviert` = ".$resNeu." WHERE `timestamp` = ".$time.";";
	$result = mysqli_query($db_link, $sql);
	$sql = "UPDATE `abi_user` SET `reservierend` = 'false' WHERE `id` = '$user_id'";
	mysqli_query($db_link, $sql);
	$gueltig1 = mysqli_query($db_link, "DELETE FROM `abi_reservierung` WHERE `user_id` = '$user_id'");

 header('location: index.php');		
		
