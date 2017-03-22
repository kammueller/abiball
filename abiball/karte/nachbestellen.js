function chkFormular() {
	  var $ret = true;
	  if ( (document.Kartenbestellung.VorN1.value == "") || (document.Kartenbestellung.NachN1.value == "") ) {
		$("#namen").slideDown(100);
		$ret =  false; }
		if ( document.Kartenbestellung.anz.value == 2) {
		  if ( (document.Kartenbestellung.VorN2.value == "") || (document.Kartenbestellung.NachN2.value == "") ) {
		  $("#namen").slideDown(100);
		  $ret =  false;
		  }
	  }
	  return $ret;
	}