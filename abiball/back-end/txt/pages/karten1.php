<?php
/**
 * Alle Texte für die Kartenbestellung
 * (erste Kartenbestellung & Kartentausch)
 */

/** @var ARRAY|STRING $bausteine
 * Ein Array mit den fixen Textbausteinen für die erste Kartenbestellung und den Kartentausch
 *
 * 0 => Allgemeines Intro
 * 1 => Zur Zeit keine Tickets vorhanden
 * 2 => Erste Bestellrunde, Erklärung
 * 3 => Erste Bestellrunde, Karten schon gekauft
 * 4 => Zusatzkarten - heute schon bestellt
 * ERSTE BESTELLRUNDE
 * 5 => Fehler - Karten wurden bereits bestellt
 * 6 => Intro-Text
 * 7 => Beschreibung Wunsch-Anzahl
 * 8 => Anmerkung Wunsch-Anzahl (bei Nichterscheinen bitte 0 eingeben)
 * 9 => Erklärung Namensfelder
 * 10 => Anmerkung: Erste Karte für Abiturienten
 * 11 => Beschreibung Kommentarfeld
 * 12 => Button-Text Zurücksetzen
 * 13 => Button-Text Absenden
 * 14 => Bestellung über 0 Karten abgearbeitet
 * 15 => Bestellung erfolgreich abgeschlossen
 * 16 => Mehr als 4 Karten bestellt:
 * KARTENTAUSCH
 * 17 => Intro-Text
 * 18 => Beschreibung abzugebene Karte
 * 19 => Beschreibung Empfänger
 * 20 => Button-Text Zurücksetzen
 * 21 => Button-Text Absenden
 */
$bausteine = array();

/** @var ARRAY|STRING $descript
 * Beschreibung der Textbausteine (für Veränderung)
 */
$descript = array();

### ### ### 


$descript[0] = "Hinweis: Die Texte mit Verlinkungen müssen getrennt bearbeitet werden!!<br>
                '%link*%sitzplatz%' steht immer zur Verfügung <br><br>
                Allgemeines Intro";
$bausteine[0] = "Gesamt haben wir ca. 700 Karten, diese werden wir schrittweise freigeben.%nZ%Aktuelle Informationen findet ihr im Blog!"; 

$descript[1] = "Zur Zeit keine Tickets vorhanden"; 
$bausteine[1] = "Leider gibt es zurzeit keine freien Karten."; 

$descript[2] = "Erste Bestellrunde, Erklärung"; 
$bausteine[2] = "Wir sind momentan in der ersten Bestellungsrunde.%nZ%Hier erhält jeder Abiturient bis zu 4 Karten garantiert.%nZ%Achtung: Bei nicht bestellten Karten verfällt das Anrecht."; 

$descript[3] = "Erste Bestellrunde, Karten schon gekauft"; 
$bausteine[3] = "Du hast Deine Karten schon bestellt.%nZ%Falls Du Weitere bestellen möchtest, schau regemäßig in den Blog - hier wird bekannt gegeben, wenn weitere Karten zur Verfügung gestellt werden."; 

$descript[4] = "Zusatzkarten - heute schon bestellt"; 
$bausteine[4] = "Du hast heute schon Deine Zusatzkarten bestellt.%nZ%Schau bitte die Tage nochmal vorbei."; 

$descript[5] = "<br><br><br><b>Erste Bestellrunde</b><br>
                Fehler - Karten wurden bereits bestellt"; 
$bausteine[5] = "%headline*Fehler*headline%%nZ%Du darfst bloß einmal garantierte Karten bestellen!	%nZ%Falls es Probleme geben sollte, wende Dich an uns."; 

