// zur Startseite
	function toHome() {
		document.location = "/";
	}


// Aufloesung ueberpruefen, umleitung auf mobile Seite
	function Aufloesung() {
		if ( ($(document).width() <= 827) || ($(document).height() <= 420) ) {
		    var $Check = confirm("Aufgrund der geringen Auflösung empfehlen wir die Verwendung unserer Mobilen Seite.");
			if ( $Check == true) {
				window.location = "/mobile";
			} else {
			// Sonst ganz normal weiterladen
			}
		}
	}

	
	
// Anpassen der DIV-Gr��en
	function resize() {
		// Falls Hochkannt, dann Bild neu ausrichten - Für 1920x1080!!!
		if ( ($(document).width() / 1920) <= ($(document).height() / 1080) ) {
			$("#backgroundimage").height("100%").width("auto");
			// Bild zentrieren
			var $BGleft = ( $(document).width() - $("#backgroundimage").width() )/2;
			document.getElementById('backgroundimage').style.left = $BGleft+"px";
		} else {
			$("#backgroundimage").height("auto").width("100%");
			// Bild zentrierung aufheben
			document.getElementById('backgroundimage').style.left = "0";
		}
			
		// WRAPPER
		var $wrapperHoehe = $(document).height() - 210; // Hoehe des Wrappers
        if ($wrapperHoehe > 1100) { $wrapperHoehe = 1100; }
        var $wrapperBreite = $(document).width() * 0.8; // Breite des Wrappers bleibt auf 80%
		$("#wrapper").height($wrapperHoehe).width($wrapperBreite);

		
		// Footer Zentrieren
        var $footerBreite = $("#footer").width();
		$("#footer").width($footerBreite);
		var $footerLeft = ($(document).width() - $footerBreite )/2;
		document.getElementById('footer').style.left = $footerLeft + "px";

			
			
		// Die User-Uebersicht
			// Dreieck platzieren
				// Rechts
				var $userRight = $("#user").width() + 10;
				document.getElementById('user_1').style.right = $userRight + "px";
				$("#user_1").animate( {right: $userRight} , 1 );
				// H�he
				var $userSize = $("#user").height() + 10;
                document.getElementById('user_1').style.borderBottom = $userSize + "px solid transparent";
                document.getElementById('user_1').style.borderRight = $userSize + "px solid rgba(24, 24, 24, 0.95)";
			// Schraege Linie
				$("#user_2").height($userSize + 5).width($userSize);
				// Damit man die "ecke" nicht sieht
				document.getElementById('user_2').style.top = "-2";
				document.getElementById('user_2').style.left = "1";
	}

	
	
// Groessenaenderung ueberwachen
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