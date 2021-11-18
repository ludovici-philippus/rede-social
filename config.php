<?php 
    session_start();
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set("America/Sao_Paulo");
    require("vendor/autoload.php");
    
    $autoload = function($class){
        $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
        include("classes/$class.php");
    };

    spl_autoload_register($autoload);

    define("INCLUDE_PATH", "http://localhost/desenvolvimento-web-tradicional/rede-social/");

    define("INCLUDE_PATH_PAINEL", INCLUDE_PATH.'painel/');

    define("BASE_DIR", __DIR__."/painel");

    define("NOME_EMPRESA", "CodeSpirit");

    //Banco de dados
    define("HOST", "localhost");
    define("USER", "root");
    define("PASSWORD", "");
    define("DATABASE", "projeto_01");

    function verifica_permissao_menu($permissao){
        if($_SESSION['cargo'] >= $permissao){
            return;
        }
        echo "style='display:none'";
    }

    function verifica_permissao_pagina($permissao){
        if($_SESSION['cargo'] >= $permissao){
            return;
        }
        include("painel/pages/permissao-negada.php");
        die();
    }
?>