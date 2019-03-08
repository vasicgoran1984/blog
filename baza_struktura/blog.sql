CREATE TABLE korisnici(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ime VARCHAR(30) NOT NULL,
    prezime VARCHAR(30) NOT NULL,
    korisnicko_ime VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    `password` VARCHAR(64) NOT NULL,
    slika_korisnika VARCHAR(7)
);

CREATE TABLE clanci(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    korisnik_id INT(40),
    FOREIGN KEY (korisnik_id) REFERENCES korisnici(id),
    naslovna_slika VARCHAR(7),
    naslov_clanka VARCHAR(50),
    kratki_tekst VARCHAR(50),
    dugacki_tekst text,
    kljucne_rijeci VARCHAR (200),
    slug VARCHAR (30),
    objavljen Tinyint (1),
    datum_objave_clanka DATETIME
);

CREATE TABLE clanci_utisak(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    korisnik_id INT(40),
    FOREIGN KEY (korisnik_id) REFERENCES korisnici(id),
    clanak_id INT(40),
    FOREIGN KEY (clanak_id) REFERENCES clanci(id),
    utisak Tinyint (1)
);

CREATE TABLE komentari(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    korisnik_id INT(40),
    FOREIGN KEY (korisnik_id) REFERENCES korisnici(id),
    clanak_id INT(40),
    FOREIGN KEY (clanak_id) REFERENCES clanci(id),
    komentar text,
    datum_objave_komentara DATETIME
);

CREATE TABLE komentari_utisak(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    korisnik_id INT(40),
    FOREIGN KEY (korisnik_id) REFERENCES korisnici(id),
    komentar_id INT(40),
    FOREIGN KEY (komentar_id) REFERENCES komentari(id),
    utisak Tinyint (1)
);

