<?php
/**
 * FEHLERMELDUNGEN
 * definiert die verschienden Fehler
 */

/** @var STRING $error_db
 * wenn keine Datenbank-Verbindung besteht
 */
$error_db = "Datenbank-Verbindungsfehler!";

/** @var STRING $error_login
 * wenn man nicht (mehr) angemeldet ist
 */
$error_login = "Du musst eingeloggt sein,%nZ% um diese Seite sehen zu können!";

/** @var STRING $error_session
 * falls kein Login erstellt werden kann
 */
$error_session = "Interner Fehler.%nZ% Bitte probiere es in 10 Minuten erneut!";

/** @var STRING $error_cookie
 * falls keine Cookies gesetzt werden können
 */
$error_cookie = "Um diese Website verwenden zu können, müssen Cookies für lmgu-abiball.de und kammueller.eu erlaubt werden!%nZ%%nZ%Mit der Nutzung erklären Sie sich mit der Speicherung einverstanden.";

/** @var STRING $error_pw
 * falsche Benutzer/Passwort-Kombination
 */
$error_pw = "Benutzername und/oder Passwort waren falsch.";

/** @var STRING $error_mail
 * Falls eine Mail nicht versendet werden konnte
 */
$error_mail = "Aus unbeannten Gründen konnte die Mail nicht versendet werden.%nZ%%nZ%Falls möglich, versuche es bitte erneut.";
                