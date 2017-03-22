<?php
/*
 * DESIGN - TEIL 2
 * Schließt HEAD, gibt den ersten Teil des BODYs aus
 * danach soll der Seiteninhalt eingeügt werden
 */
 
echo ('	
</head>


<body>

<!-- HEADER -->
	<img src="/img/mobileHeader.PNG" id="header" height="100%" width="auto">
	
	<div id="menueHeader" onclick="menue();">
		<p id="menueTitle">Navigation</p>
	</div>
	<div id="menueContent">
		<p id="menueList" onclick="document.location = \'/mobile/home.php\'">Home</p>
		<p id="menueList" onclick="document.location = \'/mobile/karte\'">Kartenbestellung</p>
		<p id="menueList" onclick="document.location = \'/mobile/location.php\'">Location</p>
		<p id="menueList" onclick="document.location = \'/mobile/essen.php\'">Men&uuml;</p>
		<p id="menueList" onclick="document.location = \'/mobile/blog.php\'">Neuigkeiten</p>
		<p id="menueList" onclick="document.location = \'/mobile/about.php\'">Impressum</p>
	</div>
	

<!-- CONTENT -->
		');

