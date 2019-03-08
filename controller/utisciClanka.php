<?php
    require_once 'db_konekcija/db_konekcija.php';
    class utisciClanka {
        
        public function upisiUtisakNaClanak() {
            
            if (isset($_SESSION['korisnik'])) {
                global $konekcija;
            
                $utisak      = $_POST['utisak'];
                $clanak_id   = $_POST['clanak_id'];
                $korisnik_id = $_SESSION['korisnik'][0];

                include 'model/utisakClankaModel.php';
                $utisakClanka = new utisakClankaModel($konekcija);

                $postojiUtisakKorisnika = $utisakClanka->postojiUtisakLogovanogKorisnika($korisnik_id, $clanak_id);
                if ($postojiUtisakKorisnika) {
                    $kojiUtisakPostoji = $utisakClanka->kojiUtisakPostoji($_SESSION['korisnik'][0], $clanak_id);
                    if ($kojiUtisakPostoji) {
                        if ($utisak == $kojiUtisakPostoji[0]['utisak']) {
                            $utisak = 0;
                        }
                    }
                    $unesiUtisak = $utisakClanka->promijeniPostojeciUtisak($korisnik_id, $clanak_id, $utisak);
                } else {
                    $unesiUtisak = $utisakClanka->dodajUtisakNaClanak($korisnik_id, $clanak_id, $utisak);
                }
                $pozitivniUtisci = $utisakClanka->prebrojPozitivneUtiskeClanka($_POST['clanak_id']);
                $negativniUtisci = $utisakClanka->prebrojNegativneUtiskeClanka($_POST['clanak_id']);

                exit (json_encode(array(
                    'status'  => true,
                    'utisak'  => $utisak,
                    'svi_poz' => $pozitivniUtisci,
                    'svi_neg' => $negativniUtisci
                )));
            } else {
                include BASE_PATH . '/view/logovanje.php';
            }
        }
    }