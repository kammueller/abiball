<?php
/**
 * Alle Texte für die Kartenbestellung
 * (Nachbestellung)
 */

/** @var ARRAY|STRING $bausteine
 * Ein Array mit den fixen Textbausteinen für die Nachbestellung
 *
 * NACHBESTELLUNG
 * 0 => Zusatzkarten schon bestellt
 * 1 => Keine Tickets reservierbar
 * 2 => Intro-Text
 * 3 => Beschreibung Kartenanzahl
 * 4 => Erklärung Namensfelder
 * 5 => Button-Text Zurücksetzen
 * 6 => Button-Text Absenden
 * 7 => Reservierung aufgeben, Kartenbestellung abbrechen
 * 8 => Keine Karten reserviert bei Abgabe
 * 9 => Bestellung erfolgreich
 */
$bausteine = array();

/** @var ARRAY|STRING $descript
 * Beschreibung der Textbausteine (für Veränderung)
 */
$descript = array();

### ### ### 


$descript[0] = "Hinweis: Die Texte mit Verlinkungen müssen getrennt bearbeitet werden!!<br><br>
                <b>Nachbestellung</b><br>
                Zusatzkarten schon bestellt"; 
$bausteine[0] = "Du hast heute schon Deine Zusatzkarten bestellt.%nZ%%nZ%Schau bitte die Tage nochmal vorbei."; 

$descript[1] = "Keine Tickets reservierbar"; 
$bausteine[1] = "Leider gibt es zur Zeit keine Tickets!"; 

$descript[2] = "Intro-Text"; 
$bausteine[2] = "Du kannst bis zu zwei Karten nachbestellen. Dafür hast Du 5 Minuten Zeit.%nZ%Du kannst nach dieser Bestellung heute keine Bestellung mehr aufgeben.%nZ%%nZ%Eine Karte kostet %f*50 €*f%."; 

$descript[3] = "Beschreibung Kartenanzahl"; 
$bausteine[3] = "Anzahl an Karten:"; 

$descript[4] = "Erklärung Namensfelder"; 
$bausteine[4] = "Da die Karten persönlich ausgestellt werden, trage bitte hier die bis zu vier Namen ein &#40;je Vor- & Nachname&#41;: "; 

$descript[5] = "Button-Text Zurücksetzen"; 
$bausteine[5] = "Zurücksetzen"; 

$descript[6] = "Button-Text Absenden"; 
$bausteine[6] = "Kartenbestellung abgeben"; 

$descript[7] = "Reservierung aufgeben, Kartenbestellung abbrechen"; 
$bausteine[7] = "Bestellung abbrechen"; 

$descript[8] = "Keine Karten reserviert bei Abgabe"; 
$bausteine[8] = "Du hast keine Karten reserviert.%nZ%Was machst Du dann hier?!"; 

$descript[9] = "Bestellung erfolgreich"; 
$bausteine[9] = "Vielen Dank für deine Bestellung!"; 

