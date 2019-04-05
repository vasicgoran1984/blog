<?php

class ClanakModel extends ORM {

    protected $primaryKey = 'id';

    public function __construct(){
        parent::__construct();
        $this->setTable("clanci");
    }

    /*
     * Dodaj clanak
     */
    public function dodajClanak($korisnik_id, $naslovna_slika, $naslov_clanka, $kratki_tekst, $dugacki_tekst, $kljucne_rijeci, $slug, $objavljen, $datum_objave_clanka) {
        $table = new ORM();
        $table->setTable('clanci');
        $id = $table->insert([
            'id' => '',
            'korisnik_id'         => $korisnik_id,
            'naslovna_slika'      => $naslovna_slika,
            'naslov_clanka'       => $naslov_clanka,
            'kratki_tekst'        => $kratki_tekst,
            'dugacki_tekst'       => $dugacki_tekst,
            'kljucne_rijeci'      => $kljucne_rijeci,
            'slug'                => $slug,
            'objavljen'           => $objavljen,
            'datum_objave_clanka' => $datum_objave_clanka
        ]);
        return $id;
    }

    /*
     * Izmijeni clanak
     */
    public function IzmijeniClanak($clanak_id, $korisnik_id, $naslovna_slika, $naslov_clanka, $kratki_tekst, $dugacki_tekst, $kljucne_rijeci, $slug, $objavljen, $datum_objave_clanka) {
        $table = new ORM();
            $table->setTable('clanci');
            $id = $table->where('id', $clanak_id)->update([
                'korisnik_id'         => $korisnik_id,
                'naslovna_slika'      => $naslovna_slika,
                'naslov_clanka'       => $naslov_clanka,
                'kratki_tekst'        => $kratki_tekst,
                'dugacki_tekst'       => $dugacki_tekst,
                'kljucne_rijeci'      => $kljucne_rijeci,
                'slug'                => $slug,
                'objavljen'           => $objavljen,
                'datum_objave_clanka' => $datum_objave_clanka
        ]);
        return $id;
    }

    /*
     *  Izmijeni Sliku
     */
    public function IzmijeniSliku($zadnji_unos, $naslovna_slika) {
        $table = new ORM();
            $table->setTable('clanci');
            $id = $table->where('id', $zadnji_unos)->update([
                'naslovna_slika' => $naslovna_slika,
            ]);
    }

    /*
     * Prikazi clanak po Id-u
     */
    public function prikaziClanakPoIdu($clanak_id) {
        $table = new ORM();
        return $table->table('clanci')->select('id, korisnik_id, naslovna_slika, 
        naslov_clanka, kratki_tekst, dugacki_tekst, kljucne_rijeci, objavljen')->where('id', $clanak_id)->first();
    }

    /*
     * Prikazi sliku clanka po Id-u
     */
    public function prikaziSlikuClankaPoIdu($clanak_id) {
        $table = new ORM();
        $rezultat = $table->table('clanci')->select('naslovna_slika')->where('id', $clanak_id)->first();
        return $rezultat->naslovna_slika;
    }

    /*
     * Prikazi clanak po slug-u
     */
    public function prikaziClanakPoSlug($url) {
        $table = new ORM();
        $item = $table->table('clanci')
                ->select(array('id', 'korisnik_id', 'naslovna_slika', 'kratki_tekst', 'dugacki_tekst', 'datum_objave_clanka'))
                ->where('slug', "%$url%", 'LIKE')
                ->first();
        return $item;
    }

    /*
     * Prikazi sve objavljene clanke
     */
    public function sviObjavljeniClanciPaginacija($po_strani, $stranica, $ime_prezime, $datum_od, $datum_do, $naslov_kljucna_rijec) {
        if ($stranica <= 1) {
                $start = 0;
        } else {
                $start = ($stranica * $po_strani) - $po_strani;
        }

        $upit_brojac = "SELECT count(*)";
        $upit_podaci = "SELECT clanci.id AS clanak_id, naslovna_slika,
                        naslov_clanka, dugacki_tekst, ime, prezime, slug ";

        $upit = "FROM clanci
                 LEFT JOIN korisnici
                 ON clanci.korisnik_id = korisnici.id
                 WHERE objavljen = 1";

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
            $ukupno = DB::query($upit_brojac)[0];
            $broj_red = get_object_vars($ukupno);
            $broj_red = $broj_red['count(*)'];
        }

        $upit .= " ORDER BY clanci.id DESC";
        $upit .= " LIMIT $start, $po_strani";

        $upit_podaci .= $upit;
        $rezultat = DB::query($upit_podaci);
        $broj_str = ceil($broj_red / $po_strani);

        $noviNiz = array();
        $noviNiz['sviClanci'] = $rezultat;
        $pret = $stranica - 1;
        $sled = $stranica + 1;
        $noviNiz['broj_str'] = $broj_str;
        $noviNiz['broj_red'] = $broj_red;
        $noviNiz['pret'] = $pret;
        $noviNiz['sled'] = $sled;
        $noviNiz['strana'] = $stranica;

        return $noviNiz;
    }

    /*
     * Prikazi clanke u tabeli paginacija
     */
    public function prikaziClankeUTabeliPaginacija($logovani_korisnik, $po_strani, $strana) {
        if ($strana <= 1) {
                $start = 0;
        } else {
                $start = ($strana * $po_strani) - $po_strani;
        }

        $upit = DB::query("SELECT count(id) AS clanak_id, 
                           korisnik_id,
                           naslov_clanka,
                           objavljen
                           FROM clanci
                           WHERE korisnik_id = $logovani_korisnik")[0];

        $broj_kol = $upit->clanak_id;
        $broj_str = ceil($broj_kol / $po_strani);

        $table = new ORM();
        $item = $table->table('clanci');

        $upit1 = DB::query("SELECT id AS clanak_id, 
                            korisnik_id,
                            naslov_clanka,
                            objavljen
                            FROM clanci
                            WHERE korisnik_id = $logovani_korisnik LIMIT $start, $po_strani");

        $noviNiz = array();
        $noviNiz["clanci"] = $upit1;
        $pret = $strana - 1;
        $sled = $strana + 1;
        $noviNiz['broj_stranica'] = $broj_str;
        $noviNiz['pret'] = $pret;
        $noviNiz['sled'] = $sled;
        $noviNiz['strana'] = $strana;

        return $noviNiz;
    }

    /*
     * Obrisi sliku clanka
     */
    public function obrisiSliku($id_clanka) {
        $table = new ORM();
        $table->setTable('clanci');
        $id = $table->where('id', $id_clanka)->update([
            'naslovna_slika' => NULL,
        ]);
        return $id;
    }

    /*
     * Obrisi clanak i povezane tabele
     */
    public function obrisiSvePoClankuId($clanak_id) {
        $table = new ORM();
        $table->setTable('clanci');
        $id = DB::query("DELETE CU, C, K, KU
                         FROM clanci C
                         LEFT JOIN clanci_utisak CU
                         ON C.id = CU.clanak_id
                         LEFT JOIN komentari K
                         ON C.id = K.clanak_id
                         LEFT JOIN komentari_utisak KU
                         ON K.id = KU.komentar_id
                         WHERE C.id = $clanak_id", FALSE);
    }
}
