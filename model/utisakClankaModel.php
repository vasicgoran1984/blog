<?php

class utisakClankaModel extends ORM {

    protected $primaryKey = 'id';

    public function __construct(){
        parent::__construct();
        $this->setTable("clanci_utisak");
    }
    
    /*
     * Dodaj utisak na clanak
     */
    public function dodajUtisakNaClanak($korisnik_id, $clanak_id, $utisak) {
        $table = new ORM();
        $table->setTable('clanci_utisak');
        $id = $table->insert([
            'id'          => '',
            'korisnik_id' => $korisnik_id,
            'clanak_id'   => $clanak_id,
            'utisak'      => $utisak
        ]);
        return $id;
    }
    
    /*
     * Postoji li utisak logovanog korisnika
     */
    public function postojiUtisakLogovanogKorisnika($korisnik_id, $clanak_id) {
        $table = new ORM();
        $rezultat = $table->table('clanci_utisak')->select("id, korisnik_id, clanak_id")->where('korisnik_id', $korisnik_id)->where('clanak_id', $clanak_id)->first();
        
        if(!empty($rezultat)) {
            return TRUE;
        } 
        return FALSE;
    }
    
    /*
     * Resetuj utiska logovanog korisnika
     */
    public function promijeniPostojeciUtisak($korisnik_id, $clanak_id, $utisak) {
        $table = new ORM();
        $table->setTable('clanci_utisak');
        $id = $table->where('korisnik_id', $korisnik_id)->where('clanak_id', $clanak_id)->update([
            'utisak' => $utisak
        ]);
        return $id;
    }
    
    /*
     * Provjera da li postoji utisak za logovanog korisnika 
     */
    public function kojiUtisakPostoji($korisnik_id, $clanak_id) {
        $upit = DB::query("SELECT utisak FROM clanci_utisak WHERE clanak_id = $clanak_id");

        if ($korisnik_id != '') {
            $upit = DB::query("SELECT utisak FROM clanci_utisak WHERE clanak_id = $clanak_id AND korisnik_id = $korisnik_id");
        }
        return $upit;
    }
    
    /*
     * Prebroj pozitivne utiske clanka
     */
    public function prebrojPozitivneUtiskeClanka($clanak_id) {
        $table = new ORM();
        $table->setTable('clanci_utisak');
        $table->select('COUNT(utisak) as pozitivni')->where('utisak', 1)->where('clanak_id', $clanak_id)->first();
        $noviNiz = array();
        $noviNiz = get_object_vars($table);
        return $noviNiz['attributes']['pozitivni'];
    }
    
    /*
     * Prebroj pozitivne utiske clanka
     */
    public function prebrojNegativneUtiskeClanka($clanak_id) {
        $table = new ORM();
        $table->setTable('clanci_utisak');
        $table->select('COUNT(utisak) as negativni')->where('utisak', 2)->where('clanak_id', $clanak_id)->first();
        $noviNiz = array();
        $noviNiz = get_object_vars($table);
        return $noviNiz['attributes']['negativni'];
    }
}