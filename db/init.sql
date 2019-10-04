CREATE TABLE IF NOT EXISTS `abi_0_kartenfreischalt`
(
    `timestamp`  INT(12) NOT NULL,
    `anzahl`     INT(3)  NOT NULL,
    `uebrig`     INT(3)  NOT NULL,
    `reserviert` INT(3)  NOT NULL,
    PRIMARY KEY (`timestamp`)
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `abi_admin`
(
    `user_id` INT(8)                                     NOT NULL,
    `rechte`  ENUM ('all','finance','announce','verify') NOT NULL,
    UNIQUE KEY `user_id` (`user_id`)
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `abi_bestellung`
(
    `BestellNr`    VARCHAR(12)           NOT NULL,
    `user_id`      INT(8)                NOT NULL,
    `karte1`       INT(8)                NOT NULL,
    `karte2`       INT(8)                NOT NULL,
    `karte3`       INT(8)                NOT NULL,
    `karte4`       INT(8)                NOT NULL,
    `Wunschkarten` INT(2)                NOT NULL,
    `Kommentar`    TEXT                  NOT NULL,
    `datum`        DATE                  NOT NULL,
    `Bezahlt`      ENUM ('true','false') NOT NULL  DEFAULT 'false',
    `BezAm`        DATE                            DEFAULT NULL COMMENT 'Bezahldatum',
    `admin_id`     INT(8)                          DEFAULT NULL,
    `BezArt`       ENUM ('bar','konto','sonstige') DEFAULT NULL COMMENT 'Art der Bezahlung',
    `BezKom`       VARCHAR(128)                    DEFAULT NULL COMMENT 'Genauere Beschreibung der Bezahlung',
    `mahnung`      DATE                            DEFAULT NULL COMMENT 'Versanddatum der letzten Mahnung (wenn keine: NULL)',
    PRIMARY KEY (`BestellNr`)
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `abi_blocked`
(
    `user_id`  INT(8) NOT NULL,
    `admin_id` INT(8) NOT NULL,
    `Grund`    TEXT   NOT NULL,
    `datum`    DATE   NOT NULL,
    UNIQUE KEY `user_id` (`user_id`)
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `abi_karten`
(
    `id`       INT(8)                        NOT NULL AUTO_INCREMENT,
    `user_id`  INT(8)                        NOT NULL,
    `karteNr`  ENUM ('1','2','3','4','edit') NOT NULL COMMENT 'Welche Nummer in der Bestellung',
    `Vorname`  VARCHAR(32)                   NOT NULL,
    `Nachname` VARCHAR(32)                   NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `abi_news`
(
    `id`        INT(8)      NOT NULL AUTO_INCREMENT,
    `user_id`   INT(8)      NOT NULL,
    `Titel`     VARCHAR(64) NOT NULL,
    `Teaser`    TEXT        NOT NULL,
    `Text`      TEXT        NOT NULL,
    `Timestamp` INT(20)     NOT NULL,
    `edit_id`   INT(20)     NOT NULL,
    `edit_time` INT(20)     NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `abi_tische`
(
    `Nummer`  int(2) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `Plaetze` int(2)             NOT NULL,
    `Frei`    int(2)             NOT NULL
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `abi_reservierung`
(
    `user_id`    INT(8)  NOT NULL,
    `ablauf`     INT(20) NOT NULL COMMENT 'timestamp',
    `anz`        INT(1)  NOT NULL COMMENT 'Wie viele Karten werden reserviert? 1 oder 2?',
    `bestellung` INT(20) NOT NULL COMMENT 'timestamp des Kartenschubs',
    PRIMARY KEY (`user_id`)
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8 COMMENT ='Speichert, wenn sich gerade wer Karten holen will, um Zeitlimit durchzusetzen';

CREATE TABLE IF NOT EXISTS `abi_session`
(
    `id`      TEXT    NOT NULL,
    `user_id` INT(8)  NOT NULL,
    `time`    INT(10) NOT NULL,
    UNIQUE KEY `user_id` (`user_id`)
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `abi_user`
(
    `id`           INT(8) UNSIGNED                                   NOT NULL AUTO_INCREMENT,
    `password`     VARCHAR(64)                                       NOT NULL,
    `Vorname`      VARCHAR(32)                                       NOT NULL,
    `Nachname`     VARCHAR(32)                                       NOT NULL,
    `verified`     ENUM ('false','mail','true','geblockt','newMail') NOT NULL,
    `Mail`         VARCHAR(64)                                       NOT NULL,
    `reservierend` ENUM ('true','false')                                      DEFAULT NULL,
    `failed`       INT(1)                                            NOT NULL DEFAULT '0' COMMENT 'Falsche Login-Versuche in Reihe',
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`Vorname`, `Nachname`)
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `abi_verify`
(
    `user_id` INT(8)      NOT NULL,
    `hash`    VARCHAR(32) NOT NULL,
    UNIQUE KEY `user_id` (`user_id`)
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

TRUNCATE TABLE `abi_0_kartenfreischalt`;
TRUNCATE TABLE `abi_admin`;
TRUNCATE TABLE `abi_bestellung`;
TRUNCATE TABLE `abi_blocked`;
TRUNCATE TABLE `abi_karten`;
TRUNCATE TABLE `abi_news`;
TRUNCATE TABLE `abi_reservierung`;
TRUNCATE TABLE `abi_session`;
TRUNCATE TABLE `abi_tische`;
TRUNCATE TABLE `abi_user`;
TRUNCATE TABLE `abi_verify`;

INSERT INTO `abi_admin` (`user_id`, `rechte`)
VALUES (1, 'all');

INSERT INTO `abi_0_kartenfreischalt` (`timestamp`, `anzahl`, `uebrig`, `reserviert`)
VALUES (100, 0, 20, 0);

