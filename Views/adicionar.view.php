<?php
session_start();  // Iniciar a sessão no topo

// Verificar se o usuário está autenticado
include_once "./autenticador.php";

include_once "./Models/receitas.model.php";

// Verificar se o usuário é o admin
if ($_SESSION['usuario_logado'] !== 'admin') {
    echo "Acesso restrito ao administrador.";
    exit();
}

// Incluindo o controlador
include_once "./controllers/receitas.controller.php";

$controller = new ReceitasController();

// Verificação de envio de formulário
if (isset($_POST['nome'], $_POST['ingredientes'], $_POST['modo_preparo'])) {
    $nome = strip_tags(trim($_POST['nome']));
    $ingredientes = strip_tags(trim($_POST['ingredientes']));
    $modo_preparo = strip_tags(trim($_POST['modo_preparo']));

    $receita = new Receita($nome, $ingredientes, $modo_preparo);
    $controller->adicionar($receita);
    
    header('Location: /Trabalho2/receitas');
    exit();
}
?>

<!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <title>Adicionar Receita</title>
        <?php include 'head.php'; ?>
        <link rel="stylesheet" href="../estilos.css">
    </head>
    <body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Sistema de Receitas</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="../receitas">Listar Receitas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../receitas/adicionar">Adicionar Receita</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="login.view.php?action=logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4"><i class="fas fa-plus-circle"></i> Adicionar Receita</h1>

        <form action="adicionar.view.php" method="post">
            <div class="form-group">
                <label for="nome">Nome da Receita:</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="ingredientes">Ingredientes:</label>
                <textarea name="ingredientes" class="form-control" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="modo_preparo">Modo de Preparo:</label>
                <textarea name="modo_preparo" class="form-control" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Adicionar">
                <a href="javascript:history.back()" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left"></i> Voltar</a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>
</html>
