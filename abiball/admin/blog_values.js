


// Formatierung
	// Zeilenumbruch
	function neueZeile() { 
		document.edit.text.value = document.edit.text.value + " %nZ% ";
	}
	// Standardzeug
	function kursiv1() { 
		document.edit.text.value = document.edit.text.value + " %k*[KURSIVER TEXT]*k% ";
	}
	function kursiv2() { 
		document.edit.text.value = document.edit.text.value + " %kurs*[KURSIVER TEXT]*kurs% ";
	}
	function fett() { 
		document.edit.text.value = document.edit.text.value + " %f*[FETTER TEXT]*f% ";
	}
	function unterstr() { 
		document.edit.text.value = document.edit.text.value + " %u*[UNTERSTRICHENER TEXT]*u% ";
	}
	// Überschriften
	function headline() { 
		document.edit.text.value = document.edit.text.value + " %headline*[UEBERSCHRIFT 1]*headline% ";
	}
	function titel() { 
		document.edit.text.value = document.edit.text.value + " %title*[UEBERSCHTIFT 2]*title% ";
	}

// Links
	function home() { 
		document.edit.text.value = document.edit.text.value + " %link*%home%[Zur Startseite]%*link% ";
	}
	function karte() { 
		document.edit.text.value = document.edit.text.value + " %link*%kartenbestellung%[Zur Kartenbestellung]%*link% ";
	}
    function sitz() {
        document.edit.text.value = document.edit.text.value + " %link*%sitzplatz%[Zur Sitzplatz-Reservierung]%*link% ";
    }
	function loc() { 
		document.edit.text.value = document.edit.text.value + " %link*%location%[Zur Location-Beschreibung]%*link% ";
	}
	function essen() { 
		document.edit.text.value = document.edit.text.value + " %link*%menue%[Zum Essens-Menue]%*link% ";
	}
	function blog() { 
		document.edit.text.value = document.edit.text.value + " %link*%neuigkeiten%[Zum Blog]%*link% ";
	}
	function blogSpez() { 
		document.edit.text.value = document.edit.text.value + " %link*%blogentry%.id.[BLOG-ID].%[Zu einem speziellen Blog-Artikel]%*link%  [HINWEIS: [BLOG-ID] muss durch die ID des Blog-Eintrages erstezt werden. Diese steht in der Admin-Uebersicht]";
	}
	function impr() { 
		document.edit.text.value = document.edit.text.value + " %link*%impressum%[Zum Impressum]%*link% ";
	}
	function prof() { 
		document.edit.text.value = document.edit.text.value + " %link*%profil%[Zu deinem Profil]%*link% ";
	}
	function rech() { 
		document.edit.text.value = document.edit.text.value + " %link*%rechnungen%[Deine Rechnungen downloaden]%*link% ";
	}
