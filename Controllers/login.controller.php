<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Pecee\SimpleRouter\SimpleRouter as Router;

// Inicializa a sessão, se ainda não estiver ativa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Importa a classe de conexão (substitua "SeuNamespace" pelo namespace real do seu projeto)
use Conexao;

class LoginController {

    public static function authenticate() {
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
                header('Location: /Trabalho2/receitas');
                exit();
            } else {
                $erro = "Credenciais inválidas!";
            }
        }

        // Redireciona conforme o estado de autenticação do usuário
        if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true) {
            header('Location: /Trabalho2/receitas');
            exit();
        } else {
            include_once __DIR__ . "/../login";
        }
    }

    public static function logout() {
        // Lógica de logout
        $_SESSION['autenticado'] = false;
        session_unset();
        session_destroy();
        header('Location: /Trabalho2/views/login.view.php');  // caminho absoluto
        exit();
    }

    public static function cadastrar() {
        $erro = ''; // Para armazenar mensagens de erro

        // Utiliza a classe Conexao diretamente
        $bd = Conexao::get(); // Obtém a conexão com o banco

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

        // Redireciona para a página de login após o cadastro
        include_once __DIR__ . "/../views/login.view.php";
    }
}

// Chama a função apropriada com base na rota
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cadastrar'])) {
        LoginController::cadastrar();
    } else {
        LoginController::authenticate();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'logout') {
    LoginController::logout();
}
?>
