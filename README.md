# Abiball-Kartenbestellungen
Eine Website zur Kartenbestellung &amp; Organisation von Abibällen


## Idee und Entwicklung
Diese Website wurde erstellt, um den Organisationsaufwand für den diesjährigen Abiball weitestgehend in Grenzen zu halten
und um auf das ewige Listenführen verzichten zu können. Deshalb habe ich eine Website entwickelt,
auf der die Karten bestellt werden können und ein paar Informationen kundegetan werden können.
Angefangen habe ich mit einem rohen Login-System ohne jegliches Design, dazu kam dann die Kartenbestellung an sich.
Im Laufe der Zeit kamen das Design, die Möglichkeit, Nutzer zu erstellen und ein Blog-System dazu.
Anschließend wurde das Gesamte noch zu einem CMS umgebaut.

## Voraussetzungen & Installation
Dieses Paket benötigt einen Server mit:
-	PHP5-Unterstützung 
-	Eine MySQL-Datenbank (im Optimalfall leer; alle Datenbanken haben das Präfix abi_)
-	Eine HTTPS-Domain auf der der Inhalt läuft (dies muss ein Root-Verzeichnis sein)
-	Eine Domain, auf die zugegriffen werden soll

## Zur Installation müssen Sie folgende Schritte vollführen:
1.	Hochladen

    Laden Sie die Dateien auf Ihren Server
2.	Datenbank & Webseitendaten eingeben

    Rufen Sie diesen Pfad auf und geben Sie ihre Daten ein. Bitte beachten Sie, dass diese Daten im Nachhinein nicht mehr geändert werden können.
    
    Hinweis: Geben Sie bitte keine Anführungszeichen “ oder Apostrophe ‘ ein. Bitte passen Sie auch auf, dass niemand anderes die Daten vor Ihnen eingibt ;-)
3.	Domains verbinden

    Die Domain muss auf den Ordner abiball gelegt werden (mit SSL-Verschlüsselung)
4.	Anmelden

    Melden Sie sich mit den in Schritt 2 angegebenen Daten an und verwalten Sie die Website.
    Oben rechts erhalten Sie Zugriff auf die Administrator-Konsole, der Rest sollte selbsterklärend sein.

## Seitentexte bearbeiten
Als höchster Administrator haben Sie die Möglichkeit, die Seitentexte zu bearbeiten.
Gehen Sie dafür in die Administrations-Konsole und ganz unten auf „Die Seitentexte bearbeiten“ und wählen Sie das entsprechende Element aus.

Es können fast immer die Format-Tags aus dem Blogsystem verwendet werden – HTML-Tags werden nicht unterstützt!

Vergessen Sie nicht das Captcha und ihr Admin-Passwort (bei der Einrichtung eingestellt).

## Neue Nutzer
Neue Nutzer werden vom Admin angelegt (aus rechtlichen Gründen) und müssen dann ihre E-Mail-Adresse bestätigen.

Dafür erhalten diese per Mail einen Link. Wenn dies geschehen ist, muss der Nutzer noch von einem Administrator freigeschaltet werden.

## Mobile Seite
Eine für mobile Geräte optimierte Version der Seite (touch-freundlich und mit wenig Datenverbrauch) erreichen Sie unter [public domain]/mobil.html.

Auf diese wird bei zu niedriger Auflösung auch umgeleitet.

Diese Seite ist nicht sonderlich qualitativ gestaltet oder ähnliches.

## Bestellprozess
In der ersten Runde kann jeder Nutzer 4 Karten für sich bestellen – die läuft von Anfang an.

Sobald diese vorbei ist, können Administratoren weitere Karten freigeben – diese werden an einem zufälligen Zeitpunkt
an dem gewählten Tag freigeschaltet. Hier kann sich dann jeder Nutzer Karten buchen, jedoch immer nur zwei auf einmal.
Zudem hat jeder Nutzer nur eine Bestellung pro Tag.

Hinweis: Noch nicht implementiert ist die Funktion, Preise (50€) und Kartenmengen zu konfigurieren.

## Rechte & Werbung
Die Website benutzt ausschließlich selber produziertes Material oder solches, dass Lizenzfrei (oder unter freien Lizenzen) zu haben ist.

Hinweise dazu finden Sie im Impressum.


## Code-Qualität
Die Code-Qualität ist recht mies, da ich mir mit diesem Projekt HTML & PHP beigebracht habe.

Verbesserungen sind gerne gesehen, viel Spaß dabei ;-P

