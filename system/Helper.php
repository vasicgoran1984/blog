<?php

class Validation {
    
    public function validateRegister($podaci_reg) {
        $greske = array();
        
        if (empty($podaci_reg['ime'])) {
            $greske[] = "Ime je obavezno polje.";
        }
        
        if(!empty($podaci_reg['ime']) && !preg_match("/^[a-zA-Z]{3,30}$/",str_replace(" ","",$podaci_reg['ime']))) {
            $greske[] = 'Ime moze da ima samo slova. Unesite najmanje 3 do 30 karaktera.';
        }
        
        if (empty($podaci_reg['prezime'])) {
            $greske[] = "Prezime je obavezno polje.";
        }

        if(!empty($podaci_reg['prezime']) && !preg_match("/^[a-zA-Z]{3,30}$/",str_replace(" ","",$podaci_reg['prezime']))) {
            $greske[] = 'Prezime moze da ima samo slova. Unesite najmanje 3 do 30 karaktera.';
        }
        
        if (empty($podaci_reg['korisnicko_ime'])) {
            $greske[] = "Korisnicko ime je obavezno polje.";
        }
        
        if(!empty($podaci_reg['korisnicko_ime']) && !preg_match("/^[a-zA-Z0-9]{3,30}$/",str_replace(" ","",$podaci_reg['korisnicko_ime']))) {
            $greske[] = 'Korisnicko ime moze imati kombinaciju samo slova i brojeva. Unesite najmanje 3 do 30 karaktera.';
        }
        
        if (empty($podaci_reg['email'])) {
            $greske[] = "Email je obavezno polje.";
        }
        
        if (!empty($podaci_reg['email']) && !filter_var($podaci_reg['email'], FILTER_VALIDATE_EMAIL)) {
            $greske[] = "Email nije validan!";
        }
        
        if (empty($podaci_reg['password'])) {
            $greske[] = "Password je obavezno polje.";
        }
        
        if (!empty($podaci_reg['password']) && !preg_match('/^.*(?=.{6,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/',$podaci_reg['password'])) {
            $greske[] = "Password mora imati najmanje jedno malo, veliko slovo i jedan broj. Morate unijeti najmanje 6 karaktera.";
        }
        
        if (empty($podaci_reg['password_potvrda'])) {
            $greske[] = "Unesite isti password za potvrdu.";
        }
        
        if (!empty($_POST['password'] && $_POST['password_potvrda']) && $_POST['password'] !== $_POST['password_potvrda']) {
            $greske[] = "Passwordi se ne podudaraju!";
        }
        
        return $greske;
    }
    
    public function validateResetPass($podaci_resset) {
        $greske = array();
        
        if (empty($podaci_resset['korisnicko_ime'])) {
            $greske[] = "Korisnicko ime je obavezno.";
        }
        
        if (empty($podaci_resset['stari_password'])) {
            $greske[] = "Unesite trenutni password.";
        }
        
        if (empty($podaci_resset['novi_password'])) {
            $greske[] = "Unesite novi password.";
        }
        
        if (!empty($podaci_resset['novi_password']) && !preg_match('/^.*(?=.{6,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/',$podaci_resset['novi_password'])) {
            $greske[] = "Password mora imati najmanje jedno malo, veliko slovo i jedan broj. Morate unijeti najmanje 6 karaktera.";
        }
        
        if (empty($podaci_resset['password_potvrda'])) {
            $greske[] = "Unesite isti password za potvrdu.";
        }
        
        if (!empty($podaci_resset['novi_password'] && $_POST['password_potvrda']) && $podaci_resset['novi_password'] !== $_POST['password_potvrda']) {
            $greske[] = "Passwordi se ne podudaraju!";
        }
        
        return $greske;
    }
    
