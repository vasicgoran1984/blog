<?php

    class RegistrujKorisnika {
       
        public function __construct(){}
        
        /*
         * Registruj novog korisnika
         */
        public function registrujNovogKorisnika($ime, $prezime, $korisnicko_ime, $email, $hash) {
            global $konekcija;
            $upit = "insert into korisnici values ('', '".$ime."', '".$prezime."', '".$korisnicko_ime."', '".$email."', '".$hash."', '')";
            return $konekcija->query($upit);
        }
        
        /*
         * Provjeri korisnicko ime
         */
        public function provjeriKorisnickoIme($korisnicko_ime) {
            global $konekcija;
            $upit = $konekcija->query("SELECT korisnicko_ime FROM korisnici WHERE korisnicko_ime = '".$korisnicko_ime."' ");
            return $upit->fetch_row();
        }
        
        /*
         * Provjera da li je korisnicko ime slobodno
         */
        public function SlobodnoKorisnickoIme($korisnicko_ime) {
            global $konekcija;
            $upit = $konekcija->query("SELECT korisnicko_ime FROM korisnici WHERE korisnicko_ime = '".$korisnicko_ime."' ");
            return $upit->fetch_row();
        }
        
        /*
         * Loguj korisnika
         */
        public function logujKorisnika($korisnicko_ime, $hash) {
            global $konekcija;
            $upit = $konekcija->query("SELECT id, ime, prezime, korisnicko_ime, email, slika_korisnika FROM korisnici WHERE korisnicko_ime = '".$korisnicko_ime."' AND password = '".$hash."' ");
            return $upit->fetch_row();
        }
        
        /*
         * Provjeri password
         */
        public function provjeriPassword($korisnicko_ime, $hash) {
            global $konekcija;
            $upit = $konekcija->query("SELECT korisnicko_ime, password FROM korisnici WHERE korisnicko_ime = '".$korisnicko_ime."' AND password = '".$hash."' ");
            return $upit->fetch_row();
        }
        
        /*
         * Promijeni password
         */
        public function promijeniPassword($korisnicko_ime, $hash) {
            global $konekcija;
            $upit = "UPDATE korisnici SET
                     password = '$hash'
                     WHERE korisnicko_ime = '$korisnicko_ime' ";
            return $konekcija->query($upit);
        }
    }
