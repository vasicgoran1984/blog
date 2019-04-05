<?php
    session_start();
    require_once 'system/Application.php';
    require_once 'system/DB.php';
    require_once 'system/ORM.php';
    require_once 'system/Collection.php';
    require_once 'system/Helper.php';
    require_once 'system/ImportFiles.php';
    require_once 'system/DeleteImage.php';
    
    $path = rtrim('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'], 'index.php');

    DEFINE("BASE_URL", $path);
    DEFINE("BASE_PATH", getcwd());
    
    $uri  = isset($_GET['uri']) ? $_GET['uri'] : '';
    $data = isset($data) ? $data : '';
    
    $app = new Application();
    $app->citajRutu($uri, $data);
    
?>