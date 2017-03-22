//Formular überprüfen
	function chkPass() {
	  $ret = true;
	  
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

	
	// Mail
	  if ( (document.Anmeldung.mail.value == "")  || (document.Anmeldung.mail.value == "neue Mail-Adresse") || (document.Anmeldung.mail.value.indexOf("@") == -1) ) {
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
	  
	// AGB?!
	  if ( document.Anmeldung.agb.checked == false ) {
		document.getElementById("losgehts").style.fontWeight = "bold";
		document.getElementById("losgehts").style.color = "red";
		$ret = false;
	  } else { document.getElementById("losgehts").style.fontWeight = "normal";
		document.getElementById("losgehts").style.color = "black"; } 
	  
	  return $ret;
	}

	
