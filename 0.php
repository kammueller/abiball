<!DOCTYPE html>
<html>
<head>
	<title>Seitenerstellung</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="author" content="Matthias Kammueller">
</head>
<body>
	<h1>Herzlich Willkommen zu Ihrem Abiball-Kartenbestell-System!</h1> A
	<form action="1.php" method="post">
		Um Ihre Website einzurichten, ben&ouml;tigen wir zu erst die Daten ihrer Datenbank-Verbindung:<br>
		<table>
			<tr><td>Host: </td><td> <input type="text" name="host" placeholder="Host der Datenbank (z.B. rdbms.strato.de)" size="64"></td></tr>
			<tr><td>User: </td><td> <input type="text" name="user" placeholder="Anmeldename bei der Datenbank (z.B. U123456789)" size="64"></td></tr>
			<tr><td>Datenbank: </td><td> <input type="text" name="db" placeholder="Datenbank-Name (z.B. DB123456789)" size="64"></td></tr>
			<tr><td>Passwort: </td><td> <input type="text" name="pass" placeholder="Passwort der Datenbank" size="64"></td></tr>
		</table>
		<input type="submit" value="Verbindung herstellen">
	</form>
</body>
</html>