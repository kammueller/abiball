<?php
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('login.php'); exit; }

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_news` WHERE `id` = '$id'");
} else {
    // wenn keins gefragt ist, das aktuellste nehmen
    $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_news` LIMIT 1");
}
$datensatz = mysqli_fetch_array($db_erg, MYSQL_ASSOC);



// Content
	
	include ('design_alpha.inc.php');
	include ('design_beta.inc.php');

    echo '<h1>Neuigkeiten - '.$datensatz['Titel'].'</h1>';
    // Admin raussuchen
    $data = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = ".$datensatz['user_id']);
    $data = mysqli_fetch_array($data, MYSQL_ASSOC);
    $writer = $data['Vorname']." ".$data['Nachname'];
    // Text vorbereiten
    $text_output  = encode(esc($datensatz['Text']), true);


    echo '
            <p><i>'.date("d. M Y - H:i", $datensatz['Timestamp']).' - '.$writer.'</i></p>
            <p>
                '.$text_output.'
            </p>
        ';
    if ($datensatz['edit_id'] != 0) {
        // latest edit
        $data = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = ".$datensatz['edit_id']);
        $data = mysqli_fetch_array($data, MYSQL_ASSOC);
        $editor = $data['Vorname']." ".$data['Nachname'];
        echo '<br>
            <p><i>Zuletzt bearbeitet: '.date("d. M Y - H:i", $datensatz['edit_time']).' - '.$editor.'</i></p>
            ';
    }

    echo '
            <br><br>
            <p><a href="blog.php">Zurück zur Übersicht</a></p>
            <br>
        ';
	
	
	include ('design_gamma.inc.php');
	
?>