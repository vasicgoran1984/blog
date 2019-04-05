<?php
require_once 'model/registracijaModel.php';

class Login {

    /*
     * Prijava korisnika
     */
    function logovanje() {

        if (isset($_POST['login'])) {

            if (isset($_POST['korisnicko_ime']) && isset($_POST['password'])) {
                $greske = array();
                $korisnicko_ime = $_POST['korisnicko_ime'];
                $password = $_POST['password'];
                $hash = hash('sha256', $password);
                
                $loguj_korisnika = new RegistrujKorisnika();
                $provjeri_korisnicko_ime = $loguj_korisnika->provjeriKorisnickoIme($korisnicko_ime);

                if ($provjeri_korisnicko_ime) {
                    $rezultat = $loguj_korisnika->logujKorisnika($korisnicko_ime, $hash);    
                    if(!is_null($rezultat)) {   
                        $_SESSION['korisnik'] = $rezultat;
                        header("Location: " . BASE_URL);
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
   
        if (isset($_POST['register'])) {

            $podaci_reg = array();

            if (isset($_POST['ime'])) {
                $podaci_reg['ime'] = $_POST['ime'];
            }

            if (isset($_POST['prezime'])) {
                $podaci_reg['prezime'] = $_POST['prezime'];
            }

            if (isset($_POST['korisnicko_ime'])) {
                $podaci_reg['korisnicko_ime'] = $_POST['korisnicko_ime'];
            }

            if (isset($_POST['email'])) {
                $podaci_reg['email'] = $_POST['email'];
            }

            if (isset($_POST['password'])) {
                $podaci_reg['password'] = $_POST['password'];
            }

            if (isset($_POST['password_potvrda'])) {
                $podaci_reg['password_potvrda'] = $_POST['password_potvrda'];
            }

            $noviNiz = array(
                        'ime'              => $_POST['ime'],
                        'prezime'          => $_POST['prezime'],
                        'korisnicko_ime'   => $_POST['korisnicko_ime'],
                        'email'            => $_POST['email'],
                        'password'         => $_POST['password'],
                        'password_potvrda' => $_POST['password_potvrda']
                    );
            $validacija = new Validation();
            $registracija = $validacija->validateRegister($podaci_reg);

            if (!empty($registracija)) {
                $greske = $registracija;

                $rezultat = new ORM();
                $rezultat->set($noviNiz);
                include BASE_PATH . '/view/registracija.php';

            } else {

                $registruj_korisnika = new RegistrujKorisnika();
                $slobodno_korisnicko_ime = $registruj_korisnika->SlobodnoKorisnickoIme($podaci_reg['korisnicko_ime']);

                if (!$slobodno_korisnicko_ime) {

                    if ($podaci_reg['password'] == $podaci_reg['password_potvrda']) {
                        $hash = hash('sha256', $podaci_reg['password']);
                    }
                    $rezultat = $registruj_korisnika->registrujNovogKorisnika($podaci_reg['ime'], $podaci_reg['prezime'], $podaci_reg['korisnicko_ime'], $podaci_reg['email'], $hash);
                    if ($rezultat) {
                        $greske[] = 'Uspjesno ste se registrovali, molimo Vas da se logujete.';
                        include BASE_PATH . '/view/logovanje.php';
                    }
                } else {
                    $greske[] = 'Korisnicko ime je vec zauzeto. Molimo da unesete drugo.';
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
 
        $promjena = new RegistrujKorisnika();

        if (isset($_POST['promijeni_password'])) {
            
            $podaci_resset = array();
            
            if (isset($_POST['korisnicko_ime'])) {
                $podaci_resset['korisnicko_ime'] = $_POST['korisnicko_ime'];
            }

            if (isset($_POST['stari_password'])) {
                $podaci_resset['stari_password'] = $_POST['stari_password'];
            }
            
            if (isset($_POST['novi_password'])) {
                $podaci_resset['novi_password'] = $_POST['novi_password'];
            }

            if (isset($_POST['password_potvrda'])) {
                $podaci_resset['password_potvrda'] = $_POST['password_potvrda'];
            }
            
            $validacija = new Validation();
            $resset = $validacija->validateResetPass($podaci_resset);

            if (!empty($resset)) {

                $greske = $resset;

                $noviNiz = array(
                    'korisnicko_ime'   => $_POST['korisnicko_ime'],
                    'stari_password'   => $_POST['stari_password'],
                    'novi_password'    => $_POST['novi_password'],
                    'password_potvrda' => $_POST['password_potvrda']
                );

                $rezultat = new ORM();
                $rezultat->set($noviNiz);

            } else {
                
                $rezultat = $promjena->provjeriKorisnickoIme($podaci_resset['korisnicko_ime']);
                
                if (!$rezultat) {
                    $greske[] = 'Korisnik nije registrovan, molimo da se prvo registrujete, hvala.';
                } else {
                    $stari_password   = $podaci_resset['stari_password'];
                    $hash = hash('sha256', $stari_password);
                    $rezultat = $promjena->provjeriPassword($podaci_resset['korisnicko_ime'], $hash);
                    
                    if (!$rezultat) {
                        $greske[] = 'Vas trenutni password nije validan! Pokusajte ponovo, hvala.';
                    } else {
                        $hash = hash('sha256', $podaci_resset['novi_password']);
                        $rezultat = $promjena->promijeniPassword($podaci_resset['korisnicko_ime'], $hash);
                        
                        if ($rezultat) {
                            $greske[] = 'Novi password je uspjesno promijenjen!';
                            include BASE_PATH . '/view/logovanje.php';
                            die();
                        }
                    }
                }
            }
        }
        include BASE_PATH . '/view/promijeniPassword.php';
    }
}