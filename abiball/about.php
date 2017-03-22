<?php
include ('back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('login.php'); exit; }

include('back-end/txt/pages/about.php'); // Text

// Content
	
	require ('back-end/design_alpha.inc.php');
	require ('back-end/design_beta.inc.php');
	
	echo ('
	<div style="text-align: center"><h1>Impressum</h1>'
        .encode($bausteine[0]).'
    </div>
	<br><br>
	    '.encode($bausteine[1]).'
	<br><br>
	<h1>Ansprechpartner</h1>
        '.encode($admin_vor).' '.encode($admin_nach).'<br>
        '.encode($admin_post).'<br>
        Mail: <a href="mailto:'.encode(admin_mail).'">'.encode(admin_mail).'</a><br>
	<br><br>
	<h1>Credits</h1>
	<table>
		<tr><td>Entwicklung</td><td>Matthias Kammüller</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Design</td><td>Nina Koeder &bull; Matthias Kammüller &bull; Nicolas Schmieder</td></tr>
		<tr><td>Login-Hintergrund</td><td>'.encode($bausteine[2]).'</td></tr>
		<tr><td>Hintergrund</td><td>'.encode($bausteine[3]).'</td></tr>
		<tr><td>Navigations-BG</td><td>Kaz (pixabay) - http://pixabay.com/de/metall-silber-edelstahl-316803/</td></tr>
		<tr><td>Font: Arapey</td><td>Tipo (1001fonts) - http://www.1001fonts.com/arapey-font.html</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Security-Advisor</td><td>Nicolas Grebe</td></tr>
		<tr><td>Beta-Tester</td><td>Matthias Kammüller &bull; Nicolas Grebe &bull; Nina Koeder &bull; Nicolas Schmieder</td></tr>
		<tr><td>Rettung in der Not</td><td><a href="//google.de">Google</a> &bull; <a href="//de.selfhtml.org/">SelfHTML</a> &bull; <a href="//www.css4you.de/">css4you</a> &bull; <a href="http://api.jquery.com/">JQuery</a> &bull; <a href="http://de2.php.net/manual/en/index.php">PHP.net</a> &bull; <a href="https://github.com/Synchro/PHPMailer">PHPMailer</a> &bull; <a href="http://fpdf.org/">fPDF<a></td></tr>
	</table>
	<br><br>
	
	'.encode($bausteine[4]).'

	');
	
	include ('back-end/design_gamma.inc.php');
	
