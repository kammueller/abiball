	
// Formularvorgaben löschen
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
