<?php

// Verificando o status da sessão
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar se o usuário está autenticado
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    // Se não autenticado, redirecione para a página de login
    header('Location: login.view.php');
    exit();
}
