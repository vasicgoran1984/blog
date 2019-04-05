<?php

class Komentar {

    public function komentarisiClanak() {

        if (isset($_SESSION['korisnik']['id'])) {

            include 'model/clanakModel.php';  
            include 'model/komentarModel.php'; 
            include 'model/utisakClankaModel.php';
            include 'model/utisakKomentaraModel.php';

            $clanak          = new ClanakModel();
            $komentar        = new KomentarModel();
            $utisakClanka    = new utisakClankaModel();
            $utisakKomentara = new utisakKomentaraModel();

            $rezultat = $clanak->prikaziClanakPoIdu($_POST['clanak_id']);
            $kojiUtisakPostoji = $utisakClanka->kojiUtisakPostoji($_SESSION['korisnik']['id'], $_POST['clanak_id']);
            $clanakSaKomentarima = $komentar->clanakSaKomentarima($_POST['clanak_id'], $_SESSION['korisnik']['id']);

            if (isset($_POST['clanak_id'])) {
                $clanak_id = $_POST['clanak_id'];

                $korisnik_id = $_SESSION['korisnik']['id'];
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
                        $clanakSaKomentarima = $komentar->clanakSaKomentarima($_POST['clanak_id'], $_SESSION['korisnik']['id']);
                        exit (json_encode(array(
                            'status'       => true,
                            'komentar'     => $noviKomentar,
                            'komentarisao' => $_SESSION['korisnik']['ime'] . ' ' . $_SESSION['korisnik']['prezime']
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

