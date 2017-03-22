<?php
/**
 * Texte für Log-In und Log-Out
 */


/** @var ARRAY|STRING $bausteine
 * Ein Array mit allen Textbausteinen für LogIn und LogOut
 *
 * 0 => bei nicht bestätigter Mail-Adresse
 * 1 => bei nicht bestätigtem Account
 * 2 => wenn der User geblockt wurde
 * 3 => bei geänderter Mail-Adresse
 * 4 => bei funktionierendem Login. Davor steht Hallo [Vorname]!
 * 5 => beim Abmelden
 */
$bausteine = array();

/** @var ARRAY|STRING $descript
 * Beschreibung der Textbausteine (für Veränderung)
 */
$descript = array();

### ### ### 


$descript[0] = "bei nicht bestätigter Mail-Adresse"; 
$bausteine[0] = "Bitte bestätige erst Deine E-Mail-Adresse. Davor bist Du hier nicht zugangsberechtigt.%nZ%%nZ%%k*Hat sich Deine E-Mail-Adresse geändert?*k%%nZ%Dann schreib uns eine E-Mail &#40;webmaster@lmgu-abiball.de&#41; mit Deinem Vor- & Nachnamen, sowie Deiner neuen E-Mail-Adresse."; 

$descript[1] = "bei nicht bestätigtem Account"; 
$bausteine[1] = "Dein Account muss noch von einem Administrator bestätigt werden, bevor Du Zugriff auf die Website erhältst.%nZ%Du bekommst eine E-Mail, sobald Dein Account verifiziert ist.%nZ%%nZ%%k*Hat sich Deine E-Mail-Adresse geändert?*k%%nZ%Dann schreib uns eine Nachricht mit Deinem Vor- & Nachnamen, sowie Deiner neuen E-Mail-Adresse.%nZ%%nZ%%k*Du wartest schon seit Tagen auf deine Mail?*k%%nZ%Der Validierungsprozess dauert normalerweise bis zu drei Tage, bitte gib uns jedoch eine Woche Zeit.%nZ%Falls Du bis dahin immer noch nichts von uns gehört hast, informiere uns bitte.%nZ%%nZ%E-Mail-Adresse: webmaster@lmgu-abiball.de"; 

$descript[2] = "wenn der User geblockt wurde"; 
$bausteine[2] = "%f*Dein Account wurde von uns gesperrt.*f%%nZ%Die Begründung dafür hast Du per Mail erhalten. Dort findest Du auch, wie Du weiter vorgehen kannst.%nZ%"; 

$descript[3] = "Bei geänderter Mail-Adresse"; 
$bausteine[3] = "Du hast vor Kurzem deine E-Mail-Adresse geändert.%nZ%Bitte bestätige erst die neue E-Mail-Adresse. Davor bist Du hier nicht zugangsberechtigt.%nZ%%nZ%Du hast nichts gemacht? - Informiere uns! webmaster@lmgu-abiball.de"; 

$descript[4] = "bei funktionierendem Login. Davor steht Hallo [Vorname]!"; 
$bausteine[4] = "Du bist nun erfolgreich angemeldet.%nZ%%nZ%%link*%kartenbestellung%Direkt zur Kartenbestellung%*link%"; 

$descript[5] = "beim Abmelden"; 
$bausteine[5] = "Du bist nun abgemeldet.%nZ%Auf Wiedersehen!"; 

