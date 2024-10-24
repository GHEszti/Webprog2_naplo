ALTER DATABASE feladat CHARACTER SET utf8 COLLATE utf8_general_ci;

create TABLE diak(
    id int not null AUTO_INCREMENT,
    nev varchar(100) not null,
    osztaly varchar(100) not null,
    fiu  boolean not null,
    PRIMARY KEY(id)
);
create TABLE targy(
    id int not null AUTO_INCREMENT,
    nev varchar(300) not null,
    kategoria varchar(100),
    PRIMARY KEY(id)
);

create TABLE jegy(
    id int not null AUTO_INCREMENT,
    diakid int not null,
    datum  DATETIME not null DEFAULT CURRENT_TIMESTAMP,
    ertek tinyint CHECK (ertek > 0 and ertek < 6),
    tipus varchar(100),
    targyid int not null,
    PRIMARY KEY(id),
    FOREIGN KEY (diakid) REFERENCES diak(id),
    FOREIGN KEY (targyid) REFERENCES targy(id)
);

CREATE TABLE felhasznalo (
  `id` int NOT NULL AUTO_INCREMENT,
  `nev` varchar(200) NOT NULL,
  `felhasznalo_nev` varchar(45) NOT NULL UNIQUE,
  `jelszo` varchar(40) NOT NULL,
  `jogosultsag` varchar(10) NOT NULL,
  `aktiv` boolean DEFAULT true,
  `inaktivalas_datum` datetime not null DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;