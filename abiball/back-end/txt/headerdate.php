<?php
/**
 * HEADER-DATA
 * der Title-Text sowie der im Bildschirm angezeigte
 */

 // Die Folgenden Daten werden NICHT encoded!!
define("html_title", "Huhu :D"); // Der HTML-Title

define("header", "Test"); // erste Zeile

define("sub_head", "Nummer 99"); // zweite Zeile

 // ANSPRECHPARTNER:
/** @var STRING $admin_vor
 * Vorname des Admins
 */
$admin_vor  = "Eins";
/** @var STRING $admin_nach
 * Nachname des Admins
 */
$admin_nach = "Zwei";
/** @var STRING $admin_mail
 * Mailadresse des Admins
 */
define("admin_mail", "test@kammueller.eu");

/** @var STRING $admin_post
 * Adresse des Admins (im Real-life) ;D
 */
$admin_post = "Straße %nZ%
                Ort";

/* webadress - Die Ãœberadresse ( http://[...].de) */
define("webadress", "http://test.kammueller.eu/abiball_frame");               