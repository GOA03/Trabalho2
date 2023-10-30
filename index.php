<?php

    require "vendor/autoload.php";

    use Pecee\SimpleRouter\SimpleRouter as Router;

    
    // Rota padrão redireciona para o login
    Router::get('/Trabalho2/', function() {
        // Se estiver autenticado, redireciona para a lista de receitas.
        if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true) {
            require './views/listar.view.php';
        } else { // Se não, redireciona para o login.
            require __DIR__ . '/views/login.view.php';
        }
    });

    // Rotas do index para Login 
    Router::get('/Trabalho2/index.php', function() {
        require './views/login.view.php';
    });

    // Rota para visualizar uma receita específica
    Router::get('/Trabalho2/receitas/visualizar/{id}', 'ReceitasController@visualizar');
    
    // Rota para editar uma receita específica
    Router::get('/Trabalho2/receitas/editar/{id}', 'ReceitasController@editar');

    // Rotas de Login e Logout
    Router::get('/Trabalho2/login', function() {
        require __DIR__ . '/views/login.view.php';
    });


    Router::post('/Trabalho2/login', 'LoginController@authenticate');
    Router::get('/Trabalho2/logout', 'LoginController@logout');

    // Rotas de listar as receitas
    Router::get('/Trabalho2/receitas', function() {
        require './views/listar.view.php';
    });

    Router::get('/Trabalho2/receitas/adicionar', function() {
        require './views/adicionar.view.php';
    });


    Router::post('/Trabalho2/receitas/adicionar', 'ReceitasController@adicionar');
    Router::post('/Trabalho2/receitas/editar/{id}', 'ReceitasController@editar');

    ///*
    //Teste do professor :)
    Router::get('Trabalho2/ping', function() {
        echo "Pong!";
    });
    //*/

    Router::start();

?>