$descript[6] = "Intro-Text"; 
$bausteine[6] = "Du bekommst garantiert bis zu 4 Karten.%nZ%Wenn Karten übrig bleiben, werden die weiteren verteilt. Um besser planen zu können, gib bitte trotzdem an, wie viele Karten du haben wollen würdest.%nZ%Eine Karte kostet %f*50 €*f%.%nZ%%nZ%%f*Bestellungen sind verbindlich und endgültig und können nicht zurückgenommen werden!*f%"; 

$descript[7] = "Beschreibung Wunsch-Anzahl"; 
$bausteine[7] = "Anzahl an gewünschten Karten:"; 

$descript[8] = "Anmerkung Wunsch-Anzahl &#40;bei Nichterscheinen bitte 0 eingeben&#41;"; 
$bausteine[8] = "%k*Falls Du nicht erscheinen kannst, so trage hier bitte &quot;0&quot; ein.*k%"; 

$descript[9] = "Erklärung Namensfelder"; 
$bausteine[9] = "Da die Karten persönlich ausgestellt werden, trage bitte hier die bis zu vier Namen ein &#40;je Vor- & Nachname&#41;: "; 

$descript[10] = "Anmerkung: Erste Karte für Abiturienten"; 
$bausteine[10] = "  %k*&#40;Eine Karte muss auf den/die Abiturienten/-in ausgestellt werden.&#41;*k%"; 

$descript[11] = "Beschreibung Kommentarfeld"; 
$bausteine[11] = "Hier kannst Du weitere Kommentare hinterlassen"; 

$descript[12] = "Button-Text Zurücksetzen"; 
$bausteine[12] = "Zurücksetzen"; 

$descript[13] = "Button-Text Absenden"; 
$bausteine[13] = "Bestellung aufgeben"; 

$descript[14] = "Bestellung über 0 Karten abgearbeitet"; 
$bausteine[14] = "Schade, dass Du keine Karten haben willst.%nZ%Vielen Dank für Deine Angabe."; 

$descript[15] = "Bestellung erfolgreich abgeschlossen"; 
$bausteine[15] = "Danke für Deine Bestellung deiner Karte&#40;n&#41;."; 

$descript[16] = "Mehr als 4 Karten bestellt:"; 
$bausteine[16] = "Die vier garantierten Karten wurden nun für Dich bestellt, Dein Interesse an mehr Karten wurde gespeichert.%nZ%Wir melden uns, wenn es neue Karten gibt.%nZ%"; 

$descript[17] = "<br><br><br><b>Kartentausch</b><br>
                Intro-Text"; 
$bausteine[17] = "Da die Karten personalisiert sind, kannst du hier den Inhaber der einzelnen Karten ändern.%nZ%Wir weisen ausdrücklich darauf hin, dass es nicht verboten ist, die Karten an andere weiterzugeben, weil der &quot;originale Inhaber&quot; terminlich verhindert ist. Für sämtliche finanzielle Aspekte sind wir nicht verantwortlich. Es gibt keine Möglichkeit, gekaufte und bezahlte Karten zurückzugeben.%nZ%%nZ%Bitte gib hier an, welche Karte du abgibst und wer die Karte erhalten soll."; 

$descript[18] = "Beschreibung abzugebene Karte"; 
$bausteine[18] = "Abgegebene Karte:"; 

$descript[19] = "Beschreibung Empfänger"; 
$bausteine[19] = "Empfänger &#40;Vor-, Nachname&#41;:"; 

$descript[20] = "Button-Text Zurücksetzen"; 
$bausteine[20] = "Zurücksetzen"; 

$descript[21] = "Button-Text Absende"; 
$bausteine[21] = "Karten tauschen &#40;jetzt!&#41;"; 

$descript[22] = "Kartentausch erfolgreich vollzogen<br>
                Bitte auch entsprechende Mail bearbeiten!"; 
$bausteine[22] = "Die Karte wurde erfolgreich umadressiert.%nZ%Du hast eine Benachrichtigung per Mail bekommen. Die aktualisierte Rechnung kannst Du Dir %link*%profil%auf Deinem Profil%*link% herunterladen."; 

