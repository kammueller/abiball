<?php
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('login.php'); exit; }

include('../back-end/txt/pages/essen.php');

// Content
	
	include ('design_alpha.inc.php');
	include ('design_beta.inc.php');

    echo ('<h1>Das Men&uuml;</h1>');
    echo encode($bausteine[0], true);
	
	include ('design_gamma.inc.php');