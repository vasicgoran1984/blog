<?php

    class ClanakModel {
        
        public function __construct(){}        
            
        /*
         * Dodaj clanak
         */
        public function dodajClanak($korisnik_id, $naslovna_slika, $naslov_clanka, $kratki_tekst, $dugacki_tekst, $kljucne_rijeci, $slug, $objavljen, $datum_objave_clanka) {
            global $konekcija;
            $upit = "INSERT INTO clanci VALUES ('', '".$korisnik_id."', '".$naslovna_slika."', '".$naslov_clanka."', '".$kratki_tekst."', '".$dugacki_tekst."', '".$kljucne_rijeci."', '".$slug."', '".$objavljen."', '".$datum_objave_clanka."')";
            return $konekcija->query($upit);
        }
        
        /*
         * Izmijeni clanak
         */
        public function IzmijeniClanak($clanak_id, $korisnik_id, $naslovna_slika, $naslov_clanka, $kratki_tekst, $dugacki_tekst, $kljucne_rijeci, $slug, $objavljen, $datum_objave_clanka) {
            global $konekcija;
            $upit = "UPDATE clanci SET 
                    korisnik_id         = '$korisnik_id',
                    naslovna_slika      = '$naslovna_slika',
                    naslov_clanka       = '$naslov_clanka',
                    kratki_tekst        = '$kratki_tekst',
                    dugacki_tekst       = '$dugacki_tekst',
                    kljucne_rijeci      = '$kljucne_rijeci',
                    slug                = '$slug',
                    objavljen           = '$objavljen',
                    datum_objave_clanka = '$datum_objave_clanka'
                    WHERE id = $clanak_id";
            return $konekcija->query($upit);
        }
        
        /*
         *  Izmijeni Sliku
         */
        public function IzmijeniSliku($zadnji_unos, $naslovna_slika) {
            global $konekcija;
            $upit = "UPDATE clanci SET 
                naslovna_slika   = '$naslovna_slika'
                WHERE id = $zadnji_unos";
            return $konekcija->query($upit);
        }
        
        /*
         * Prikazi clanak po Id-u
         */
        public function prikaziClanakPoIdu($clanak_id) {
            global $konekcija;
            $upit = $konekcija->query("SELECT * FROM clanci WHERE id = '".$clanak_id."' ");
            return $upit->fetch_assoc();
        }
         
        /*
         * Prikazi clanak po slug-u
         */
        public function prikaziClanakPoSlug($url){
            global $konekcija;
            $upit = $konekcija->query("SELECT * FROM clanci WHERE slug LIKE '%$url%' ");
            return $upit->fetch_assoc();
        }
        
        /*
         * Prikazi sve clanke drugih clanova
         */
        public function prikaziClankeDrugihClanova() {
            global $konekcija;
            $rezultat = $konekcija->query("SELECT * FROM clanci ");
            for($clanci = array(); $red = $rezultat->fetch_assoc(); $clanci[] = $red);
            return $clanci;
        }
               
        /*
         * Prikazi sve objavljene clanke
         */
        public function sviObjavljeniClanciPaginacija($po_strani, $stranica, $ime_prezime, $datum_od, $datum_do, $naslov_kljucna_rijec) {
            global $konekcija;
            
            if ($stranica <= 1) {
                    $start = 0;
            } else {
                    $start = ($stranica * $po_strani) - $po_strani;
            }
            
            $upit_brojac = "SELECT COUNT(*) ";
            $upit_podaci = "SELECT clanci.id AS clanak_id, naslovna_slika,
                            naslov_clanka, dugacki_tekst, ime, prezime, slug ";
            
            $upit = "FROM clanci
                     LEFT JOIN korisnici
                     ON clanci.korisnik_id = korisnici.id
                     WHERE objavljen = 1 ORDER BY clanci.id DESC";
            
            if ($ime_prezime != '') {
                $upit .= " AND ((CONCAT(korisnici.ime, ' ', korisnici.prezime) LIKE '%$ime_prezime%' 
                           OR CONCAT(korisnici.prezime, ' ', korisnici.ime) LIKE '%$ime_prezime%')
                           OR korisnici.ime LIKE '%$ime_prezime%'
                           OR korisnici.prezime LIKE '%$ime_prezime%')";
            }
            if ($datum_od != '') {
                $upit .= " AND (datum_objave_clanka >= '$datum_od 00:00:00')";
            }
            if ($datum_do != '') {
                $upit .= " AND (datum_objave_clanka <= '$datum_do 23:59:59')";
            }
            if ($naslov_kljucna_rijec != '') {
                $upit .= " AND ((CONCAT(clanci.kljucne_rijeci, ' ', clanci.naslov_clanka) LIKE '%$naslov_kljucna_rijec%' 
                           OR CONCAT(clanci.naslov_clanka, ' ', clanci.kljucne_rijeci) LIKE '%$naslov_kljucna_rijec%')
                           OR clanci.naslov_clanka LIKE '%$naslov_kljucna_rijec%'
                           OR clanci.kljucne_rijeci LIKE '%$naslov_kljucna_rijec%')";
            }
            
            $upit_brojac .= $upit;
            
            if ($ime_prezime == '' && $datum_od == '' && $datum_do == '' && $naslov_kljucna_rijec == '') {
                $broj_red = $po_strani;
            } else {
                $ukupno = $konekcija->query($upit_brojac);
                $broj_red = $ukupno->fetch_row()[0];
            }
            
            $upit .= " LIMIT $start, $po_strani";
            
            $upit_podaci .= $upit;
            $rezultat = $konekcija->query($upit_podaci);
            
            for($clanci = array(); $red = $rezultat->fetch_assoc(); $clanci[] = $red);
            
            $broj_str = ceil($broj_red / $po_strani);
            $pret = $stranica - 1;
            $sled = $stranica + 1;
            $array['broj_str'] = $broj_str;
            $array['broj_red'] = $broj_red;
            $array['pret'] = $pret;
            $array['sled'] = $sled;
            $array['sviClanci'] = $clanci;
            $array['strana'] = $stranica;

            return $array;
            
        }
        
        /*
         * Prikazi clanke u tabeli paginacija
         */
        public function prikaziClankeUTabeliPaginacija($logovani_korisnik, $po_strani, $strana) {
            global $konekcija;
            
            if ($strana <= 1) {
                    $start = 0;
            } else {
                    $start = ($strana * $po_strani) - $po_strani;
            }
            
            $upit = $konekcija->query("SELECT clanci.id AS clanak_id, 
                                           korisnici.id AS korisnik_id,
                                           naslov_clanka,
                                           objavljen
                                           FROM clanci
                                           LEFT JOIN korisnici 
                                           ON clanci.korisnik_id = korisnici.id
                                           WHERE korisnici.id = $logovani_korisnik
                                           ");
            
            $broj_kol = mysqli_num_rows($upit);
            
            $upit1 = "SELECT clanci.id AS clanak_id, 
                                           korisnici.id AS korisnik_id,
                                           naslov_clanka,
                                           objavljen
                                           FROM clanci
                                           LEFT JOIN korisnici 
                                           ON clanci.korisnik_id = korisnici.id
                                           WHERE korisnici.id = $logovani_korisnik";
            
            $broj_str = ceil($broj_kol / $po_strani);
            $upit1 .= " LIMIT $start, $po_strani";
            $rezultat = $konekcija->query($upit1);
            
            for($clanci = array(); $red = $rezultat->fetch_assoc(); $clanci[] = $red);
			
            $pret = $strana - 1;
            $sled = $strana + 1;
            $array['broj_stranica'] = $broj_str;
            $array['pret'] = $pret;
            $array['sled'] = $sled;
            $array['sviClanci'] = $clanci;
            $array['strana'] = $strana;

            return $array;
        }
              
        /*
         * Obrisi sliku clanka
         */
        public function obrisiSliku($id_clanka) {
            global $konekcija;
            $upit = "UPDATE clanci SET 
                     naslovna_slika = ''
                     WHERE id = $id_clanka";
            return $konekcija->query($upit);
        }
        
        /*
         * Prikazi sve clanke po korisniku
         */
        public function prikaziClankePoKorisniku($korisnik_id) {
            global $konekcija;
            $rezultat = $konekcija->query("SELECT korisnici.id as korisnik_id, naslovna_slika, naslov_clanka,
                                           kratki_tekst, dugacki_tekst, datum_objave_clanka
                                           FROM korisnici
                                           LEFT JOIN clanci
                                           ON clanci.korisnik_id = korisnici.id 
                                           WHERE korisnici.id = $korisnik_id AND objavljen = 1");
            
            for($clanci = array(); $red = $rezultat->fetch_assoc(); $clanci[] = $red);
            return $clanci;
        }
        
        /*
         * Prikazi autora 
         */
        public function prikaziAutora($korisnik_id) {
            global $konekcija;
            $rezultat = $konekcija->query("SELECT ime, prezime, slika_korisnika FROM korisnici WHERE id = $korisnik_id");
            
            return $rezultat->fetch_assoc();
        }
        
        /*
         * Obrisi clanak i povezane tabele
         */
        public function obrisiSvePoClankuId($clanak_id) {
            global $konekcija;

            $query ="DELETE CU, C, K, KU
                     FROM clanci C
                     LEFT JOIN clanci_utisak CU
                     ON C.id = CU.clanak_id
                     LEFT JOIN komentari K
                     ON C.id = K.clanak_id
                     LEFT JOIN komentari_utisak KU
                     ON K.id = KU.komentar_id
                     WHERE C.id = $clanak_id";
            
            return $konekcija->query($query);
        }
    }
