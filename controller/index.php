<?php
    require_once 'db_konekcija/db_konekcija.php';
    
    class Index {
        
        public function home() {
            include BASE_PATH . '/view/index.php';
        }
        
        public function sviClanciPaginacija () {
            global $konekcija;
            include 'model/clanakModel.php';
            $clanak = new ClanakModel($konekcija);
            
            $greske        = array();
            $datum_od      = '';
            $datum_do      = '';
            $ime_prezime   = '';
            $kljucna_rijec = '';
            
            if (isset($_POST['po_strani'])) {
                $po_strani= $_POST['po_strani'];
            }
            
            if (!isset($_POST['stranica'])) {
                $stranica = 1;
            } else {
                $stranica = $_POST['stranica'];
            }
            
            if (isset($_POST['kljucna_rijec'])) {
                $kljucna_rijec = trim($_POST['kljucna_rijec']);
            }
            
            if (isset($_POST['datum_od']) && !empty($_POST['datum_od'])) {
                $datum_od = $_POST['datum_od'];
                $datum_od = date("Y-m-d", strtotime($datum_od));
            }
            
            if (isset($_POST['datum_do']) && !empty($_POST['datum_do'])) {
                $datum_do = $_POST['datum_do'];
                $datum_do = date("Y-m-d", strtotime($datum_do));
            }
            
            if (!empty($datum_od && $datum_do) && $datum_do < $datum_od) {
                $greske[] = "Datumi nisu ispravno uneseni, pokusajte ponovo. Hvala";
                include BASE_PATH . '/view/pretragaClankaPaginacija.php';
                
            } else {
                if (isset($_POST['ime_prezime']) && !empty($_POST['ime_prezime'])) {

                    $ime_prezime = $_POST['ime_prezime'];  
                    $duzina = str_word_count($ime_prezime);

                     if ($duzina > 2) {
                        $greske[] = "Unesite jednu ili dvije rijeci za pretragu.";
                        include BASE_PATH . '/view/pretragaClanaka.php';
                    } else {
                        function ogranici_text($tekst, $granica) {
                        if (str_word_count($tekst, 0) > $granica) {
                            $rijeci = str_word_count($tekst, 2);
                            $niz = array_keys($rijeci);
                            $tekst = substr($tekst, 0, $niz[$granica]);
                            }
                            return $tekst;
                        }
                        $ime_prezime = trim(ogranici_text($ime_prezime, 2));
                    }
                }
                $sviObjavljeniClanci = $clanak->sviObjavljeniClanciPaginacija($po_strani, $stranica, $ime_prezime, $datum_od, $datum_do, $kljucna_rijec);
                include BASE_PATH . '/view/pretragaClankaPaginacija.php';
            }
        }

        public function error() {
            include BASE_PATH . '/view/404.php';
        }
    }