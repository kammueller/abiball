<?php
/**
 * Text für das Profil & Folgeseiten
 */

/** @var ARRAY|STRING $bausteine
 * Ein Array mit allen Textbausteinen für das Profil und dessen Folgeseiten
 *
 * 0 => Titel über Datenauflistung
 * 1 => Regelmäßiges Checken der Mailbox (Hinweis)
 * 2 => Logout-Hinweis bei Mail-Änderung
 * 3 => ### MAIL: EINTRAGE-FEHLER ### keine (gültige) Mail-Adresse angegeben
 * 4 => ### MAIL ### Ausgeloggt, bis Mail bestätigt wurde - Hinweis
 */
$bausteine = array();

/** @var ARRAY|STRING $descript
 * Beschreibung der Textbausteine (für Veränderung)
 */
$descript = array();

### ### ###

$descript[0] = "Titel über Datenauflistung";
$bausteine[0] = "Du bist bei uns mit den folgenden Daten registriert:";

$descript[1] = "Regelmäßiges Checken der Mailbox (Hinweis)";
$bausteine[1] = "%k*Bitte beachte, dass du regelmäßig in diese Mailbox schauen solltest!*k%";

$descript[2] = "Logout-Hinweis bei Mail-Änderung";
$bausteine[2] = "%k*Hinweis:*k% Du wirst hiermit abgemeldet und kannst dich erst wieder anmelden, wenn du deine E-Mail-Adresse bestätigt hast!";

$descript[3] = "### MAIL: EINTRAGE-FEHLER ### keine (gültige) Mail-Adresse angegeben";
$bausteine[3] = "Inkorrekte Mailadresse!%nZ% ggf. Punycode verwenden!";

$descript[4] = "### MAIL ### Ausgeloggt, bis Mail bestätigt wurde - Hinweis";
$bausteine[4] = "Aus Sicherheitsgründen wurdest du ausgeloggt, bis du deine neue E-Mail-Adresse bestätigt hast.";

$descript[5] = "### PASSWORT: EINTRAGE-FEHLER ### Passwort entspricht Sicherheitsrichtlinien nicht";
$bausteine[5] = "Unsicheres Passwort!";

$descript[6] = "### EINTRAGE-FEHLER ### verschiedene Passwörter";
$bausteine[6] = "Eingabefehler. Die angegebenen Passwörter sind nicht identisch.";

$descript[7] = "### EINTRAGE-FEHLER ### falsches altes Passwort -> logout";
$bausteine[7] = "das bisherige Passwort war nicht korrekt!%nZ%
		Aus Sicherheitsgründen wurdest du abgemeldet!";