<?php

    class Profil {
        
        /*
         * Edit korisnika
         */
        public function editKorisnika() {
            
            if (isset($_SESSION['korisnik'])) {
                global $konekcija;
            
                include 'model/profilModel.php';
                $id_korisnika = $_SESSION['korisnik'][0];
                $profil = new ProfilModel($konekcija);
                $korisnik = $profil->PrikaziKorisnikaPoIdu($id_korisnika);

                if(isset($_POST['edit_korisnika'])) {
                    $ime     = $_POST['ime'];
                    $prezime = $_POST['prezime'];
                    $email   = $_POST['email'];

                    $greske = array();

                    if (empty($ime))     { array_push($greske, 'Ime je obavezno polje'); }
                    if (empty($prezime)) { array_push($greske, 'Prezime je obavezno polje'); }
                    if (empty($email))   { array_push($greske, 'Email je obavezno polje'); }

                    $editKorisnika = $profil->EditKorisnika($id_korisnika, $ime, $prezime, $email);

                    if ($editKorisnika) {
                        $rezultat = $profil->prikaziKorisnika($id_korisnika);
                        $_SESSION['korisnik'] = $rezultat;
                        header("Location: ". BASE_URL."index.php?controller=profil&operation=editKorisnika");
                        die();
                    }

                }
                include BASE_PATH . '/view/profilKorisnika.php';
            } else {
                include BASE_PATH . '/view/logovanje.php';
            }
            
            
        }
        
        /*
         * Dodaj sliku korisniku
         */
        public function dodajSliku() {
            global $konekcija;
            
            if(isset($_FILES['image'])) {
                $velicina_slike = $_FILES['image']['size'];
                $file_tmp       = $_FILES['image']['tmp_name'];
                $tip_slike      = $_FILES['image']['type'];
                $format_slike   = array("jpeg","jpg","png");
                $ime_slike      = strtolower(end(explode('.',$_FILES['image']['name'])));
                $slika          = $_SESSION['korisnik'][0] . ".png";
                
                $greske = array();
                
                if (in_array($ime_slike, $format_slike) === false) {
                    $_SESSION['greska'] = 'Format nije dozvoljen. Koristite formate JPEG, JPG ili PNG.';
                    header("Location: ". BASE_URL."index.php?controller=profil&operation=editKorisnika");
                    die();
                } else {
                    move_uploaded_file($file_tmp,BASE_PATH.'/view/assets/images/korisnici/'.$slika);
                    include 'model/profilModel.php';
                    $id_korisnika = $_SESSION['korisnik'][0];
                    $profil       = new ProfilModel($konekcija);
                    
                    $rezultat = $profil->snimiSlikuKorisnika($id_korisnika, $slika);
                    if (!is_null($rezultat)) { 
                        $rezultat = $profil->prikaziKorisnika($id_korisnika);
                        $_SESSION['korisnik'] = $rezultat;
                        header("Location: ". BASE_URL."index.php?controller=profil&operation=editKorisnika");
                        die();
                    } 
                }
            }
        }
        
        /*
         * Obrisi sliku korisniku
         */
        public function obrisiSliku() {
            global $konekcija;
            
            if (isset($_SESSION['korisnik'])) {
                include 'model/profilModel.php';
                
                $id_korisnika = $_SESSION['korisnik'][0];
                $profil       = new ProfilModel($konekcija);
                $rezultat     = $profil->obrisiSliku($id_korisnika);
                $ime_slike    = BASE_PATH.'/view/assets/images/korisnici/' . $id_korisnika . '.png';
                
                if (file_exists($ime_slike)) {
                    unlink($ime_slike);
                } 
                if ($rezultat) {
                    header("Location: ". BASE_URL."index.php?controller=profil&operation=editKorisnika");
                    die();
                }
            } else {
                include BASE_PATH . '/view/logovanje.php';
            }
        }
    }