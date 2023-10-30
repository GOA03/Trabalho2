<?php

    // Carrega o autoload
    require_once __DIR__ . '/../vendor/autoload.php';

    use Pecee\SimpleRouter\SimpleRouter as Router;

    // Verifica o status da sessão
    if (session_status() == PHP_SESSION_NONE) {
        // Inicia a sessão
        session_start();
    }

    class LoginController {

        public static function authenticate() {
            $erro = '';  // Inicializa a variável de erro

            // Obtém conexão com o banco
            $bd = Conexao::get();

            // Lógica de autenticação
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['cadastrar'])) {
                $usuario = $_POST['usuario'] ?? '';
                $senha = $_POST['senha'] ?? '';

                // Prepara a consulta SQL
                $stmt = $bd->prepare("SELECT * FROM usuarios WHERE nome = :usuario");
                $stmt->bindParam(":usuario", $usuario);
                $stmt->execute();

                // Recupera o usuário do banco
                $usuarioBanco = $stmt->fetch(PDO::FETCH_OBJ);

                // Verifica a senha
                if ($usuarioBanco && password_verify($senha, $usuarioBanco->senha)) {
                    $_SESSION['autenticado'] = true;
                    $_SESSION['usuario_logado'] = $usuario;
                    header('Location: /Trabalho2/receitas');
                    exit();
                } else {
                    $erro = "Credenciais inválidas!";
                }
            }

            // Redireciona conforme autenticação
            if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true) {
                header('Location: /Trabalho2/receitas');
                exit();
            } else {
                include_once __DIR__ . "/../views/login.view.php";
            }
        }

        public static function logout() {
            // Realiza o logout do usuário
            $_SESSION['autenticado'] = false;
            session_unset();
            session_destroy();
            header('Location: /Trabalho2/views/login.view.php');  // caminho absoluto
            exit();
        }

        public static function cadastrar() {
            $erro = '';  // Inicializa a variável de erro

            // Obtém conexão com o banco
            $bd = Conexao::get();

            // Lógica de cadastro
            if (isset($_POST['cadastrar'])) {
                $usuario = $_POST['usuario'] ?? '';
                $senha = $_POST['senha'] ?? '';

                // Prepara a consulta SQL
                $stmt = $bd->prepare("SELECT * FROM usuarios WHERE nome = :usuario");
                $stmt->bindParam(":usuario", $usuario);
                $stmt->execute();

                // Verifica se o usuário já existe
                $usuarioExistente = $stmt->fetch(PDO::FETCH_OBJ);

                // Cadastra o novo usuário
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

            // Redireciona para a página de login
            include_once __DIR__ . "/../views/login.view.php";
        }
    }

    // Define a ação conforme o método da requisição
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
