// Aufl�sung �berpr�fen, umleitung auf mobile Seite
	function Aufloesung() {
		if ( ($(document).width() <= 827) || ($(document).height() <= 420) ) {
		    $Check = confirm(unescape("Aufgrund der geringen Aufl%F6sung empfehlen wir die Verwendung unserer Mobilen Seite."));
			if ( $Check == true) {
				location.href = "http://lmgu-abiball.de/index_m.html";
			} else {
			// Sonst ganz normal weiterladen
			}
		}
	}

	
	
// Anpassen der DIV-Gr��en
	function resize() {
		// Falls Hochkannt, dann Bild neu ausrichten - fuer1920x1080!!!
		if ( ($(document).width() / 1920) <= ($(document).height() / 1080) ) {
			$("#backgroundimage").height("100%");
			$("#backgroundimage").width("auto");
			// Bild zentrieren
			$BGleft = ( $(document).width() - $("#backgroundimage").width() )/2;
			document.getElementById('backgroundimage').style.left = $BGleft;
		} else {
			$("#backgroundimage").height("auto");
			$("#backgroundimage").width("100%");
			// Bild zentrierung aufheben
			document.getElementById('backgroundimage').style.left = "0";
		}
			
		// Footer Zentrieren
        $footerLeft = ($(document).width() - $("#footer").width() )/2;
		document.getElementById('footer').style.left = $footerLeft + "px";
			
			
		// Die User-�bersicht
			// Dreieck platzieren
				// Rechts
				$userRight = $("#user").width() + 10;
				document.getElementById('user_1').style.right = $userRight + "px";
				$("#user_1").animate( {right: $userRight} , 1 );
				// H�he
				$userSize = $("#user").height() + 10;
				$userSize1 = $userSize + "px solid transparent";
				document.getElementById('user_1').style.borderBottom = $userSize1;
				$userSize2 = $userSize + "px solid rgba(24, 24, 24, 0.95)";
				document.getElementById('user_1').style.borderRight = $userSize2;
			// Schr�ge Linie
				$("#user_2").height($userSize + 5);
				$("#user_2").width($userSize);
				// Damit man die "ecke" nicht sieht
				document.getElementById('user_2').style.top = "-2";
				document.getElementById('user_2').style.left = "1";
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