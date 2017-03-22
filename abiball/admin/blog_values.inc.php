<?php
if ($loggedIn == "speak Friend and Enter") {
echo ('
	
	<p><b>Hinweis:</b> HTML-Tags werden nicht unterstützt. Zeilenumbrüche können mit "%nZ%" erwirkt werden.<br>
	Folgende Formatvorlagen sind vorhanden: (In [] geschriebenen Text bitte ersetzen!!)<br>
	<button name="Format" type="button" onclick="neueZeile()">Zeilenumbruch einfügen</button>
	<button name="Format" type="button" onclick="fett()">Fett gedruckten Text einfügen</button>
	<button name="Format" type="button" onclick="kursiv1()">Kursiven Text (typ 1) einfügen</button>
	<button name="Format" type="button" onclick="kursiv2()">Kursiven Text (typ 2) einfügen</button>
	<button name="Format" type="button" onclick="unterstr()">Unterstrichenen Text einfügen</button>
	<button name="Format" type="button" onclick="headline()">Große Überschrift einfügen</button>
	<button name="Format" type="button" onclick="titel()">(kleinere) Überschrift einfügen</button><br>
	<button name="Link" type="button" onclick="home()">Link zu "Home" einfügen</button>
	<button name="Link" type="button" onclick="karte()">Link zu "Kartenbestellung" einfügen</button>
	<button name="Link" type="button" onclick="sitz()">Link zu "Sitzplatzreservierung" einfügen</button>
	<button name="Link" type="button" onclick="loc()">Link zu "Location" einfügen</button>
	<button name="Link" type="button" onclick="essen()">Link zu "Menü" einfügen</button>
	<button name="Link" type="button" onclick="blog()">Link zu "Neuigkeiten" einfügen</button>
	<button name="Link" type="button" onclick="blogSpez()">Link zu speziellem Blog-Artikel [value] einfügen</button>
	<button name="Link" type="button" onclick="impr()">Link zu "Impressum" einfügen</button>
	<button name="Link" type="button" onclick="prof()">Link zum Profil einfügen</button>
	<button name="Link" type="button" onclick="rech()">Link zum Rechnungs-Download einfügen</button><br>

');

}


