<?php

    class utisakKomentaraModel {
        public function __construct(){}        
            
        /*
         * Dodaj utisak na komentar
         */
        public function dodajUtisakNaKomentar($korisnik_id, $komentar_id, $utisak) {
            global $konekcija; 
            $upit = "INSERT INTO komentari_utisak VALUES ('', '".$korisnik_id."', '".$komentar_id."', '".$utisak."')";
            return $konekcija->query($upit);
        }
        /*
         * Postoji li utisak logovanog korisnika
         */
        public function postojiUtisakLogovanogKorisnika($korisnik_id, $komentar_id) {
            global $konekcija;
            $upit = $konekcija->query("SELECT id, korisnik_id, komentar_id
                                       FROM komentari_utisak
                                       WHERE korisnik_id = $korisnik_id
                                       AND komentar_id = $komentar_id.");
            return $upit->fetch_assoc();
        }
         /*
         * Resetuj utiska logovanog korisnika
         */
        public function promijeniPostojeciUtisak($korisnik_id, $komentar_id, $utisak) {
            global $konekcija;
            $upit = "UPDATE komentari_utisak SET 
                     utisak = $utisak
                     WHERE korisnik_id = $korisnik_id AND komentar_id = $komentar_id";
            return $konekcija->query($upit);
        }
        /*
         * Provjera da li postoji utisak za logovanog korisnika 
         */
        public function kojiUtisakKomentaraPostoji($korisnik_id, $komentar_id) {
            global $konekcija;
            $rezultat = $konekcija->query("SELECT komentari_utisak.id as komentari_utisak_id, komentari_utisak.utisak as utisak,
                                           komentari_utisak.komentar_id as komentari_utisak_komentar_id
                                           FROM komentari_utisak
                                           LEFT JOIN komentari
                                           ON komentari.id = komentari_utisak.komentar_id
                                           WHERE komentari_utisak.korisnik_id = $korisnik_id");
            for ($utisci = array(); $red = $rezultat->fetch_assoc(); $utisci[] = $red);
            return $utisci;
        }
    }