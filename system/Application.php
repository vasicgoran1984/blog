<?php
require_once 'system/Route.php';
class Application {
    
    public $variable = array();
    public $db = NULL;
    private $router;
    
    public function __construct() {
        $this->init();
    }
    
    public function env($key) {
        
        if(isset($this->variable[$key])) {
            return $this->variable[$key];
        } else {
            return NULL;
        }
    }
    
    public function init() {
        $this->citajEnv();
        $this->postaviRute();
    }
    
    public function citajEnv() {
        $file = fopen(BASE_PATH . "/.env","r");

        while(!feof($file))
        {
            $red = fgets($file);
            $niz = explode("=", $red);
            if (isset($niz[0]) && isset($niz[1])) {
                $this->setEnvVar(trim($niz[0]), trim($niz[1]));
            }
        }
        
    }
    
    public function setEnvVar($key, $value) {
        $this->variable[$key] = $value;
    }
    
    public function log($tip_poruke, $poruka) {
        echo "Greska '$tip_poruke': " . $poruka;
        die();
    }
    
    public function postaviRute() {
        $this->router = new Router();
        $this->router->add('', 'Index@home');
        $this->router->add('error', 'Index@error');
        $this->router->add('index/pocetna', 'Index@sviClanciPaginacija');
        $this->router->add('registracija/registruj-korisnika', 'Login@registracija');
        $this->router->add('login/logovanje', 'Login@logovanje');
        $this->router->add('login/logout', 'Login@logout');
        $this->router->add('login/promijeni-password', 'Login@promijeniPassword');
        $this->router->add('profil/moj-profil', 'Profil@editKorisnika');
        $this->router->add('profil/moj-profil-dodaj-sliku', 'Profil@dodajSliku');
        $this->router->add('profil/moj-profil-obrisi-sliku', 'Profil@obrisiSliku');
        $this->router->add('clanci/moji-clanci', 'Clanak@stranicaClanak');
        $this->router->add('clanci/ajax-prikazi-clanke', 'Clanak@prikaziClankeUTabeli');
        $this->router->add('clanci/dodaj-izmijeni-clanak', 'Clanak@dodajIzmijeniClanak');
        $this->router->add('clanci/snimi-clanak', 'Clanak@dodajIzmijeniClanak');
        $this->router->add('clanci/ajax-obrisi-clanak', 'Clanak@obrisiClanak');
        $this->router->add('index/ajax-index-pretraga', 'Index@sviClanciPaginacija');
        $this->router->add('clanak/procitaj-komentarisi', 'Clanak@procitajKomentarisiClanak');
        $this->router->add('clanak/obrisi-sliku', 'Clanak@obrisiSlikuClanka');
        $this->router->add('komentar/ajax-komentarisi-clanak', 'Komentar@komentarisiClanak');
        $this->router->add('utisci-clanka/ajax-upisi-utisak-clanka', 'UtisciClanka@upisiUtisakNaClanak');
        $this->router->add('utisci-komentara/ajax-upisi-utisak-komentara', 'UtisciKomentara@upisiUtisakNaKomentar');
        $this->router->add('clanak/pogledaj-sve-clanke', 'Clanak@pogledajSveClanke');
    }
    
    public function citajRutu($uri) {
    
        $data = explode("/", $uri);
        $parametri = array();
        
        if (count($data) > 2) {
            $controller = $data[0];
            $operation = $data[1];
            $uri = $controller . "/" . $operation;
            
            for ($i = 2; $i < count($data); $i+=2) {
                $parametri[$data[$i]] = !empty($data[$i+1]) ? $data[$i+1] : '';
            }
        
        }
        
        $id = (!empty($data['2'])) ? $data['2'] : '';
        
        $postoji_ruta = $this->router->route($uri, $parametri);
        
        if (!$postoji_ruta) {
            $this->router->route('error');
        }
    }
    
}