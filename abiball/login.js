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
			$("#backgroundimage").height("100%").width("auto");
			// Bild zentrieren
			$BGleft = ( $(document).width() - $("#backgroundimage").width() )/2;
			document.getElementById('backgroundimage').style.left = $BGleft+"px";
		} else {
			$("#backgroundimage").height("auto").width("100%");
			// Bild zentrierung aufheben
			document.getElementById('backgroundimage').style.left = "0";
		}
		// Wrapper-Breite fixen
		$wrapperBreite = $("#wrapper").width();
		$("#wrapper").width($wrapperBreite);

	}
	
	function loading() {
		// Hilfe ausblenden
		document.getElementById('help').style.display = "block";
		$('#help').slideToggle(1);

        // Breite der Inputs setzen
        $(".input").width($(".input").width());
	}

	
	
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
	
// Formularvorgaben l�schen
	function LeerenVor() {
	if(document.login.Vorname.value == "Vorname") {
		document.login.Vorname.value = "";
		document.login.Vorname.focus();}
	document.login.Vorname.style.color = "#000";
	document.login.Vorname.style.fontStyle = "normal";
	}
	function LeerenNach() {
	if(document.login.Nachname.value == "Nachname") {
		document.login.Nachname.value = "";
		document.login.Nachname.focus();}
	document.login.Nachname.style.color = "#000";
	document.login.Nachname.style.fontStyle = "normal";
	}
	function LeerenPass() {
	if(document.login.password.value == "pass") {
		document.login.password.value = "";
		document.login.password.focus();}
	}
	
// Help ein/ausblenden
	function help() {
		$('#help').slideToggle();
	}
	
// Formular-Check
	function chkFormular() {
	  $ret = true;
	  if ( (document.login.Vorname.value == "") || (document.login.Vorname.value == "Vorname") ) {
		$("#vor").slideDown(100);
		$ret =  false;
	  } else { $("#vor").slideUp(100); }
	  if ( (document.login.Nachname.value == "") || (document.login.Nachname.value == "Nachname") ) {
		$("#nach").slideDown(100);
		$ret = false;
	  } else { $("#nach").slideUp(100); }
	  if ( (document.login.password.value == "") || (document.login.password.value == "pass") ) {
		$("#passwort").slideDown(100);
		document.login.password.focus();
		$ret =  false;
	  } else { $("#passwort").slideUp(100); }
	  return $ret;
	}
	
// Errormessage
	function errorWeg() {
		$("#message").animate({top: "+=20"}, 500, "swing").delay(3000).fadeOut();
	}