<?php   

class utisciKomentara {

    public function upisiUtisakNaKomentar() {

        if (isset($_SESSION['korisnik'])) {
         
            $utisak      = $_POST['utisak'];
            $komentar_id = $_POST['komentar_id'];
            $korisnik_id = $_SESSION['korisnik']['id'];

            include 'model/utisakKomentaraModel.php';
            $utisakKomentara = new utisakKomentaraModel();

            $postojiUtisakKorisnika = $utisakKomentara->postojiUtisakLogovanogKorisnika($korisnik_id, $komentar_id);

            if ($postojiUtisakKorisnika) {
                $kojiUtisakKomentaraPostoji = $utisakKomentara->kojiUtisakKomentaraPostoji($_SESSION['korisnik']['id'], $komentar_id);

                if ($kojiUtisakKomentaraPostoji) {

                    foreach($kojiUtisakKomentaraPostoji as $jedanUtisak) {
                        if (($jedanUtisak->komentari_utisak_komentar_id == $komentar_id) && ($utisak == $jedanUtisak->utisak)) {
                            $utisak = 0;
                        }
                    }
                }
                $unesiUtisak = $utisakKomentara->promijeniPostojeciUtisak($korisnik_id, $komentar_id, $utisak);

            } else {
                $unesiUtisak = $utisakKomentara->dodajUtisakNaKomentar($korisnik_id, $komentar_id, $utisak);
            }

            exit(json_encode(array(
                'status' => true,
                'utisak' => $utisak,
                'promijenjeni_kom' => $komentar_id
            )));

        } else {
            include BASE_PATH . '/view/logovanje.php';
        }

    }
}