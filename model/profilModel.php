<?php

class ProfilModel extends ORM {

    protected $primaryKey = 'id';

    public function __construct(){
        parent::__construct();
        $this->setTable("korisnici");
    }

    public function set($podaci) {
        foreach($podaci as $key => $value) {
            $this->$key = $value;
        }
    }

    /*
     * Snimi sliku korisnika
     */
    public function snimiSlikuKorisnika($id_korisnika, $slika) {
        $table = new ORM();
            $table->setTable('korisnici');
            $id = $table->where('id', $id_korisnika)->update([
                'slika_korisnika' => $slika,
        ]);
        return $id;
    }

    /*
     * Prikazi korisnika po ID-u
     */
    public function PrikaziKorisnikaPoIdu($id_korisnika) {
        $table = new ORM();
        return $table->table('korisnici')->select('ime, prezime, korisnicko_ime, email, slika_korisnika')->where('id', $id_korisnika)->first();
    }

    /*
     * Prikazi sliku korisnika po ID-u
     */
    public function prikaziSlikuLogovanogKorisnika($id_korisnika) {
        $table = new ORM();
        $rezultat = $table->table('korisnici')->select('slika_korisnika')->where('id', $id_korisnika)->first();
        return $rezultat->slika_korisnika;
    }

    /*
     * Edit korisnika
     */
    public function EditKorisnika($id_korisnika, $ime, $prezime, $email) {
        $table = new ORM();
            $table->setTable('korisnici');
            $id = $table->where('id', $id_korisnika)->update([
                'ime'     => $ime,
                'prezime' => $prezime,
                'email'   => $email
        ]);
        return $id;
    }

    /*
     * Obrisi sliku korisnika
     */
    public function obrisiSlikuKorisnika($id_korisnika) {
        $table = new ORM();
        $table->setTable('korisnici');
        $id = $table->where('id', $id_korisnika)->update([
            'slika_korisnika' => NULL,
        ]);
        return $id;
    }

    /*
     * Prikazi autora
     */
    public function prikaziAutora($korisnik_id) {
        $table = new ORM();
        return $table->table('korisnici')->select('ime, prezime, slika_korisnika')->where('id', $korisnik_id)->first();
    }

    /*
     * Prikazi sve clanke po korisniku
     */
    public function prikaziClankePoKorisniku($korisnik_id) {
        $upit = DB::query("SELECT korisnici.id as korisnik_id, naslovna_slika, naslov_clanka,
                                   kratki_tekst, dugacki_tekst, datum_objave_clanka
                                   FROM korisnici
                                   LEFT JOIN clanci
                                   ON clanci.korisnik_id = korisnici.id 
                                   WHERE korisnici.id = $korisnik_id AND objavljen = 1");
        
        return $upit;
    }
}
