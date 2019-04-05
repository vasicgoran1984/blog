<?php

class KomentarModel extends ORM {

    protected $primaryKey = 'id';

    public function __construct(){
        parent::__construct();
        $this->setTable("komentari");
    }

    /*
     * Dodaj komentar
     */
    public function dodajKomentar($korisnik_id,  $clanak_id, $noviKomentar, $datum_objave_komentara) {
        $table = new ORM();
        $table->setTable('komentari');
        $id = $table->insert([
            'id'                     => '',
            'korisnik_id'            => $korisnik_id,
            'clanak_id'              => $clanak_id,
            'komentar'               => $noviKomentar,
            'datum_objave_komentara' => $datum_objave_komentara
        ]);
        return $id;
    }

    /*
     * Clanak sa komentarima
     */
    public function clanakSaKomentarima($clanak_id, $korisnik) {
        $komentari = DB::query("SELECT K.id as komentar_id, K.komentar, K.datum_objave_komentara, KU.utisak,
                                K.korisnik_id, ime, prezime
                                FROM komentari K
                                LEFT JOIN komentari_utisak KU
                                ON KU.komentar_id = K.id AND KU.korisnik_id = $korisnik
                                LEFT JOIN korisnici KO
                                ON K.korisnik_id = KO.id
                                WHERE K.clanak_id = $clanak_id");
        return $komentari;
    }

    /*
     * Procitaj clanak sa komentarima
     */
    public function procitajClankakSaKomentarima($clanak_id) {
        $komentari = DB::query("SELECT K.id as komentar_id, K.komentar, 
                                K.korisnik_id, C.naslovna_slika, C.naslov_clanka, C.kratki_tekst, C.dugacki_tekst,
                                C.datum_objave_clanka, ime, prezime, datum_objave_komentara
                                FROM komentari K
                                LEFT JOIN clanci C
                                ON K.clanak_id = C.id
                                LEFT JOIN korisnici KO
                                ON C.korisnik_id = KO.id
                                WHERE C.id = $clanak_id");
        return $komentari;
    }
}