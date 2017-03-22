<?php
/**
 * DB ENCODE
 * zieht den Text aus der Datenbank und wandelt ihn in die entsprechenden HTML-Tags oder Variablen um
 * EMPFOHLENE SEITENANSICHT: ohne Zeilenumbruch
 *
 *
 * ### INPUT & RETURN ##
 * @input		$text_input			Der zu verarbeitende Text
 * @return		$text_output		Der verarbeitete Text
 * 
 * 
 * ### SUPPORTED VALUES ###
 * auf Groß- & Kleinschreibung wird wert gelegt!!
 * geöffnete Tags müssen wieder geschlossen werden! (außer Variablen)
 * 
 *
 *  TAG			steht für			Erklärung
 * -- HTML-Tags --
 * 	%nZ%		neue Zeile			fügt einen Zeilenumbruch ein
 * 	%f*			fett				Beginnt einen Fett-Druck
 *	*f%			fett				Beendet den Fett-Druck
 *	%k*			kursiv				Beginnt Kuriv-Druck (standard)
 * 	*k%			kursiv				Beendet Kursiv-Druck (standard)
 *  %kurs*		kursiv				Beginnt Kursiv-Druck (verzierter)
 *	*kurs%		kursiv				Beendet Kursiv-Druck (verzierter)
 * 	%u*			unterstrichen		Beginnt Unterstreichung
 * 	*u%			unterstrichen		Beendet Unterstreichung
 * 	%headline*						Beginnt große Überschrift
 *  *headline%						Beendet große Überschrift
 *  %title*							Beginnt (kleinere) Überschrift
 *  *title%							Beendet (kleinere) Überschrift
 * -- LINKS --
 *  %link*%home%					Verlinkt zu (leeren) Home-Seite
 *  %link*%kartenbestellung%		Verlinkt zur Kartenbestellung (index, also die Übersicht)
 * 	%link*%location%				Verlinkt zur Location-Beschreibung
 * 	%link*%menue%					Verlinkt zum Essens-Menü etc
 * 	%link*%neuigkeiten%				Verlinkt zur Blog-Startseite
 * 	%link*%blogentry%.id.[value].%	Verlinkt zu einem Blog-Eintrag mit gegebener ID (kann z.B. in der URL des Blog-Details nachgesehen werden)
 * 	%link*%impressum%				Verlinkt zum Impressum
 * 	%link*%profil%					Verlinkt zum eigenen Profil
 * 	%link*%rechnungen%				Verlinkt zur (gesammelten) Rechnungs-Ausgabe als PDF (Pop-Up)
 * 	%*link%							Beendet Verlinkung - IMMER NOTWENDIG!!
 */

/**
 * Untersucht den Text auf die Gegebenen Format-Keys und gibt diesen dann als HTML-Text aus
 * @param $text_input
 * @return mixed
 */
function encode($text_input, $mobile=false) {
    // Standard-Formatierungen
        $DB = $text_input;
        $code = array("%nZ%", "%f*",  "*f%",  "%k*",  "*k%",  "%kurs*",                                                "*kurs%",  "%u*",                                         "*u%",    "%headline*",  "*headline%",  "%title*",  "*title%");
        $html = array("<br>", "<b>",  "</b>", "<i>",  "</i>", '<span style="font-family: arapeykursiv, sans-serif;">', '</span>', '<span style="text-decoration: underline;">',  "</span>", "<h1>",       "</h1>",       "<h2>",     "</h2>");
        $html_sign = str_replace($code, $html, $DB);
    // Links
	if ($mobile) {
        $link_raw  = array("%link*%home%",                "%link*%kartenbestellung%",        "%link*%location%",                "%link*%menue%",	            "%link*%neuigkeiten%",         "%link*%impressum%",            "%link*%profil%",                "%link*%rechnungen%",                      "%*link%", "%link*%blogentry%.id.",                '.%');
        $link_html = array('<a href="/mobile/home.php">', '<a href="/mobile/karte">',        '<a href="/mobile/location.php">', '<a href="/mobile/essen.php">', '<a href="/mobile/blog.php">', '<a href="/mobile/about.php">', '<a href="/mobile/profil.php">', '<a href="/mobile/karte/rechnungen.php">', '</a>',    '<a href="/mobile/blog_detail.php?id=', '">');
        $text_output = str_replace($link_raw, $link_html, $html_sign);
	} else {
		$link_raw  = array("%link*%home%",         "%link*%kartenbestellung%", "%link*%sitzplatz%",               "%link*%location%",         "%link*%menue%",	        "%link*%neuigkeiten%",  "%link*%impressum%",     "%link*%profil%",         "%link*%rechnungen%",               "%*link%", "%link*%blogentry%.id.",         '.%');
        $link_html = array('<a href="/home.php">', '<a href="/karte">',        '<a href="/karte/sitzplatz.php">', '<a href="/location.php">', '<a href="/essen.php">', '<a href="/blog.php">', '<a href="/about.php">', '<a href="/profil.php">', '<a href="/karte/rechnungen.php">', '</a>',    '<a href="/blog_detail.php?id=', '">');
        $text_output = str_replace($link_raw, $link_html, $html_sign);
	}
    // Return
        return $text_output;
    }

$already_encoded = true;
		
