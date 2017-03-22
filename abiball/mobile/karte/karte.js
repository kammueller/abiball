function chkFormular() {
      var $ret = true;
	  if ( document.Kartenbestellung.anz.value > 1) {
	  if ( (document.Kartenbestellung.VorN2.value == "") || (document.Kartenbestellung.NachN2.value == "") ) {
		$("#namen").slideDown(100);
		$ret =  false; }
		if ( document.Kartenbestellung.anz.value > 2) {
		if ( (document.Kartenbestellung.VorN3.value == "") || (document.Kartenbestellung.NachN3.value == "") ) {
		  $("#namen").slideDown(100);
		  $ret =  false; }
		  if ( document.Kartenbestellung.anz.value > 3) {
		  if ( (document.Kartenbestellung.VorN4.value == "") || (document.Kartenbestellung.NachN4.value == "") ) {
		    $("#namen").slideDown(100);
		    $ret =  false; }
		  }
	    }
	  }
	  return $ret;
	}
	

function KommiWeg() {
	if (document.Kartenbestellung.kommi.value == "Hier kannst Du weitere Kommentare hinterlassen") {
		document.Kartenbestellung.kommi.value = "";
		document.Kartenbestellung.kommi.focus();}
	document.Kartenbestellung.kommi.style.color = "#000";
	document.Kartenbestellung.kommi.style.fontStyle = "normal";
	}