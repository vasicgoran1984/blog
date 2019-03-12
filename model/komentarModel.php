<?php

    class KomentarModel {
        public function __construct() {}
        
        /*
         * Dodaj komentar
         */
        public function dodajKomentar($korisnik_id,  $clanak_id, $noviKomentar, $datum_objave_komentara) {
            global $konekcija;
            $upit = "INSERT INTO komentari VALUES ('', '".$korisnik_id."', '".$clanak_id."', '".$noviKomentar."', '".$datum_objave_komentara."')";
            return $konekcija->query($upit);
        }
        
        /*
         * Clanak sa komentarima
         */
        public function clanakSaKomentarima($clanak_id, $korisnik) {
            global $konekcija;
            $rezultat = $konekcija->query("SELECT K.id as komentar_id, K.komentar, K.datum_objave_komentara, KU.utisak,
                                           K.korisnik_id, ime, prezime
                                           FROM komentari K
                                           LEFT JOIN komentari_utisak KU
                                           ON KU.komentar_id = K.id AND KU.korisnik_id = $korisnik
                                           LEFT JOIN korisnici KO
                                           ON K.korisnik_id = KO.id
                                           WHERE K.clanak_id = $clanak_id");
            for($komentari = array(); $red = $rezultat->fetch_assoc(); $komentari[] = $red);
            return $komentari;
        }
        
        /*
         * Procitaj clanak sa komentarima
         */
        public function procitajClankakSaKomentarima($clanak_id) {
            global $konekcija;
            $rezultat = $konekcija->query("SELECT K.id as komentar_id, K.komentar, 
                                           K.korisnik_id, C.naslovna_slika, C.naslov_clanka, C.kratki_tekst, C.dugacki_tekst,
                                           C.datum_objave_clanka, ime, prezime, datum_objave_komentara
                                           FROM komentari K
                                           LEFT JOIN clanci C
                                           ON K.clanak_id = C.id
                                           LEFT JOIN korisnici KO
                                           ON C.korisnik_id = KO.id
                                           WHERE C.id = $clanak_id");
            for($komentari = array(); $red = $rezultat->fetch_assoc(); $komentari[] = $red);
            return $komentari;
        }
        
        /*
         * Obrisi komentar po Id-u clanka
         */
        public function obrisiKomentarPoIduClanka($clanak_id) {
            global $konekcija;
            $query = "DELETE FROM komentari WHERE clanak_id = $clanak_id";
            return $konekcija->query($query);
        }
    }