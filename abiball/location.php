<?php
include('back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('login.php'); exit; }

include('back-end/txt/pages/location.php');

// Content
	
	include ('back-end/design_alpha.inc.php');
	include ('back-end/design_beta.inc.php');
	
	echo ('
	<h1>Die Location</h1>
	'.encode($bausteine[0]).'

	<h2>Geländeplan</h2>
	<img src="/img/gelaende.png" width="100%"><br>

	<iframe src="https://www.google.com/maps/'.$bausteine[1].'" width="100%" height="100%" frameborder="0" style="border:0"></iframe>

	'.encode($bausteine[2]));

	include ('back-end/design_gamma.inc.php');
	