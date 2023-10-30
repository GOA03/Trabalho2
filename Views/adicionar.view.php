<?php
session_start();

include_once "./autenticador.php";
include_once "./Models/receitas.model.php";
include_once "./controllers/receitas.controller.php";

// Verificar autenticação
if ($_SESSION['usuario_logado'] !== 'admin') {
    echo "Acesso restrito ao administrador.";
    exit();
}

$controller = new ReceitasController();

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = strip_tags(trim($_POST['nome'] ?? ''));
    $ingredientes = strip_tags(trim($_POST['ingredientes'] ?? ''));
    $modo_preparo = strip_tags(trim($_POST['modo_preparo'] ?? ''));

    if (!empty($nome) && !empty($ingredientes) && !empty($modo_preparo)) {
        $receita = new Receita($nome, $ingredientes, $modo_preparo);

        var_dump($receita);

        $controller->adicionar($receita);

        echo "Receita adicionada com sucesso!";
        header('Location: /Trabalho2/receitas');
        exit();
    } else {
        echo "Por favor, preencha todos os campos.";
    }
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

<!-- Barra de Navegação -->
<?php include 'navegacao.php'; ?>

<div class="container mt-5">
    <h1 class="mb-4"><i class="fas fa-plus-circle"></i> Adicionar Receita</h1>

    <form action="/Trabalho2/receitas/adicionar" method="post">
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
