<?php
/**
 * MAIL
 * Die verschiedenen Mail-Texte
 * beginnend mit "Hallo [Vorname], ...", endend mit den angegebenen Daten
 * @TODO bearbeitung bauen
 */

require __DIR__ . '../../../vendor/autoload.php';

/** @var STRING $absender
 * Der Absender, automatisch aus Header-Data bestimmen!
 */
$absender = "Abiball 2015 LMGU <webmaster@lmgu-abiball.de>"; // $absender = header." <".admin_mail.">";



/** @var STRING $mail_newmail_old
 * Änderung der E-Mail-Adresse, Benachrichtigung an die alte Mail-Adresse
 */
$mail_newmail_old = "Du wolltest Deine E-Mail-Adresse aktualisieren.%nZ%Hiermit wirst Du benachrichtigt, dass dies geschehen ist.%nZ%%nZ%%k*Diese Mail überrascht Dich?*k% - Bitte informiere uns umgehend!";

/** @var STRING $mail_newmail_new
 * Änderung der E-Mail-Adresse, Benachrichtigung an die neue Mail-Adresse
 * %userlink% muss vorhanden sein, um Link zur Verifizierung einzufügen
 */
$mail_newmail_new = "Du wolltest Deine E-Mail-Adresse aktualisieren.%nZ%Bitte bestätige Deine E-Mail-Adresse und die unten angegeben Daten, in dem Du den folgenden Link anklickst:%nZ%%userlink% %nZ%Bis du diese E-Mail bestätigt hast, hast du keinen Zugriff auf diese Website.%nZ%%nZ%%k*Dies Mail überrascht dich?*k% - Bitte informiere uns umgehend!";

/** @var STRING $mail_newmail_old_admin
 * Admin hat Mailadresse geändert - Benachrichtigung an alte Adresse
 */
$mail_newmail_old_admin = "Hiermit teilen wird Dir mit, dass ein Administrator Deine E-Mail-Adresse geändert hat.%nZ%%nZ%%k*Diese Mail überrascht Dich?*k% - Bitte antworte umgehend!";

/** @var STRING $mail_newmail_new_admin
 *  Änderung der E-Mail-Adresse durch Admin, Benachrichtigung an die neue Mail-Adresse
 * %userlink% muss vorhanden sein, um Link zur Verifizierung einzufügen
 */
$mail_newmail_new_admin = "Du wolltest deine E-Mail-Adresse aktualisieren.%nZ%Bitte bestätige Deine E-Mail-Adresse und die unten angegeben Daten, in dem Du den folgenden Link anklickst:%nZ%%userlink% %nZ%Bis Du diese E-Mail bestätigt hast, hast Du keinen Zugriff auf diese Website.%nZ%%nZ%%k*Diese Mail überrascht Dich?*k% - Bitte antworte umgehend!";



/** @var STRING $mail_newpass
 * Änderung des Passwortes
 */
$mail_newpass = "Du wolltest Dein Passwort aktualisieren.%nZ%Hiermit wirst Du benachrichtigt, dass dies geschehen ist.%nZ%%k*Diese Mail überrascht Dich?*k% - Bitte informiere uns umgehend!";

/** @var STRING $mail_newpass_admin
 * Admin hat Passwort geändert
 * %GeneriertesPasswort% muss vorkommen!
 */
$mail_newpass_admin = "Hiermit teilen wir Dir mit, dass ein Administrator Dein Passwort geändert hat.%nZ%Es lautet nun %f*%GeneriertesPasswort%*f%. Bitte ändere Dies beim nächsten Login unter Ddeinem Profil.%nZ%%nZ%%k*Dies Mail überrascht Dich?*k% - Bitte weise uns darauf hin!%nZ%%nZ%Aus Sicherheitsgründen wird dieses Passwort zufallsgeneriert und auch dem Admin nicht angezeigt. Da es jedoch unverschlüsselt übermittelt worden ist, solltst Du es zeitnah änern!";



/** @var STRING $mail_verify
 * Mailadresse muss bestätigt werden
 */
$mail_verify = "Vielen Dank für Deine Anmeldung für lmgu-abiball.de%nZ%%nZ%Bitte bestätige Deine E-Mail-Adresse und die unten angegeben Daten, in dem Du den folgenden Link anklickst:%nZ%%userlink%%nZ%%nZ%%nZ%Dein Abiball-Team";

/** @var STRING $mail_freischalten
 * Wenn ein Nutzer bestätigt wird
 */
$mail_freischalten = "Vielen Dank für Deine Anmeldung für lmgu-abiball.de%nZ%%nZ%Wir wollen Dir mitteilen, dass hiermit Dein Account bestätigt wurde. Du hast jetzt vollen Zugriff auf die Website.%nZ%Gehe auf www.lmgu-abiball.de, um Dich anzumelden.%nZ%%nZ%%nZ%Dein Abiball-Team";

/** @var STRING $mail_blockieren
 * Wenn ein Nutzer blockiert wird
 * %Begründung% muss verwendet werden
 */
$mail_blockieren = "Leider müssen wir Dir mitteilen, dass Dein Account auf lmgu-abiball.de gesperrt wurde.%nZ%Dabei wurde vom Administrator die folgende Begründung angegeben:%nZ%%k*%Begründung%*k% %nZ%%nZ%Falls Du mit dieser Sperrung nicht einverstanden bist, kannst Du einfach per Mail Einspruch erheben.%nZ%%nZ%Antworte dazu einfach auf diese E-Mail und erkläre, wieso Dein Account wieder freigeschaltet werden sollte.%nZ%%nZ%%nZ%Dein Abiball-Team";

/** @var STRING $mail_rehab
 * Blockade wurde aufgehoben
 */
