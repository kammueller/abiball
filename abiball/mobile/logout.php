<?php
/*
 * LOGOUT
 * löscht die gesetzten Cookies
 */
include ('../back-end/logincheck.inc.php');
include('../back-end/txt/pages/cookie.php');

setcookie("US", "delete", time()-600, "/");
setcookie("ID", "delete", time()-600, "/");
if (isset($user_id)) {
    $sql = "DELETE FROM `abi_session` WHERE `user_id` = '$user_id'";
    $db_erg = mysqli_query($db_link, $sql);
}

// Bildschirmausgabe
$loggedIn = 0;
$out = encode($bausteine[5]);
include('login.php');
