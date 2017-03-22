<?php
/**
 * Alle Texte für die Kartenbestellung
 * (Rechnung)
 */

/** @var ARRAY|STRING $bausteine
 * Ein Array mit den fixen Textbausteinen für die Rechnungen
 *
 * RECHNUNGEN
 * 0 => Kontoinhaber
 * 1 => IBAN
 * 2 => BIC
 * 3 => Kontonummer
 * 4 => BLZ
 * 5 => Bank
 * 6 => Text auf der Vorderseite, Zeilenumbrüche sind erlaubt
 * 7 => Rechtliche Hinweise (zweite/letzte Seite) - Falls nicht gebraucht, Feld LEER lassen - mit Zeilenumbrüchen
 * 8 => Titel Seitenbeschreibung
 * 9 => Web-Adresse
 * 10 => Bereits bezahlte Rechnung - fetter Hinweis - mit %nZ%
 * 11 => Bereits bezahlte Rechnung - Nachsatz - mit %nZ%
 */
$bausteine = array();

/** @var ARRAY|STRING $descript
 * Beschreibung der Textbausteine (für Veränderung)
 */
$descript = array();

### ### ### 


$descript[0] = "<b>Hinweis:</b> Diese Texte werden NICHT encoded! Bitte auch keine Zeilenumbrüche einfügen!!<br><br>
                Kontoinhaber"; 
$bausteine[0] = "Matthias Kammüller"; 

$descript[1] = "IBAN"; 
$bausteine[1] = "DE15 7025 0150 0027 7938 68"; 

$descript[2] = "BIC"; 
$bausteine[2] = "BYLADEM1KMS"; 

$descript[3] = "Kontonummer"; 
$bausteine[3] = "27793868"; 

$descript[4] = "BLZ"; 
$bausteine[4] = "702 501 50"; 

$descript[5] = "Bank"; 
$bausteine[5] = "Kreissparkasse MSE"; 

$descript[6] = "Text auf der Vorderseite, Zeilenumbrüche sind erlaubt"; 
$bausteine[6] = "Bitte überweise die oben genannte Summe innerhalb der nächsten 14 Tage auf untenstehendes Konto. Als Überweisungsgrund gibst Du bitte ``Kartenbestellung [Bestellnummer]`` an, wobei Du natürlich [Bestellnummer] durch die obenstehende Zahl ersetzt.%nZ%%nZ%Teilzahlungen sind nicht zulässig, Rückerstattung des Kaufpreises ist nicht möglich."; 

$descript[7] = "Rechtliche Hinweise (zweite/letzte Seite)<br>
                Falls nicht gebraucht, Feld LEER lassen"; 
$bausteine[7] = ""; 

$descript[8] = "<br><br><br>
                <b>Hinweis:</b> Beim folgeden bitte nochmals die Seitentitel angeben!<br><br>
                Titel Seitenbeschreibung - keine Zeilenumbrüche!"; 
$bausteine[8] = "Abiball 2015 LMGU"; 

$descript[9] = "Web-Adresse - keine Zeilenumbrüche!"; 
$bausteine[9] = "lmgu-abiball.de"; 

$descript[10] = "Mail-Adresse - keine Zeilenumbrüche!"; 
$bausteine[10] = "webmaster@lmgu-abiball.de"; 

$descript[11] = "Bereits bezahlte Rechnung - fetter Hinweis<br>
                Beginnt mit Diese Rechnung wurde bereits am xx.xx.xxxx beglichen"; 
$bausteine[11] = "Bitte überweisen Sie das Geld NICHT nochmals.%nZ%Die Bestellung wird hier bloß aus Gründen der Vollständigkeit und zum Verfügungstellen der Daten aufgeführt."; 

$descript[12] = "Bereits bezahlte Rechnung - Nachsatz"; 
$bausteine[12] = "Vielen Dank für ihre Bestellung."; 