    public function validatePost($podaci_clanka) {
        $greske = array();

        if (empty($podaci_clanka['naslov_clanka'])) {
            $greske[] = "Molimo da unesete naslov clanka.";
        }
        
        if(!empty($podaci_clanka['naslov_clanka']) && !preg_match("/^[a-zA-Z0-9]{3,50}$/",str_replace(" ","",$podaci_clanka['naslov_clanka']))) {
            $greske[] = 'Naslov moze da ima kombinaciju slova i brojeva. Unesite najmanje 3 karaktera.';
        }
        
        if (empty($podaci_clanka['kratki_tekst'])) {
            $greske[] = "Molimo da unesete kratki tekst.";
        }

        if(!empty($podaci_clanka['kratki_tekst']) && !preg_match("/^[a-zA-Z]{3,50}$/",str_replace(" ","",$podaci_clanka['kratki_tekst']))) {
            $greske[] = 'Kratki tekst moze da ima samo slova. Unesite najmanje 3 karaktera.';
        }
        
        if (empty($podaci_clanka['dugacki_tekst'])) {
            $greske[] = "Molimo da unesete opis clanka.";
        }
        
        if(!empty($podaci_clanka['dugacki_tekst']) && !preg_match('/^.*(?=.{5,})(?=.*[a-z]).*$/',str_replace(" ","",$podaci_clanka['dugacki_tekst']))) {
            $greske[] = 'Opis clanka moze da ima samo slova. Unesite najmanje 5 karaktera.';
        }
        
        if (empty($podaci_clanka['kljucne_rijeci'])) {
            $greske[] = "Molimo da unesete kljucne rijeci.";
        }
        
        if(!empty($podaci_clanka['kljucne_rijeci']) && !preg_match("/^[a-zA-Z]{3,}$/",str_replace(" ","",$podaci_clanka['kljucne_rijeci']))) {
            $greske[] = 'Kljucne rijeci mogu imati samo slova. Unesite najmanje 3 karaktera.';
        }
        
        if ($this->validateImage($podaci_clanka['extenzija'])) {
            $greske[] = "Format nije dozvoljen. Koristite formate JPEG, JPG ili PNG.";
        }
        
        return $greske;
    }

    public function validateProfile($podaci_profil) {
        $greske = array();

        if (empty($podaci_profil['ime'])) {
            $greske[] = "Ime je obavezno polje.";
        }
        
        if(!empty($podaci_profil['ime']) && !preg_match("/^[a-zA-Z]{3,30}$/",str_replace(" ","",$podaci_profil['ime']))) {
            $greske[] = 'Ime moze da ima samo slova. Unesite najmanje 3 do 30 karaktera.';
        }
        
        if (empty($podaci_profil['prezime'])) {
            $greske[] = "Prezime je obavezno polje.";
        }

        if(!empty($podaci_profil['prezime']) && !preg_match("/^[a-zA-Z]{3,30}$/",str_replace(" ","",$podaci_profil['prezime']))) {
            $greske[] = 'Prezime moze da ima samo slova. Unesite najmanje 3 do 30 karaktera.';
        }
        
        if (empty($podaci_profil['email'])) {
            $greske[] = "Email je obavezno polje.";
        }
        
        if (!empty($podaci_profil['email']) && !filter_var($podaci_profil['email'], FILTER_VALIDATE_EMAIL)) {
            $greske[] = "Email nije validan!";
        }
        
        return $greske;
    }
    
    public function validateProfileImage($podaci_profil) {
        $greske = array();
        
        if ($podaci_profil['extenzija'] == '') {
            $greske[] = "Izaberite sliku.";
        } else if ($this->validateImage($podaci_profil['extenzija'])) {
            $greske[] = "Format nije dozvoljen. Koristite formate JPEG, JPG ili PNG.";
        }
        
        return $greske;
    }

    public function validateImage($extenzija) {
        if (!empty($extenzija)) {
            $dozvoljeni_format_slike = array("jpeg", "jpg", "png");
            if (in_array($extenzija, $dozvoljeni_format_slike) === false) {
                return TRUE;
            }
        }
    }
}
