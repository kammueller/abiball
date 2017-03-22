<?php
// Test-Cookie
setcookie("failed", "0", time()+100*24*60*60, "/");


include('back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) {
    header('Location: login.php'); exit;
}
if ($loggedIn == "speak Friend and Enter") {
	header('Location: home.php');
} else {
	header('Location: login.php'); }
