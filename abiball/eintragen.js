//Formular �berpr�fen
	function Mailwerte(el) {
        var $wert = (el != el.replace(/[^a-zA-Z0-9@\._-]/g, ""));
		}
	 
	 
	function chkPass() {
        var $ret = true;
/*
	// Vorname
	 if (document.Anmeldung.Vorname.value == "") {
			$("#vor").slideDown(100);
			$ret = false;
		  } else { $("#vor").slideUp(100); }
		  
	// Nachname
	 if (document.Anmeldung.Nachname.value == "") {
			$("#nach").slideDown(100);
			$ret = false;
		  } else { $("#nach").slideUp(100); }
*/
	
	// Mail
		Mailwerte(document.Anmeldung.mail.value);
	  if ( (document.Anmeldung.mail.value == "")  || (document.Anmeldung.mail.value == "neue Mail-Adresse") || (document.Anmeldung.mail.value.indexOf("@") == -1) || ($wert) ) {
			$("#mailA").slideDown(100);
			$ret = false;
		  } else { $("#mailA").slideUp(100); }
	  
	  
	// Passwort
	  if ( document.Anmeldung.passwort.value == "" ) {
		$("#eins").slideDown(100);
		$ret =  false;
	  } else { $("#eins").slideUp(100); }
	  var laenge = (document.Anmeldung.passwort.value.length > 7);
	  if (laenge == false) {
		$("#zwei").slideDown(100);
		$ret =  false;
	  } else { $("#zwei").slideUp(100); }
	  var derSatz =  document.Anmeldung.passwort.value;
	  var Suche = /\d/g;
	  var Ergebnis = Suche.test(derSatz);
	  if (Ergebnis == false) {
		$("#drei").slideDown(100);
		$ret =  false;
	  } else { $("#drei").slideUp(100); }
	  if ( ( document.Anmeldung.passwort.value.toUpperCase() == document.Anmeldung.passwort.value ) || ( document.Anmeldung.passwort.value.toLowerCase() == document.Anmeldung.passwort.value ) ) {
		$("#vier").slideDown(100);
		$ret =  false;
	  } else { $("#vier").slideUp(100); }
	  
	// PW wiederholung
	  if ( document.Anmeldung.passwort2.value != document.Anmeldung.passwort.value ) {
		$("#fuenf").slideDown(100);
		$ret =  false;
	  } else { $("#fuenf").slideUp(100); }

/* NUR FÜR EIGENVERSION AUSKLAMMERN
	// AGB?!
	  if ( document.Anmeldung.agb.checked == false ) {
		document.getElementById("losgehts").style.fontWeight = "bold";
		document.getElementById("losgehts").style.color = "red";
		$ret = false;
	  } else { document.getElementById("losgehts").style.fontWeight = "normal";
		document.getElementById("losgehts").style.color = "black"; } 
*/
	  return $ret;
	}

// Errormessage
	function errorWeg() {
		$("#message").animate({top: "+=20"}, 500, "swing").delay(3000).fadeOut();
	}

/*

// Aufl�sung �berpr�fen, umleitung auf mobile Seite

	function Aufloesung() {
		if ( ($(document).width() <= 827) || ($(document).height() <= 420) ) {
		    $Check = confirm("Aufgrund der geringen Auflösung empfehlen wir die Verwendung unserer Mobilen Seite.");
			if ( $Check == true) {
				location.href = "http://lmgu-abiball.de/mobil.html";
			} else {
			// Sonst ganz normal weiterladen
			}
		}
	}

	
	
// Anpassen der DIV-Gr��en
	function resize() {
		// Falls Hochkannt, dann Bild neu ausrichten - fuer 1920x1080!!!
		if ( ($(document).width() / 1920) <= ($(document).height() / 1080) ) {
			$("#backgroundimage").height("100%");
			$("#backgroundimage").width("auto");
			// Bild zentrieren
			$BGleft = ( $(document).width() - $("#backgroundimage").width() )/2;
			document.getElementById('backgroundimage').style.left = $BGleft+"px";
		} else {
			$("#backgroundimage").height("auto");
			$("#backgroundimage").width("100%");
			// Bild zentrierung aufheben
			document.getElementById('backgroundimage').style.left = "0";
		}

		// H�he des Wrappers
		$wrapperHoehe = $(document).height() - 210;
		$("#wrapper").height($wrapperHoehe);
		// Breite des Wrappers bleibt auf 80%
		$wrapperBreite = $(document).width() * 0.8;
		$("#wrapper").width($wrapperBreite);
		// Wenn Die H�he des Contents Gr��er als 1100 px ist, auf 1100 px setzen
			if ($("#wrapper").height() > 1100) { $("#wrapper").height("1100px"); }

		
		// H�he des Contents
		$contentHoehe = $(document).height() - 230; // wrapperHoehe - 20
		$("#contentA").height($contentHoehe);
		$("#contentB").height($contentHoehe);
		// Breite des Contents
		$contentBreite = $wrapperBreite/2 - 20;
		$("#contentA").width($contentBreite);
		$("#contentB").width($contentBreite);
		
		// H�he der AGB etc
		$agbHoehe = $contentHoehe - $("#losgehts").height();
		$("#agb").height( $agbHoehe );

		
	}

*/
	
// Gr��en�nderung �berwachen
/**
 * @return {number}
 */
function Fensterweite () {
	  if (window.innerWidth) {
		return window.innerWidth;
	  } else if (document.body && document.body.offsetWidth) {
		return document.body.offsetWidth;
	  } else {
		return 0;
	  }
	}

/**
 * @return {number}
 */
function Fensterhoehe () {
	  if (window.innerHeight) {
		return window.innerHeight;
	  } else if (document.body && document.body.offsetHeight) {
		return document.body.offsetHeight;
	  } else {
		return 0;
	  }
	}

	function neuAufbau () {
	  if (Weite != Fensterweite() || Hoehe != Fensterhoehe())
		Aufloesung();
		resize();
	}

	/* �berwachung von Netscape initialisieren */
	if (!window.Weite && window.innerWidth) {
	  window.onresize = neuAufbau;
	  Weite = Fensterweite();
	  Hoehe = Fensterhoehe();
	}

