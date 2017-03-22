<?php
/**
 * Karten Links
 * Die Beschreibungen mit Links innerhalb der Kartenbestellung
 * @TODO bearbeitung bauen
 */

/** @var STRING $karten_index_reserviert
 * Wenn man gerade Karten reserviert hat,
 * %link*%nachbestellen% muss vorhanden sein
 */
$karten_index_reserviert = "%f*Du hast gerade Karten reserviert.%nZ%Die Reservierung hält 5 Minuten.%nZ%%link*%nachbestellen%Vervollständige sie jetzt hier!%*link%*f%";

/** @var STRING $karten_index_ersterunde
 * Erste Bestellrunde - Karten bestellen
 * %link*%bestellen% muss vorhanden sein
 */
$karten_index_ersterunde = " %link*%bestellen%Hier geht&#039;s zu Kartenbestellung!%*link%";

/** @var STRING $karten_index_nachbestellen
 * Nachbetstellung - Karten sichern
 * %link*%nachbestellen% muss vorhanden sein
 */
$karten_index_nachbestellen = "Gerade gibt es Karten zu vergeben.%nZ%Klicke %f*jetzt*f% %link*%nachbestellen%hier%*link%, um Dir für 5 Minuten Deine Karten zu reservieren.";

/** @var STRING $karten_index_tauschen
 * Karten tauschen
 * %link*%tauschen% muss vorhanden sein
 */
$karten_index_tauschen = "Du musst die Leute, für die die Karten gelten, ändern? %link*%tauschen%Hier geht das!%*link%";

/** @var STRING $karten_bestellung_rechnung
 * Bestellung wurde abgearbeitet, Downloadlink etc
 * %RechnungsNummer% ist verwendbar,
 * %link*%rechnungen% muss verwendet werden!
 */
$karten_bestellung_rechnung = "Deine Bestellung hat die Nummer %RechnungsNummer% %nZ%Du hast soeben eine E-Mail mit der Rechnung bekommen. Alle Deine Rechnungen kannst Du %link*%rechnungen%hier downloaden%*link%.";
                