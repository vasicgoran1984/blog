<?php

class Router {

    private $uri = array();

    public function add($uri, $controller_action) {
        $this->uri[$uri] = trim($controller_action);
    }

    public function route($uri, $parametri = NULL) {
            
        if (isset($this->uri[$uri])) {
            $controller_action = $this->uri[$uri];
            $niz = explode('@', $controller_action);
            
            $controller = $niz[0];
            $operation  = $niz[1];

            $controller_file = BASE_PATH . '/controller/' . $controller . '.php';
            
            if (file_exists($controller_file)) {
                
                require_once($controller_file);
                $class = new $controller();
                
                $class->$operation($parametri);
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

}
