// NEUE MAIL
	//Ein-/Ausblenden
		function mail() {
			$('#mail').slideToggle();
		}
		
	// Formular-Check
		function chkMail() {
		  $ret = true;
		  if ( (document.changeMail.newMail.value == "")  || (document.changeMail.newMail.value == "neue Mail-Adresse") || (document.changeMail.newMail.value.indexOf("@") == -1) ) {
			$("#mailA").slideDown(100);
			$ret = false;
		  } else { $("#mailA").slideUp(100); }
		  return $ret;
		}
		
	// Feld leeren
	function LeerenMail() {
		if(document.changeMail.newMail.value == "neue Mail-Adresse") {
			document.changeMail.newMail.value = "";
			document.changeMail.newMail.focus();}
		document.changeMail.newMail.style.color = "#000";
		document.changeMail.newMail.style.fontStyle = "normal";
		}
		
// NEUES PASSWORT
	//Ein-/Ausblenden
		function passwort() {
			$('#passwort').slideToggle();
		}
		
	// Formular-Check
		function chkPass() {
		  $ret = true;
		  if ( document.changePass.newPass1.value == "" ) {
			$("#eins").slideDown(100);
			$ret =  false;
		  } else { $("#eins").slideUp(100); }
		  var laenge = (document.changePass.newPass1.value.length > 7);
		  if (laenge == false) {
			$("#zwei").slideDown(100);
			$ret =  false;
		  } else { $("#zwei").slideUp(100); }
		  var derSatz =  document.changePass.newPass1.value;
		  var Suche = /\d/g;
		  var Ergebnis = Suche.test(derSatz);
		  if (Ergebnis == false) {
			$("#drei").slideDown(100);
			$ret =  false;
		  } else { $("#drei").slideUp(100); }
		  if ( ( document.changePass.newPass1.value.toUpperCase() == document.changePass.newPass1.value ) || ( document.changePass.newPass1.value.toLowerCase() == document.changePass.newPass1.value ) ) {
			$("#vier").slideDown(100);
			$ret =  false;
		  } else { $("#vier").slideUp(100); }
		  
			
		  if ( document.changePass.newPass2.value != document.changePass.newPass1.value ) {
			$("#fuenf").slideDown(100);
			$ret =  false;
		  } else { $("#fuenf").slideUp(100); }
		  
		  return $ret;
		}
		  