$mail_rehab = "Gute Nachrichten: Die Sperrung Deines Accounts wurde soeben wieder aufgehoben.%nZ%Bitte entschuldige die Unannehmlichkeiten.%nZ%%nZ%Auf www.lmgu-abiball.de kannst Du dich nun wieder anmelden.%nZ%%nZ%%nZ%Dein Abiball-Team";

/** @var STRING $mail_accountdelete
 * Endgültiges Löschen des Accountes - ohne Daten am Ende
 */
$mail_accountdelete = "Leider müssen wir Dir mitteilen, dass Dein Account auf endgütig gelöscht wurde.%nZ%%nZ%Deine Daten wurden somit aus unseren Datenbanken gelöscht, wir haben nichts mehr von Dir gespeichert.%nZ%%nZ%Bei Fragen kannst Du dich gerne an uns wenden.%nZ%%nZ%%nZ%Dein Abiball-Team";



/** @var STRING $mail_newadmin
 * Wenn man als neuer Admin ernannt wird
 */
$mail_newadmin = "Herzlichen Glückwunsch! Du wurdest zum Administrator für lmgu-abiball.de ernannt.%nZ%Bitte beachte, dass Du mit diesem neuen Status verantwortungsvoll umgehen solltest.%nZ%%nZ%Nach dem Login kannst Du dir mit Klick auf &quot;Admin&quot; oben rechts ansehen, was Du nun für neue Rechte hast.%nZ%%nZ%%nZ%Dein Abiball-Team";

/** @var STRING $mail_noadmin
 * Entzug der Admin-Rechte
 */
$mail_noadmin = "Leider müssen wir Dir mitteilen, dass Deinem Account soeben die Administrations-Rechte entzogen wurden.%nZ%%nZ%Du kannst zwar weiterhin die Seite ganz normal benutzen, die Zugriffe auf andere User und Übersichten wurden Dir hiermit jedoch verboten.%nZ%%nZ%%nZ%Dein Abiball-Team";



/** @var STRING $mail_karten_rechnung
 * Der Text in der Mail, mit der die Rechnung als PDF kommt
 */
$mail_karten_rechnung = "Vielen Dank für Deine Kartenbestellung für den Abiball 2015 auf http://lmgu-abiball.de%nZ%%nZ%Im Anhang findest du Deine Rechnung und die Details. Alle Deine Rechnungen kannst Du auch bei Deinem Profil herunterladen.%nZ%%nZ%Falls Du Fragen hast, so wende Dich bitte an uns.%nZ%%nZ%%nZ%Dein Abiball-Team";

/** @var STRING $mail_zahlungda
 * Zahlung wurde erhalten
 * %RechnungsNummer% ist verwendbar
 */
$mail_zahlungda = "Hiermit teilen wir Dir mit, dass die Bezahlung Deiner Bestellung mit der Nummer %RechnungsNummer% heute eingegangen ist.%nZ%%nZ%Vielen Dank.%nZ%%nZ%%nZ%Dein Abiball-Team";

/** @var STRING $mail_karten_tausch
 * Karten wurden getauscht
 * %KartenID% und %NeuerInhaber% müssen verwendet werden
 */
$mail_karten_tausch = "Eine Deiner Karten, und zwar die mit der Nummer %KartenID%, wurde von Dir nun auf %NeuerInhaber% übertragen.%nZ%%nZ%Dies kannst Du natürlich jederzeit wieder rückgängig machen.%nZ%%nZ%Die aktualisierte Rechnung kannst Du dir nun bei deinem Profil herunterladen.%nZ%%nZ%%nZ%Dein Abiball-Team";

/** @var STRING $mail_kartenweg
 * Kartenbestellung wurde gelöscht
 * %RechnungsNummer% und %KartenZahl% stehen zur Verfügung
 */
$mail_kartenweg = "Leider müssen wir Dir mitteilen, dass Deine Kartenbestellung %RechnungsNummer% über %KartenZahl% Karten gelöscht worden ist.%nZ%Sie ist somit nicht mehr abgespeichert.%nZ%%nZ%Bei Fragen wende Dich bitte an uns.";

/** @var STRING $mail_zahlungweg
 * Zahlung wurde revidiert
 * %RechnungsNummer% und %Begründung% stehen zur Verfügung, letzteres muss verwendet werden
 */
$mail_zahlungweg = "Leider müssen wir Dir mitteilen, dass deine Zahlung für die Rechnung %RechnungsNummer% gelöscht wurde.%nZ%%nZ%Dabei wurde vom Administrator die folgende Begrüdung angegeben:%nZ%%k*%Begründung%*k% %nZ%%nZ%Falls dich das überrascht, so wende dich an uns!%nZ%%nZ%%nZ%Dein Abiball-Team ";

/** @var STRING $mail_mahnung
 * Mahnung: Geld noch nicht gezahlt
 * %RechnungsNummer% steht zur Verfügung
 */
$mail_mahnung = "Du hast bislang immer noch nicht deine Karten für die Bestellung %RechnungsNummer% gezahlt.%nZ%Bitte hole dies bald möglichst nach!%nZ%%nZ%Bei längerem Versäumen kann deine Bestellung gelöscht werden!";

/** @var STRING $mail_reset
 * Mailtext beim Reset der Seite - ohne die Daten am Ende
 */
$mail_reset = "Hiermit teilen wird Dir mit, dass die Website lmgu-abiball.de zurückgesetzt wird.%nZ%Vermutlich liegt das daran, dass der Abiball nun vorüber ist.%nZ%%nZ%Die Daten von Dir werden somit aus unseren Datenbanken gelöscht und Du verlierst den Zugriff.%nZ%%nZ%%nZ%Der Webmaster.";

                