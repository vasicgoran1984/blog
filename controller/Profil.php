<?php
require_once 'system/Route.php';
require_once 'model/profilModel.php';

class Profil {
    
    /*
     * Edit korisnika
     */
    public function editKorisnika() {

        if (isset($_SESSION['korisnik'])) {
            
            $id_korisnika = $_SESSION['korisnik']['id'];
            $profil = new ProfilModel();
            $korisnik = $profil->PrikaziKorisnikaPoIdu($id_korisnika);
            
            if(isset($_POST['edit_korisnika'])) {

                $validacija = new Validation();
                $podaci_profil = array();

                if (isset($_POST['ime'])) {
                    $podaci_profil['ime'] = $_POST['ime'];
                }

                if (isset($_POST['prezime'])) {
                    $podaci_profil['prezime'] = $_POST['prezime'];
                }

                if (isset($_POST['email'])) {
                    $podaci_profil['email'] = $_POST['email'];
                }

                $profile = $validacija->validateProfile($podaci_profil);

                if (!empty($profile)) {
                    $greske = $profile;
                        
                    $noviNiz = array(
                        'korisnik_id' => $id_korisnika,
                        'ime'         => $_POST['ime'],
                        'prezime'     => $_POST['prezime'],
                        'email'       => $_POST['email']
                    );

                    $korisnik = new ProfilModel();
                    $korisnik->set($noviNiz);
                    $korisnik->slika_korisnika = $profil->prikaziSlikuLogovanogKorisnika($id_korisnika);
                } else {
                    $editKorisnika = $profil->EditKorisnika($id_korisnika, $podaci_profil['ime'], $podaci_profil['prezime'], $podaci_profil['email']);
                    
                    if ($editKorisnika) {
                        header("Location: ". BASE_URL."profil/moj-profil");
                        die();
                    }
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

        if (isset($_SESSION['korisnik'])) {

            if (file_exists($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
                $file_tmp        = $_FILES['image']['tmp_name'];
                $naziv_extenzija = explode('.',$_FILES['image']['name']);
                $extenzija       = strtolower($naziv_extenzija[1]);
                $slika           = $_FILES['image']['name'];
                $lokacija        = BASE_PATH.'/view/assets/images/korisnici/';
            }
            
            $id_korisnika  = $_SESSION['korisnik']['id'];
            $profil        = new ProfilModel();
            $validacija    = new Validation();
            $podaci_profil = array();
            $slika         = array();
            $id_korisnika  = $_SESSION['korisnik']['id'];

            $podaci_profil['extenzija'] = isset($extenzija) ? $extenzija : ''; 
            $profile = $validacija->validateProfileImage($podaci_profil);

            if (!empty($profile)) {
                $greske = $profile;
                $korisnik = $profil->PrikaziKorisnikaPoIdu($id_korisnika);
                include BASE_PATH . '/view/profilKorisnika.php';
            } else {

                if (!empty($podaci_profil['extenzija'])) {

                    $slika = array();
                    $obrisiSliku = array();
                    $slika_korisnika = $id_korisnika . '.' . $podaci_profil['extenzija'];
                    $postoji_slika = $profil->prikaziSlikuLogovanogKorisnika($id_korisnika);

                    if ($postoji_slika) {

                        $obrisiSliku['ime']  = $postoji_slika;
                        $obrisiSliku['lokacija']  = $lokacija;

                        $obrisi_sliku= new DeleteImage();
                        $obrisi = $obrisi_sliku->deleteOldImage($obrisiSliku);
                    }

                    $slika['id']        = $id_korisnika;
                    $slika['ime']       = $slika_korisnika;
                    $slika['lokacija']  = $lokacija;
                    $slika['file_tmp']  = $file_tmp;

                    $ubaciSliku = new Import();
                    $importSlika = $ubaciSliku->importImage($slika);

                    if ($importSlika) {

                        $id = $profil->snimiSlikuKorisnika($id_korisnika, $slika_korisnika);

                        if (!is_null($id)) {
                            header("Location: ". BASE_URL."profil/moj-profil");
                            die();
                        }
                    }
                }
            }
        } else {
            include BASE_PATH . '/view/logovanje.php';
        }
    }

    /*
     * Obrisi sliku korisniku
     */
    public function obrisiSliku() {

        if (isset($_SESSION['korisnik'])) {
            $id_korisnika = $_SESSION['korisnik']['id'];
            $profil = new ProfilModel();

            $obrisiSliku = array();
            $obrisiSliku['ime']  = $profil->prikaziSlikuLogovanogKorisnika($id_korisnika);
            $obrisiSliku['lokacija']  = BASE_PATH.'/view/assets/images/korisnici/';

            $obrisi_sliku= new DeleteImage();
            $obrisi = $obrisi_sliku->deleteOldImage($obrisiSliku);

            $rezultat = $profil->obrisiSlikuKorisnika($id_korisnika);

            if ($rezultat) {
                header("Location: ". BASE_URL."profil/moj-profil");
                die();
            }
        } else {
            include BASE_PATH . '/view/logovanje.php';
        }
    }
}