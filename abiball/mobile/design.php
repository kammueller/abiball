<?php
/*
 * DESIGN
 * Das Design in seiner Komplettheit :D
 * als Beispielseite für Google etc
 */
$Vorname = "Test";
$Nachname = "Beispiel";

include ('design_alpha.inc.php');
include ('design_beta.inc.php');
echo ('
			<h1 id="title">Herzlich Willkommen!</h1>
			<p>
				Auf unserer Website zur Bestellung der Karten f&uuml;r den Abiball am LMGU 2015.<br>
				Der Inhalt f&uuml;llt sich &uuml;ber die n&auml;chsten Tage noch, momentan geht es mehr darum, die Logik zum Laufen zu bringen.<br>
				<br>
				Unter <b>Kartenbestellung</b> wird man nat&uuml;rlich die Karten bestellen, aber auch tauschen k&ouml;nnen. Eventuell wird hier auch noch eine Sitzplatzreservierung umgesetzt.<br>
				Unter <b>Location</b> werdet ihr (sobald wir eine haben) die Location des Abiballs inklusive Anfahrt etc. finden<br>
				Unter <b>Men&uuml;</b> werdet ihr sehen, was es zu Essen geben wird.<br>
				Unter <b>Neuigkeiten</b> posten die Administratoren kurze News, damit ihr auf dem Laufenden bleiben k&ouml;nnt.<br>
				Und was bei <b>Impressum</b> zu finden ist, sollte selbsterkl&auml;rend sein...<br>
			</p>
			<br><br>
			<h1 id="title">&Uuml;berschrift</h1>
			<p>
				Ich bin ein Text, der hier blo&szlig; als Test steht.<br>
				<span id="a">Ich wei&szlig; nicht, ob ich hier stehen bleibe oder nicht.</span><br>
				Das werden wir dann sehen. Oder eben auch nicht...<br>
			</p>
			<br><br> ');
include ('design_gamma.inc.php');

?>