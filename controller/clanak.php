<?php
    require_once 'model/clanakModel.php';
    require_once 'model/utisakClankaModel.php';
    require_once 'db_konekcija/db_konekcija.php';
    
    class Clanak {
        
        public function stranicaClanak() {
            
             if (isset($_SESSION['korisnik'])) {
                global $konekcija;

                $clanak = new ClanakModel($konekcija);
                include BASE_PATH . '/view/clanak.php';
            } else {
                include BASE_PATH . '/view/logovanje.php';
            }
            
        }
        
        /*
         * Kreiraj Novi Clanak
         */
        public function dodajIzmijeniClanak() {
            
            if (isset($_SESSION['korisnik'])) {
                global $konekcija;
            
                if (isset($_GET['clanak_id'])) {

                    $utisakClanka = new utisakClankaModel($konekcija);
                    $clanak       = new ClanakModel($konekcija);

                    $rezultat = $clanak->prikaziClanakPoIdu($_GET['clanak_id']);
                    $kojiUtisakPostoji = $utisakClanka->kojiUtisakPostoji($_SESSION['korisnik'][0], $_GET['clanak_id']);

                    include BASE_PATH . '/view/dodajIzmijeniClanak.php';
                } else {
                    if (isset($_POST['novi_clanak'])) {
                        $greske         = array();
                        $naslovna_slika = '';
                        $zadnji_unos    = '';
                        $file_tmp       = '';

                        if (isset($_POST['naslov_clanka']) && empty($_POST['naslov_clanka'])) {
                            $greske[] = "Molimo da unesete naslov clanka.";
                        }
                        if (isset($_POST['kratki_tekst']) && empty($_POST['kratki_tekst'])) {
                            $greske[] = "Molimo da unesete kratki tekst.";
                        }
                        if (isset($_POST['dugacki_tekst']) && empty($_POST['dugacki_tekst'])) {
                            $greske[] = "Molimo da unesete opis clanka.";
                        }
                        if (isset($_POST['kljucne_rijeci']) && empty($_POST['kljucne_rijeci'])) {
                            $greske[] = "Molimo da unesete kljucne rijeci.";
                        }
                        if(count($greske) > 0) {
                            $clanak       = new ClanakModel($konekcija);
                            $rezultat = $clanak->prikaziClanakPoIdu($_POST['clanak_id']);

                            include BASE_PATH . '/view/dodajIzmijeniClanak.php';

                        } else {
                            $korisnik_id    = $_SESSION['korisnik'][0];
                            $naslov_clanka  = $_POST['naslov_clanka'];
                            $kratki_tekst   = $_POST['kratki_tekst'];
                            $dugacki_tekst  = $_POST['dugacki_tekst'];
                            $kljucne_rijeci = str_replace(";", " ", $_POST['kljucne_rijeci']);

                            if (isset($_POST['clanak_id']) && ! empty($_POST['clanak_id'])) {
                                $slug = strtolower(str_replace(" ", "-", $naslov_clanka));
                                $slug = trim(strtolower(str_replace(" ", "-", $naslov_clanka)), '-');
                            } else {
                                $slug = trim(strtolower(str_replace(" ", "-", $_POST['naslov_clanka'])), '-');
                            }
                            $slug= preg_replace('/[^a-z0-9-]+/', '-', $slug);

                            $objavljen = (!isset($_POST['objavljen']) ? 0 : 1 );
                            $datum_objave_clanka = date("Y-m-d H:i:s");

                            $clanak = new ClanakModel($konekcija);

                            if (isset($_POST['clanak_id']) && !empty($_POST['clanak_id'])) {
                                $clanak_id = $_POST['clanak_id'];

                                if (file_exists($_FILES['naslovna_slika']['tmp_name']) && is_uploaded_file($_FILES['naslovna_slika']['tmp_name'])) {
                                    $format_slike = array("jpeg","jpg","png");
                                    $file_tmp     = $_FILES['naslovna_slika']['tmp_name'];
                                    $naslovna_slika = $clanak_id . ".png";
                                    $naziv_extenzija = explode('.',$_FILES['naslovna_slika']['name']);
                                    $extenzija = strtolower($naziv_extenzija[1]);

                                    if (in_array($extenzija, $format_slike) === false) {
                                        $greske[] = "Format nije dozvoljen. Koristite formate JPEG, JPG ili PNG.";
                                    }
                                } else {
                                    $rezultat = $clanak->prikaziClanakPoIdu($_POST['clanak_id']);
                                    $naslovna_slika = $rezultat['naslovna_slika'];
                                }
                                if(count($greske) > 0) {
                                    $rezultat = $clanak->prikaziClanakPoIdu($_POST['clanak_id']);
                                    include BASE_PATH . '/view/dodajIzmijeniClanak.php';

                                } else {
                                    $rezultat = $clanak->IzmijeniClanak($clanak_id, $korisnik_id, $naslovna_slika, $naslov_clanka, $kratki_tekst, $dugacki_tekst, $kljucne_rijeci, $slug, $objavljen, $datum_objave_clanka); 

                                    if ($rezultat) {
                                        move_uploaded_file($file_tmp,BASE_PATH.'/view/assets/images/clanci/'.$naslovna_slika);
                                        header("Location: ". BASE_URL . 'index.php?controller=clanak&operation=stranicaClanak');
                                        die();
                                    }
                                }
                            } else {
                                if (file_exists($_FILES['naslovna_slika']['tmp_name']) && is_uploaded_file($_FILES['naslovna_slika']['tmp_name'])) {
                                    $format_slike = array("jpeg","jpg","png");
                                    $file_tmp       = $_FILES['naslovna_slika']['tmp_name'];

                                    $naziv_extenzija = explode('.',$_FILES['naslovna_slika']['name']);
                                    $extenzija = strtolower($naziv_extenzija[1]);

                                    if (in_array($extenzija, $format_slike) === false) {
                                        $greske[] = "Format nije dozvoljen. Koristite formate JPEG, JPG ili PNG.";
                                    }
                                }
                                if(count($greske) > 0) {
                                    include BASE_PATH . '/view/dodajIzmijeniClanak.php';
                                } else {
                                    $rezultat = $clanak->dodajClanak($korisnik_id, $naslovna_slika, $naslov_clanka, $kratki_tekst, $dugacki_tekst, $kljucne_rijeci, $slug, $objavljen, $datum_objave_clanka); 
                                    if ($rezultat) {
                                        if (file_exists($_FILES['naslovna_slika']['tmp_name']) && is_uploaded_file($_FILES['naslovna_slika']['tmp_name'])) {
                                            global $konekcija;
                                            $zadnji_unos = mysqli_insert_id($konekcija);
                                            $naslovna_slika = $zadnji_unos . ".png";
                                        }
                                        $rezultat = $clanak->IzmijeniSliku($zadnji_unos, $naslovna_slika);
                                        move_uploaded_file($file_tmp,BASE_PATH.'/view/assets/images/clanci/'.$naslovna_slika);
                                        include BASE_PATH . '/view/clanak.php';
                                    }
                                }
                            }
                        }
                    } else {
                        include BASE_PATH . '/view/dodajIzmijeniClanak.php';
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
            global $konekcija;
          
            $clanak = new ClanakModel($konekcija);
            
            if (isset($_POST['po_str']) && $_POST['po_str'] != '') {
                $po_str = $_POST['po_str'];
            }
            if (!isset($_POST['strana'])) {
                $strana = 1;
            } else {
                $strana = $_POST['strana'];
            }
            $sviClanci = $clanak->prikaziClankeUTabeliPaginacija($_SESSION['korisnik'][0], $po_str, $strana);
            include BASE_PATH . '/view/clanciPaginacija.php';
        }
        /*
         * Procitaj komentarisi clanak
         */
        public function procitajKomentarisiClanak() {
            global $konekcija;
            include 'model/utisakKomentaraModel.php';
            include 'model/komentarModel.php';  
            
            $clanak          = new ClanakModel($konekcija);
            $utisakClanka    = new utisakClankaModel($konekcija);
            $komentar        = new KomentarModel($konekcija);
            $utisakKomentara = new utisakKomentaraModel($konekcija);
            
            if (isset($_GET['clanak_id'])) {
                $rezultat = $clanak->prikaziClanakPoIdu($_GET['clanak_id']);
                
                if (isset($_SESSION['korisnik'][0]) && $_SESSION['korisnik'][0]  !== '') {
                    $kojiUtisakPostoji = $utisakClanka->kojiUtisakPostoji($_SESSION['korisnik'][0], $_GET['clanak_id']);
                } else {
                    $kojiUtisakPostoji = $utisakClanka->kojiUtisakPostoji('', $_GET['clanak_id']);
                }
                if (isset($_SESSION['korisnik'][0]) && $_SESSION['korisnik'][0]  !== '') {
                    $clanakSaKomentarima = $komentar->clanakSaKomentarima($_GET['clanak_id'], $_SESSION['korisnik'][0]);
                } else {
                    $procitajClanakSaKomentarima = $komentar->procitajClankakSaKomentarima($_GET['clanak_id']);
                }
                
                $pozitivniUtisci = $utisakClanka->prebrojPozitivneUtiskeClanka($_GET['clanak_id']);
                $negativniUtisci = $utisakClanka->prebrojNegativneUtiskeClanka($_GET['clanak_id']);
            }
            if (isset($_SESSION['korisnik'][0]) && $_SESSION['korisnik'][0]  !== '') {
                include BASE_PATH . '/view/procitajKomentarisiClanak.php';
            } else {
                include BASE_PATH . '/view/procitajClanakSaKomentarima.php';
            }
            
        }
        
        /*
         * Obrisi sliku korisniku
         */
        public function obrisiSlikuClanka() {
            global $konekcija;
            if (isset($_SESSION['korisnik'])) {
                
                if ($_POST['clanak_id']) {
                    $id_clanka = $_POST['clanak_id'];
                    
                    $clanak = new ClanakModel($konekcija);
           
                    $rezultat  = $clanak->obrisiSliku($id_clanka);
                    $ime_slike = BASE_PATH.'/view/assets/images/clanci/' . $id_clanka . '.png';

                    if (file_exists($ime_slike)) {
                        unlink($ime_slike);
                    } 
                    if ($rezultat) {
                        $rezultat = $clanak->prikaziClanakPoIdu($_POST['clanak_id']);
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
        public function pogledajSveClanke() {
            global $konekcija;
            
            $clanak = new ClanakModel($konekcija);
                
            if (isset($_GET['korisnik_id'])) {
                $korisnik_id = $_GET['korisnik_id'];
            }
            
            $prikaziClanke = $clanak->prikaziClankePoKorisniku($korisnik_id);
            
            include BASE_PATH . '/view/pregledClanakaPoKorisniku.php';
        }
    }

