<?php

// Inicialização da sessão
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//Sessão para o usuário admin
if(!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [
        'admin' => password_hash("123456", PASSWORD_DEFAULT)
    ];
}

$erro = '';

// Lógica de autenticação
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Verificar credenciais
    if (isset($_SESSION['usuarios'][$usuario]) && password_verify($senha, $_SESSION['usuarios'][$usuario])) {
        $_SESSION['autenticado'] = true;
        $_SESSION['usuario_logado'] = $usuario;
        header('Location: ../views/listar.view.php');
        exit();
    } else {
        $erro = "Credenciais inválidas!";
    }
}

// Lógica de logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    $_SESSION['autenticado'] = false;
    // Destroi todos os dados associados à sessão atual.
    session_unset();
    session_destroy();
    // Redireciona para a página de login.
    header('Location: ../views/login.view.php');
    exit();
}

// Lógica de cadastro
if (isset($_POST['cadastrar'])) {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';
    if (!isset($_SESSION['usuarios'][$usuario])) { //se o usuário não existir na sessão
        $_SESSION['usuarios'][$usuario] = password_hash($senha, PASSWORD_DEFAULT); // Hasheando a senha
        $erro = "Cadastro realizado com sucesso!";
    } else {
        $erro = "Usuário já existente!";
    }
}

// Verificar se o usuário já está autenticado
if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true) {
    header('Location: ../views/listar.view.php');
    exit();
} else {
    include_once "../views/login.view.php";
}