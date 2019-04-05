<?php

class RegistrujKorisnika extends ORM {

    protected $primaryKey = 'id';

    public function __construct(){
        parent::__construct();
        $this->setTable("korisnici");
    }

    /*
     * Registruj novog korisnika
     */
    public function registrujNovogKorisnika($ime, $prezime, $korisnicko_ime, $email, $hash) {
        $table = new ORM();
        $table->setTable('korisnici');
        $id = $table->insert([
            'id'             => '',
            'ime'            => $ime,
            'prezime'        => $prezime,
            'korisnicko_ime' => $korisnicko_ime,
            'email'          => $email,
            'password'       => $hash
        ]);
        return $id;
    }

    /*
     * Provjeri korisnicko ime
     */
    public function provjeriKorisnickoIme($korisnicko_ime) {
        $table = new ORM();
        $rezultat = $table->table('korisnici')->select("korisnicko_ime")->where('korisnicko_ime', $korisnicko_ime)->first();
        $rezultat = array_values((array) $rezultat);

        if(!empty($rezultat)) {
            return TRUE;
        }
        return FALSE;
    }

    /*
     * Provjera da li je korisnicko ime slobodno
     */
    public function SlobodnoKorisnickoIme($korisnicko_ime) {
        $table = new ORM();
        return $table->table('korisnici')->select("korisnicko_ime")->where('korisnicko_ime', $korisnicko_ime)->first();
    }

    /*
     * Loguj korisnika
     */
    public function logujKorisnika($korisnicko_ime, $hash) {
        $table = new ORM();
        $rezultat = $table->table('korisnici')->select("id, ime, prezime, korisnicko_ime, email, slika_korisnika")->where('korisnicko_ime', $korisnicko_ime)->where('password', $hash)->first();
     
        if (!is_null($rezultat)) {
            return $rezultat->attributes;
        }
        return NULL;
    }

    /*
     * Provjeri password
     */
    public function provjeriPassword($korisnicko_ime, $hash) {
        $table = new ORM();
        $rezultat = $table->table('korisnici')->select("korisnicko_ime, password")->where('korisnicko_ime', $korisnicko_ime)->where('password', $hash)->first();
        
        if(!empty($rezultat)) {
            return TRUE;
        }
        return FALSE;
        
    }

    /*
     * Promijeni password
     */
    public function promijeniPassword($korisnicko_ime, $hash) {
        $table = new ORM();
            $table->setTable('korisnici');
            return $id = $table->where('korisnicko_ime', $korisnicko_ime)->update([
                'password' => $hash
        ]);
    }
}
