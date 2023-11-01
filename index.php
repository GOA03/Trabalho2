<?php

    require "vendor/autoload.php";

    use Pecee\SimpleRouter\SimpleRouter as Router;

    // - - - - - - - - - - - - - - - - - - - ( L O G I N ) - - - - - - - - - - - - - - - - - - 

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

    // Rotas de Login
    Router::get('/Trabalho2/login', function() {
        require __DIR__ . '/views/login.view.php';
    });

    // Rotas de autenticação de Login
    Router::post('/Trabalho2/login', 'LoginController@authenticate');

    // - - - - - - - - - - - - - - - - - - ( L O G O U T ) - - - - - - - - - - - - - - - - - - 

    Router::get('/Trabalho2/logout', 'LoginController@logout');

    // - - - - - - - - - - - - - - - - ( V I S U A L I Z A R ) - - - - - - - - - - - - - - - - 

    // Rota para visualizar uma receita específica
    Router::get('/Trabalho2/receitas/visualizar/{id}', 'ReceitasController@visualizar');

    // - - - - - - - - - - - - - - - - - - ( E D I T A R ) - - - - - - - - - - - - - - - - - -
    
    // Rotas para editar uma receita específica
    Router::get('/Trabalho2/receitas/editar/{id}', 'ReceitasController@editar');
    Router::post('/Trabalho2/receitas/editar/{id}', 'ReceitasController@editar');

    // - - - - - - - - - - - - - - - - - - ( L I S T A R ) - - - - - - - - - - - - - - - - - -

    // Rota de listar as receitas
    Router::get('/Trabalho2/receitas', function() {
        require './views/listar.view.php';
    });

    // - - - - - - - - - - - - - - - - - ( A D I C I O N A R ) - - - - - - - - - - - - - - - -

    Router::get('/Trabalho2/receitas/adicionar', function() {
        require './views/adicionar.view.php';
    });

    Router::post('/Trabalho2/receitas/adicionar', 'ReceitasController@adicionar');

    // - - - - - - - - - - - - - - - - - - ( T E S T E ) - - - - - - - - - - - - - - - - - - -

    //Teste do professor :)
    Router::get('Trabalho2/ping', function() {
        echo "Pong!";
    });

    // - - - - - - - - - - - - - - - - - - ( S T A R T ) - - - - - - - - - - - - - - - - - - -

    Router::start();

?>