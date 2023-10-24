<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Inicializa a sessão, se ainda não estiver ativa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$erro = ''; // Para armazenar mensagens de erro

// Utiliza a classe Conexao diretamente
$bd = Conexao::get(); // Obtém a conexão com o banco

// Lógica de autenticação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['cadastrar'])) {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $stmt = $bd->prepare("SELECT * FROM usuarios WHERE nome = :usuario");
    $stmt->bindParam(":usuario", $usuario);
    $stmt->execute();

    $usuarioBanco = $stmt->fetch(PDO::FETCH_OBJ);

    if ($usuarioBanco && password_verify($senha, $usuarioBanco->senha)) {
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
    session_unset();
    session_destroy();
    header('Location: ../views/login.view.php');
    exit();
}

// Lógica de cadastro
if (isset($_POST['cadastrar'])) {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $stmt = $bd->prepare("SELECT * FROM usuarios WHERE nome = :usuario");
    $stmt->bindParam(":usuario", $usuario);
    $stmt->execute();

    $usuarioExistente = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$usuarioExistente) {
        $hashedSenha = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $bd->prepare("INSERT INTO usuarios (nome, senha) VALUES (:nome, :senha)");
        $stmt->bindParam(":nome", $usuario);
        $stmt->bindParam(":senha", $hashedSenha);
        $stmt->execute();
        $erro = "Cadastro realizado com sucesso!";
    } else {
        $erro = "Usuário já existente!";
    }
}

// Redireciona conforme o estado de autenticação do usuário
if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true) {
    header('Location: ../views/listar.view.php');
    exit();
} else {
    include_once "../views/login.view.php";
}
?>
