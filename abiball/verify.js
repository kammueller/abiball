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