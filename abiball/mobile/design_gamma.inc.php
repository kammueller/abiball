<?php
/*
 * DESIGN - TEIL 3
 * Gibt den Schluss des BODYs aus, schlie�t HTML
 * danach darf nichts mehr ausgegeben werden!
 * 
 * BEN�TIGT $Vorname und $Nachname!
 */
echo ('
			
	
<!-- FOOTER -->
	<p>
		<br><br><br> <!-- Platzhalter, damit alles lesbar ist -->
	</p>
	<div id="footer">
		Du bist eingeloggt als <b>'.$Vorname.' '.$Nachname.'</b>.<br>
		<a href="/mobile/profil.php" id="user_link">Mein Account</a> &bull; <a href="/index.php" id="user_link">Desktop-Version</a> &bull; <a href="/mobile/logout.php" id="user_link">Abmelden</a>
	</div>
	
</body>
</html>');

