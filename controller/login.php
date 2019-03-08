<?php
    require_once 'db_konekcija/db_konekcija.php';

    class Login {

        /*
         * Prijava korisnika
         */
        function logovanje() {
            global $konekcija;
            
            if (isset($_POST['login'])) {

                if (isset($_POST['korisnicko_ime']) && isset($_POST['password'])) {
                    $greske = array();
                    $korisnicko_ime = $_POST['korisnicko_ime'];
                    $password = $_POST['password'];
                    $hash = hash('sha256', $password);

                    include 'model/registracijaModel.php';
                    $loguj_korisnika = new RegistrujKorisnika($konekcija);
                    $provjeri_korisnicko_ime = $loguj_korisnika->provjeriKorisnickoIme($korisnicko_ime);

                    if ($provjeri_korisnicko_ime) {
                        $rezultat = $loguj_korisnika->logujKorisnika($korisnicko_ime, $hash);    
                        if(!is_null($rezultat)) {   
                            $_SESSION['korisnik'] = $rezultat;
                            header("Location: ". BASE_URL . 'index.php?controller=index&operation=home');
                            die();
                        } else {
                            { array_push($greske, 'Password nije validan, molimo da pokusate ponovo.'); }
                            include BASE_PATH . '/view/logovanje.php';
                        }
                    } else {
                        { array_push($greske, 'Korisnik nije registrovan, molimo da se prvo registrujete, hvala.'); }
                        include BASE_PATH . '/view/logovanje.php';
                    }
                }
            } else {
                include BASE_PATH . '/view/logovanje.php';
            }
        }

        /*
         * Odjava korisnika
         */
        public function logout() {
            session_unset();
            session_destroy();
            header("Location: ". BASE_URL);
        }

        /*
         * Registracija korisnika
         */
        function registracija() {
            global $konekcija;
          
            if (isset($_POST['register'])) {
                $ime                = $_POST['ime'];
                $prezime            = $_POST['prezime'];
                $korisnicko_ime     = $_POST['korisnicko_ime'];
                $email              = $_POST['email'];
                $password           = $_POST['password'];
                $password_potvrda   = $_POST['password_potvrda'];
                $greske = array();

                if (empty($ime))                    { array_push($greske, 'Ime je obavezno polje'); }
                if (empty($prezime))                { array_push($greske, 'Prezime je obavezno polje'); }
                if (empty($korisnicko_ime))         { array_push($greske, 'Korisnicko ime je obavezno polje'); }
                if (empty($email))                  { array_push($greske, 'Email je obavezno polje'); }
                if ($password != $password_potvrda) { array_push($greske, "Passwordi se ne podudaraju!"); }
                if ($password == $password_potvrda) {
                    $hash = hash('sha256', $password);
                }
                if (count($greske) > 0) {
                    include BASE_PATH . '/view/registracija.php';
                } else {
                    include 'model/registracijaModel.php';
                    $registruj_korisnika = new RegistrujKorisnika($konekcija);
                    $slobodno_korisnicko_ime = $registruj_korisnika->SlobodnoKorisnickoIme($korisnicko_ime);
                    if (!$slobodno_korisnicko_ime) {
                        $rezultat = $registruj_korisnika->registrujNovogKorisnika($ime, $prezime, $korisnicko_ime, $email, $hash);
                        if ($rezultat) {
                            include BASE_PATH . '/view/logovanje.php';
                        }
                    } else {
                        array_push($greske, 'Korisnicko ime je vec zauzeto. Molimo da unesete drugo.');
                        include BASE_PATH . '/view/registracija.php';
                    }
                }
            } else {
                include BASE_PATH . '/view/registracija.php';
            }
        }

        /*
         * Promijeni password
         */
        public function promijeniPassword() {
            global $konekcija;
            
            include 'model/registracijaModel.php';
            $promjena = new RegistrujKorisnika($konekcija);
            
            if (isset($_POST['promijeni_password']) && !empty($_POST['promijeni_password'])) {
                
                if (isset($_POST['korisnicko_ime']) && !empty($_POST['korisnicko_ime'])) {
                    $greske = array();
                    $korisnicko_ime = $_POST['korisnicko_ime'];
                    $rezultat = $promjena->provjeriKorisnickoIme($korisnicko_ime);
                }
                if (!$rezultat) {
                    $greske = 'Korisnik nije registrovan, molimo da se prvo registrujete, hvala.';
                    include BASE_PATH . '/view/promijeniPassword.php';
                } else {
                    if (isset($_POST['stari_password']) && !empty($_POST['stari_password'])) {
                        
                        $stari_password   = $_POST['stari_password'];
                        $hash = hash('sha256', $stari_password);
                        $rezultat = $promjena->provjeriPassword($korisnicko_ime, $hash);
                       
                        if (!$rezultat) {
                            $greske = 'Stari password nije validan, pokusajte ponovo. Hvala.';
                            include BASE_PATH . '/view/promijeniPassword.php';
                        } else {
                            
                            if ((isset($_POST['novi_password']) && !empty($_POST['novi_password'])) && 
                                (isset($_POST['password_potvrda']) && !empty($_POST['password_potvrda']))) {
                                $novi_password = $_POST['novi_password'];
                                $password_potvrda = $_POST['password_potvrda'];
                                
                                if ($novi_password != $password_potvrda) {
                                    $greske = 'Novi password se ne podudara, pokusajte ponovo. Hvala.';
                                    include BASE_PATH . '/view/promijeniPassword.php';
                                    
                                } else {
                                    $hash = hash('sha256', $novi_password);
                                    $rezultat = $promjena->promijeniPassword($korisnicko_ime, $hash);
                                    if ($rezultat) {
                                        $greske = 'Novi password je uspjesno promijenjen. Hvala.';
                                    include BASE_PATH . '/view/logovanje.php';
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                include BASE_PATH . '/view/promijeniPassword.php';
            }
        }
    }