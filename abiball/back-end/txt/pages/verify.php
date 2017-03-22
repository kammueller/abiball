<?php
/**
 * Textbausteine für newMail_verify.php und verify.php
 */

/** @var ARRAY|STRING $bausteine
 * Ein Array mit Allen Textbausteinen für das Account-Erstellen
 *
 * 0 => Link funktioniert nicht
 * 1 => Datenbank-Fehler, nochmal probieren
 * 2 => Neue Mail-Adresse bestätigt
 * 3 => Neuer Nutzer - Mailadresse bestätigt - auf Wartezeit hinweisen
 */
$bausteine = array();

/** @var ARRAY|STRING $descript
 * Beschreibung der Textbausteine (für Veränderung)
 */
$descript = array();

### ### ###

$descript[0] = "Link funktioniert nicht";
$bausteine[0] = "Der Link scheint nicht zu funktionieren. Bitte überprüfe, ob er mit dem in der Mail übereinstimmt.%nZ%
	Falls es immer noch nicht geht, informiere uns bitte: webmaster@lmgu-abiball.de";

$descript[1] = "Datenbank-Fehler, nochmal probieren";
$bausteine[1] = "Ups, da ist uns ein Fehler unterlaufen. Bitte probiere es nochmal oder wende Dich an uns: webmaster@lmgu-abiball.de";

$descript[2] = "Neue Mail-Adresse bestätigt";
$bausteine[2] = "Vielen Dank, deine E-Mail-Adresse wurde bestätigt.%nZ%
		Du hast nun wieder vollen Zugriff.";

$descript[3] = "Neuer Nutzer - Mailadresse bestätigt - auf Wartezeit hinweisen";
$bausteine[3] = "Vielen Dank, deine E-Mail-Adresse wurde bestätigt.%nZ%
		Nun musst Du nur noch warten, bis ein Admin Dein Profil zugelassen hat. Das sollte in der Regel nicht mehr als drei Tage dauern.%nZ%
		Falls Du fragen hast, wende Dich an uns: webmaster@lmgu-abiball.de";
