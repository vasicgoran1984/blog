<?php

    class ProfilModel {
        
        public function __construct(){}        
        
        /*
         * Snimi sliku korisnika
         */
        public function snimiSlikuKorisnika($id_korisnika, $slika) {
            global $konekcija;
            $upit = "UPDATE korisnici SET slika_korisnika = '$slika' WHERE id = $id_korisnika";
            return $konekcija->query($upit);
        }
        
        /*
         * Prikazi logovanog korisnika
         */
        public function prikaziKorisnika($id_korisnika) {
            global $konekcija;
            $upit = $konekcija->query("SELECT id, ime, prezime, korisnicko_ime, email, slika_korisnika FROM korisnici WHERE id = '".$id_korisnika."' ");
            return $upit->fetch_row();
        }
        
        /*
         * Prikazi korisnika po ID-u
         */
        public function PrikaziKorisnikaPoIdu($id_korisnika) {
            global $konekcija;
            $upit = $konekcija->query("SELECT id, ime, prezime, korisnicko_ime, email, slika_korisnika FROM korisnici WHERE id = '".$id_korisnika."' ");
            return $upit->fetch_assoc();
        }
        
        /*
         * Edit korisnika
         */
        public function EditKorisnika($id_korisnika, $ime, $prezime, $email) {
            global $konekcija;
            $upit = "UPDATE korisnici SET 
                    ime      = '$ime',
                    prezime  = '$prezime',
                    email    = '$email'
                    WHERE id = $id_korisnika";
            return $konekcija->query($upit);
        }
        
        /*
         * Obrisi sliku korisnika
         */
        public function obrisiSliku($id_korisnika) {
            global $konekcija;
            $upit = "UPDATE korisnici SET 
                     slika_korisnika = ''
                     WHERE id = $id_korisnika";
            return $konekcija->query($upit);
        }
    }
