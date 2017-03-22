// Bloß,  Wenn man zugriff hat

function logged() {		
		// Footer Zentrieren
        var $footerLeft = ($(document).width() - 827 ) / 2;
		document.getElementById('footer').style.left = $footerLeft + "px";
		
		// Mesage fade out
		$("#wrapper").delay(5000).fadeOut();
}

function footerRebuild() {
    // wirklicher Ersatz
    $("#footer").width($("#footer").width());
    $footerLeft = ($(document).width() - $("#footer").width() )/2;
    document.getElementById('footer').style.left = $footerLeft + "px";

    return true;
}