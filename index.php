<?php

    session_start();
    
    require_once 'db_konekcija/db_konekcija.php';
    
    $path = rtrim('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'], 'index.php');

    DEFINE("BASE_URL", $path);
    DEFINE("BASE_PATH", getcwd());

    $controller = isset($_REQUEST['controller']) ? $_REQUEST['controller'] : NULL;
    $operation  = isset($_REQUEST['operation']) ? $_REQUEST['operation'] : NULL;

    if (is_null($controller) || is_null($operation)) {
        $controller = 'index';
        $operation = 'home';
    } 

    $controller_file = BASE_PATH . '/controller/' . $controller . '.php';
    
    if (!file_exists($controller_file)) {
        $controller = 'index';
        $operation  = 'error';
    }

    require_once(BASE_PATH . '/controller/' . $controller . '.php');

    $class = new $controller();
    $class->$operation();
    
    unset($_SESSION['greska']);
    mysqli_close($konekcija);
?>