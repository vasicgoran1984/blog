<?php
require_once 'model/clanakModel.php';
require_once 'model/utisakClankaModel.php';
require_once 'model/utisakKomentaraModel.php';
require_once 'model/komentarModel.php';  
require_once 'model/profilModel.php';  
    
class Clanak {
    
    /*
     * Prikazi stranicu za clanak
     */
    public function stranicaClanak() {

         if (isset($_SESSION['korisnik'])) {

            $clanak = new ClanakModel();
            include BASE_PATH . '/view/clanak.php';
        } else {
            include BASE_PATH . '/view/logovanje.php';
        }

    }

    /*
     * Kreiraj Novi Clanak
     */
    public function dodajIzmijeniClanak($data) {

        if (isset($_SESSION['korisnik'])) {
            $korisnik_id = $_SESSION['korisnik']['id'];
            $clanak = new ClanakModel();

            if (!empty($data['id'])) {
                $clanak_id = $data['id'];
                $rezultat = $clanak->prikaziClanakPoIdu($clanak_id);
                include BASE_PATH . '/view/dodajIzmijeniClanak.php';

            } else if (!isset($_POST['novi_clanak'])) {
                include BASE_PATH . '/view/dodajIzmijeniClanak.php';
            }

            if (isset($_POST['novi_clanak'])) {

                $validacija = new Validation();

                if (file_exists($_FILES['naslovna_slika']['tmp_name']) && is_uploaded_file($_FILES['naslovna_slika']['tmp_name'])) {
                    $file_tmp        = $_FILES['naslovna_slika']['tmp_name'];
                    $naziv_extenzija = explode('.',$_FILES['naslovna_slika']['name']);
                    $extenzija       = strtolower($naziv_extenzija[1]);
                    $slika           = $_FILES['naslovna_slika']['name'];
                    $lokacija        = BASE_PATH.'/view/assets/images/clanci/';
                }

                $podaci_clanka = array();
                $slika = array();

                if (isset($_POST['clanak_id'])) {
                    $podaci_clanka['clanak_id'] = $_POST['clanak_id'];
                }

                if (isset($_POST['naslov_clanka'])) {
                    $podaci_clanka['naslov_clanka'] = $_POST['naslov_clanka'];
                    $podaci_clanka['slug'] = trim(strtolower(str_replace(" ", "-", $podaci_clanka['naslov_clanka'])), '-');
                }

                if (isset($_POST['naslovna_slika'])) {
                    $podaci_clanka['naslovna_slika'] = $_POST['naslovna_slika'];
                }

                if (isset($_POST['kratki_tekst'])) {
                    $podaci_clanka['kratki_tekst'] = $_POST['kratki_tekst'];
                }

                if (isset($_POST['dugacki_tekst'])) {
                    $podaci_clanka['dugacki_tekst'] = $_POST['dugacki_tekst'];
                }

                if (isset($_POST['kljucne_rijeci'])) {
                    $podaci_clanka['kljucne_rijeci'] = str_replace(";", " ", $_POST['kljucne_rijeci']);
                }

                $podaci_clanka['objavljen'] = !isset($_POST['objavljen']) ? 0 : 1 ;
                $podaci_clanka['extenzija'] = isset($extenzija) ? $extenzija : ''; 
                $datum_objave_clanka = date("Y-m-d H:i:s");
                $post = $validacija->validatePost($podaci_clanka);

                if (!empty($post)) {

                    $greske = $post;

                    $noviNiz = array(
                        'id'      => $_POST['clanak_id'],
                        'objavljen'      => !isset($_POST['objavljen']) ? 0 : 1,
                        'naslov_clanka'  => $_POST['naslov_clanka'],
                        'kratki_tekst'   => $_POST['kratki_tekst'],
                        'dugacki_tekst'  => $_POST['dugacki_tekst'],
                        'kljucne_rijeci' => $_POST['kljucne_rijeci']
                    );

                    $rezultat = new ORM();
                    $rezultat->set($noviNiz);
                       
                    include BASE_PATH . '/view/dodajIzmijeniClanak.php';
                } else  {

                    if ($podaci_clanka['clanak_id']) {

                        if (!empty($podaci_clanka['extenzija'])) {
                            $naslovna_slika = $podaci_clanka['clanak_id'] . '.' . $podaci_clanka['extenzija'];
                            $postoji_slika = $clanak->prikaziSlikuClankaPoIdu($podaci_clanka['clanak_id']);
                            $obrisiSliku = array();
                            $obrisiSliku['ime']  = $postoji_slika;
                            $obrisiSliku['lokacija']  = BASE_PATH.'/view/assets/images/clanci/';
                            $obrisi_sliku= new DeleteImage();
                            $obrisi = $obrisi_sliku->deleteOldImage($obrisiSliku);
                            
                        } else {
                            $naslovna_slika = $clanak->prikaziSlikuClankaPoIdu($podaci_clanka['clanak_id']);
                        }

                        $id = $clanak->IzmijeniClanak($podaci_clanka['clanak_id'], $korisnik_id, $naslovna_slika, $podaci_clanka['naslov_clanka'], $podaci_clanka['kratki_tekst'], $podaci_clanka['dugacki_tekst'], $podaci_clanka['kljucne_rijeci'], $podaci_clanka['slug'], $podaci_clanka['objavljen'], $datum_objave_clanka); 

                        if ($id && !empty($podaci_clanka['extenzija'])) {
                            $slika['id']        = $podaci_clanka['clanak_id'];
                            $slika['ime']       = $naslovna_slika;
                            $slika['lokacija']  = $lokacija;
                            $slika['file_tmp']  = $file_tmp;
                            $ubaciSliku = new Import();
                            $importSlika = $ubaciSliku->importImage($slika);
                            
                            if ($importSlika) {
                                $clanak->IzmijeniSliku($slika['id'], $slika['ime']);
                            }
                        }
                        header("Location: ". BASE_URL . 'clanci/moji-clanci');
                        die();
                    } else {
                        $id = $clanak->dodajClanak($korisnik_id, $naslovna_slika = NULL, $podaci_clanka['naslov_clanka'], $podaci_clanka['kratki_tekst'], $podaci_clanka['dugacki_tekst'], $podaci_clanka['kljucne_rijeci'], $podaci_clanka['slug'], $podaci_clanka['objavljen'], $datum_objave_clanka); 

                        if ($id) {
                            if ($id && !empty($podaci_clanka['extenzija'])) {

                                $slika['ime']       = $id . '.' . $podaci_clanka['extenzija'];
                                $slika['lokacija']  = $lokacija;
                                $slika['file_tmp']  = $file_tmp;

                                $ubaciSliku = new Import();
                                $importSlika = $ubaciSliku->importImage($slika);

                                if ($importSlika) {
                                    $clanak->IzmijeniSliku($id, $slika['ime']);
                                }

                            }
                            header("Location: ". BASE_URL . 'clanci/moji-clanci');
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
     * Prikazi Clanke Paginacija
     */
    public function prikaziClankeUTabeli() {

        $clanak = new ClanakModel();

        if (isset($_POST['po_str']) && $_POST['po_str'] != '') {
            $po_str = $_POST['po_str'];
        }else {
            $po_str = 10;
        }
        if (!isset($_POST['strana'])) {
            $strana = 1;
        } else {
            $strana = $_POST['strana'];
        }
        $sviClanci = $clanak->prikaziClankeUTabeliPaginacija($_SESSION['korisnik']['id'], $po_str, $strana);
        include BASE_PATH . '/view/clanciPaginacija.php';
    }

    /*
     * Procitaj komentarisi clanak
     */
    public function procitajKomentarisiClanak($data) {

        $clanak          = new ClanakModel();
        $utisakClanka    = new utisakClankaModel();
        $komentar        = new KomentarModel();
        $utisakKomentara = new utisakKomentaraModel();
        $korisnik        = new ProfilModel();
        
        if (!empty($data['slug'])) {
            $slug = $data['slug'];
            $rezultat = $clanak->prikaziClanakPoSlug($slug);
          
            $clanak_id = $rezultat->id;
            $korisnik_id = $rezultat->korisnik_id;
        }   
        $prikaziAutora = $korisnik->prikaziAutora($korisnik_id);
        
        if (isset($_SESSION['korisnik']['id']) && $_SESSION['korisnik']['id']  !== '') {
            $kojiUtisakPostoji = $utisakClanka->kojiUtisakPostoji($_SESSION['korisnik']['id'], $clanak_id);
        } else {
            $kojiUtisakPostoji = $utisakClanka->kojiUtisakPostoji('', $clanak_id);
        }
        if (isset($_SESSION['korisnik']['id']) && $_SESSION['korisnik']['id']  !== '') {
            $clanakSaKomentarima = $komentar->clanakSaKomentarima($clanak_id, $_SESSION['korisnik']['id']);
        } else {
            $procitajClanakSaKomentarima = $komentar->procitajClankakSaKomentarima($clanak_id);
        }

        $pozitivniUtisci = $utisakClanka->prebrojPozitivneUtiskeClanka($clanak_id);
        $negativniUtisci = $utisakClanka->prebrojNegativneUtiskeClanka($clanak_id);

        if (isset($_SESSION['korisnik']['id']) && $_SESSION['korisnik']['id']  !== '') {
            include BASE_PATH . '/view/procitajKomentarisiClanak.php';
        } else {
            include BASE_PATH . '/view/procitajClanakSaKomentarima.php';
        }
    }

    /*
     * Obrisi sliku korisniku
     */
    public function obrisiSlikuClanka() {
       
        if (isset($_SESSION['korisnik'])) {

            if ($_POST['clanak_id']) {
                $id_clanka = $_POST['clanak_id'];
                $clanak    = new ClanakModel();
                $rezultat  = $clanak->prikaziClanakPoIdu($id_clanka);
                $obrisi    = $clanak->obrisiSliku($id_clanka);
                $ime_slike = BASE_PATH.'/view/assets/images/clanci/' . $rezultat->naslovna_slika;

                if (file_exists($ime_slike)) {
                    unlink($ime_slike);
                } 
                if ($obrisi) {
                    $rezultat = $clanak->prikaziClanakPoIdu($id_clanka);
                    include BASE_PATH . '/view/dodajIzmijeniClanak.php';
                }
            }
        } else {
            include BASE_PATH . '/view/logovanje.php';
        }
    }

    /*
     * Pogledaj sve clanke korisnika
     */
    public function pogledajSveClanke($data) {

        $clanak   = new ClanakModel();
        $korisnik = new ProfilModel();

        if (!empty($data['id'])) {
            $korisnik_id = $data['id'];
        }
        $prikaziClanke = $korisnik->prikaziClankePoKorisniku($korisnik_id);
        $prikaziAutora = $korisnik->prikaziAutora($korisnik_id);
        
        include BASE_PATH . '/view/pregledClanakaPoKorisniku.php';
    }

    /*
     * Obrisi clanak
     */
    public function obrisiClanak() {
 
        if (isset($_SESSION['korisnik'])) {
            $clanak = new ClanakModel();

            if (isset($_POST['clanak_id'])) {
                $rezultat = $clanak->prikaziClanakPoIdu($_POST['clanak_id']);

                if ($rezultat->naslovna_slika !== NULL) {
                    $ime_slike = BASE_PATH.'/view/assets/images/clanci/' . $rezultat->naslovna_slika;
                    unlink($ime_slike);
                }
                $obrisi = $clanak->obrisiSvePoClankuId($_POST['clanak_id']);

                exit (json_encode(array(
                    'status'  => true
                )));
            }
        } else {
            include BASE_PATH . '/view/logovanje.php';
        }
    }
}

