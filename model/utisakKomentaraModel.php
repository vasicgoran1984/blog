<?php

class utisakKomentaraModel extends ORM {

    protected $primaryKey = 'id';

    public function __construct(){
        parent::__construct();
        $this->setTable("komentari_utisak");
    }
    
    /*
     * Dodaj utisak na komentar
     */
    public function dodajUtisakNaKomentar($korisnik_id, $komentar_id, $utisak) {
        $table = new ORM();
        $table->setTable('komentari_utisak');
        $id = $table->insert([
            'id'          => '',
            'korisnik_id' => $korisnik_id,
            'komentar_id' => $komentar_id,
            'utisak'      => $utisak
        ]);
        return $id;
    }
    
    /*
     * Postoji li utisak logovanog korisnika
     */
    public function postojiUtisakLogovanogKorisnika($korisnik_id, $komentar_id) {
        $table = new ORM();
        $rezultat = $table->table('komentari_utisak')->select("id, korisnik_id, komentar_id")->where('korisnik_id', $korisnik_id)->where('komentar_id', $komentar_id)->first();
        
        if(!empty($rezultat)) {
            return TRUE;
        }
        return FALSE;
    }
    
     /*
     * Resetuj utiska logovanog korisnika
     */
    public function promijeniPostojeciUtisak($korisnik_id, $komentar_id, $utisak) {
        $table = new ORM();
        $table->setTable('komentari_utisak');
        $id = $table->where('korisnik_id', $korisnik_id)->where('komentar_id', $komentar_id)->update([
            'utisak' => $utisak
        ]);
        return $id;
    }
    
    /*
     * Provjera da li postoji utisak za logovanog korisnika 
     */
    public function kojiUtisakKomentaraPostoji($korisnik_id, $komentar_id) {
        $upit = DB::query("SELECT komentari_utisak.id as komentari_utisak_id, komentari_utisak.utisak as utisak,
                                       komentari_utisak.komentar_id as komentari_utisak_komentar_id
                                       FROM komentari_utisak
                                       LEFT JOIN komentari
                                       ON komentari.id = komentari_utisak.komentar_id
                                       WHERE komentari_utisak.korisnik_id = $korisnik_id");
        return $upit;
    }
}