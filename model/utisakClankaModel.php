<?php

    class utisakClankaModel {
        public function __construct(){}        
            
        /*
         * Dodaj utisak na clanak
         */
        public function dodajUtisakNaClanak($korisnik_id, $clanak_id, $utisak) {
            global $konekcija;
            $upit = "INSERT INTO clanci_utisak VALUES ('', '".$korisnik_id."', '".$clanak_id."', '".$utisak."')";
            return $konekcija->query($upit);
        }
        
        /*
         * Postoji li utisak logovanog korisnika
         */
        public function postojiUtisakLogovanogKorisnika($korisnik_id, $clanak_id) {
            global $konekcija;
            $upit = $konekcija->query("SELECT id, korisnik_id, clanak_id
                                       FROM clanci_utisak
                                       WHERE korisnik_id = $korisnik_id
                                       AND clanak_id = $clanak_id.");
            return $upit->fetch_assoc();
        }
        
        /*
         * Resetuj utiska logovanog korisnika
         */
        public function promijeniPostojeciUtisak($korisnik_id, $clanak_id, $utisak) {
            global $konekcija;
            $upit = "UPDATE clanci_utisak SET 
                     utisak = $utisak
                     WHERE korisnik_id = $korisnik_id AND clanak_id = $clanak_id";
            return $konekcija->query($upit);
        }
        
        /*
         * Provjera da li postoji utisak za logovanog korisnika 
         */
        public function kojiUtisakPostoji($korisnik_id, $clanak_id) {
            global $konekcija;
            
            $upit = "SELECT utisak FROM clanci_utisak
                     WHERE clanak_id = $clanak_id.";
            
            if ($korisnik_id != '') {
                $upit .= " AND korisnik_id = $korisnik_id.";
            }
            $rezultat = $konekcija->query($upit);
            for ($utisci = array(); $red = $rezultat->fetch_assoc(); $utisci[] = $red);
            return $utisci;
        }
        
        /*
         * Prebroj pozitivne utiske clanka
         */
        public function prebrojPozitivneUtiskeClanka($clanak_id) {
            global $konekcija;
            $rezultat = $konekcija->query("SELECT COUNT(utisak) as pozitivni
                                           FROM clanci_utisak
                                           WHERE utisak = 1 
                                           AND clanak_id = $clanak_id.");

            return $rezultat->fetch_object()->pozitivni;
        }
        
        /*
         * Prebroj pozitivne utiske clanka
         */
        public function prebrojNegativneUtiskeClanka($clanak_id) {
            global $konekcija;
            $rezultat = $konekcija->query("SELECT COUNT(utisak) as negativni
                                           FROM clanci_utisak
                                           WHERE utisak = 2 
                                           AND clanak_id = $clanak_id.");

            return $rezultat->fetch_object()->negativni;
        }
    }