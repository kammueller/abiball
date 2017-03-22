<?php
/**
 * Textbausteine für eintragen.php und eintragenNeu.php
 */

/** @var ARRAY|STRING $bausteine
 * Ein Array mit Allen Textbausteinen für das Account-Erstellen
 *
 * 0 => der Text über den Eingabefeldern
 * 1 => Beschreibung für das erforderlich Anhak-Dings unter den Hinweisen
 * 2 => ### EINTRAGE-FEHLER ### wenn nicht alle Daten übergeben worden sind
 * 3 => ### EINTRAGE-FEHLER ### Passwort entspricht Sicherheitsrichtlinien nicht"
 * 4 => ### EINTRAGE-FEHLER ### keine (gültige) Mail-Adresse angegeben
 * 5 => ### EINTRAGE-FEHLER ### verschiedene Passwörter
 * 6 => ### EINTRAGE-FEHLER ### wenn die Checkbox (Datenschutz etc) nicht aktiviert wurde
 * 7 => wenn die Daten nicht in die Datenbank eingetragen werden konnten
 * 8 => nur ein Nutzer pro Mailadesse
 * 9 => nur ein Nutzer pro Person
 * 10 => Mail zur Bestätigung wurde versendet - auf Spam-Ordner-Möglichkeit hinweisen!
 * 11 => Mail zur Bestätigung konnte nicht versendet werden - Admin ansprechen!
 */
$bausteine = array();

/** @var ARRAY|STRING $descript
 * Beschreibung der Textbausteine (für Veränderung)
 */
$descript = array();

### ### ### 


$descript[0] = "der Text über den Eingabefeldern"; 
$bausteine[0] = "Erstelle Dir einen neuen Account.%nZ%Die E-Mail-Adresse muss bestätigt werden und der Account von einem Admin zugelassen werden.%nZ%%nZ%Damit diese Website korrekt funktioniert, müssen JavaScript und Cookies für lmgu-abiball.de und kammueller.eu erlaubt werden."; 

$descript[1] = "Beschreibung für das erforderlich Anhak-Dings unter den Hinweisen"; 
$bausteine[1] = "Ich akzeptiere, Cookies und JavaScript zuzulassen."; 

$descript[2] = "### EINTRAGE-FEHLER ### wenn nicht alle Daten übergeben worden sind"; 
$bausteine[2] = "Eingabefehler. Bitte alle Felder ausfüllen."; 

$descript[3] = "### EINTRAGE-FEHLER ### Passwort entspricht Sicherheitsrichtlinien nicht"; 
$bausteine[3] = "Unsicheres Passwort!"; 

$descript[4] = "### EINTRAGE-FEHLER ### keine (gültige) Mail-Adresse angegeben"; 
$bausteine[4] = "Inkorrekte Mailadresse!%nZ% ggf. Punycode verwenden!"; 

$descript[5] = "### EINTRAGE-FEHLER ### verschiedene Passwörter"; 
$bausteine[5] = "Eingabefehler. Die angegebenen Passwörter sind nicht identisch."; 

$descript[6] = "### EINTRAGE-FEHLER ### wenn die Checkbox (Datenschutz etc) nicht aktiviert wurde"; 
$bausteine[6] = "Eingabefehler. AGB wurden nicht akzeptiert."; 

$descript[7] = "wenn die Daten nicht in die Datenbank eingetragen werden konnten"; 
$bausteine[7] = "Entschuldigung, hier ist wohl etwas schief gelaufen. Bitte probiere es nochmal."; 

$descript[8] = "nur ein Nutzer pro Mailadesse"; 
$bausteine[8] = "Diese E-Mail-Adresse wird bereits für einen Account verwendet. Pro E-Mail-Adresse kann nur ein Account erstellt werden. Bitte wähle eine andere E-Mail-Adresse."; 

$descript[9] = "nur ein Nutzer pro Person"; 
$bausteine[9] = "Du hast schon einen Benutzer angelegt.%nZ%Bitte logge dich ein."; 

$descript[10] = "Mail zur Bestätigung wurde versendet - auf Spam-Ordner-Möglichkeit hinweisen!"; 
$bausteine[10] = "Bitte bestätige Deine E-Mail-Adresse mit dem Verifizierungslink, den Du soeben per E-Mail zugesendet bekommen hast.%nZ%Falls sich die Mail nicht in Deinem Posteingang befindet, überprüfe bitte Deinen Spam-Ordner. Füge webmail@lmgu-abiball.de außerdem auf Deine Liste vertraulicher Absender hinzu, damit weitere Benachrichtigungen nicht im Spam-Ordner landen."; 

$descript[11] = "Mail zur Bestätigung konnte nicht versendet werden - Admin ansprechen!"; 
$bausteine[11] = "Es ist leider zu einem internen Fehler gekommen. Bitte informiere uns darüber: webmaster@lmgu-abiball.de"; 

$descript[12] = "Die AGB müssen im Impressum bearbeitet werden."; 
$bausteine[12] = "Es ist sinnlos, diesen Text zu verändern!"; 

