<?php
    require_once 'db_konekcija/db_konekcija.php';
    
    class Komentar {
             
        public function komentarisiClanak() {
            
            if (isset($_SESSION['korisnik'][0])) {
                
                global $konekcija;
            
                include 'model/clanakModel.php';  
                include 'model/komentarModel.php'; 
                include 'model/utisakClankaModel.php';
                include 'model/utisakKomentaraModel.php';
            
                $clanak          = new ClanakModel($konekcija);
                $komentar        = new KomentarModel($konekcija);
                $utisakClanka    = new utisakClankaModel($konekcija);
                $utisakKomentara = new utisakKomentaraModel($konekcija);

                $rezultat = $clanak->prikaziClanakPoIdu($_POST['clanak_id']);
                $kojiUtisakPostoji = $utisakClanka->kojiUtisakPostoji($_SESSION['korisnik'][0], $_POST['clanak_id']);
                $clanakSaKomentarima = $komentar->clanakSaKomentarima($_POST['clanak_id'], $_SESSION['korisnik'][0]);
            
                if (isset($_POST['clanak_id'])) {
                    $clanak_id = $_POST['clanak_id'];

                    $korisnik_id = $_SESSION['korisnik'][0];
                    $greske = array();
                    if (isset($_POST['komentar']) && empty($_POST['komentar'])) {
                        $greske[] = "Molimo da unesete komentar.";
                    }
                    if(count($greske) > 0) {
                        exit (json_encode(array(
                                'error' => true,
                                'greske' => $greske
                        )));
                     } else {
                        $noviKomentar = $_POST['komentar'];
                        $datum_objave_komentara = date("Y-m-d H:i:s");
                        $dodajKomentar = $komentar->dodajKomentar($korisnik_id, $clanak_id, $noviKomentar, $datum_objave_komentara);
                        if ($dodajKomentar) {
                            $clanakSaKomentarima = $komentar->clanakSaKomentarima($_POST['clanak_id'], $_SESSION['korisnik'][0]);
                            exit (json_encode(array(
                                'status'       => true,
                                'komentar'     => $noviKomentar,
                                'komentarisao' => $_SESSION['korisnik'][1] . ' ' . $_SESSION['korisnik'][2]
                            )));
                        }
                     }
                }
            } else {
                exit (json_encode(array(
                                'login'=> true,
                                'url' => BASE_URL
                            )));
            }
        }
    }

