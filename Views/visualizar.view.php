<?php
session_start();

// Verificar se o usuário está autenticado
include_once "../autenticador.php";

// Incluindo o controlador de receitas
include_once "../controllers/receitas.controller.php";

$controller = new ReceitasController();

$id = $_GET['id'];
$receita = $controller->buscarPorId($id);

if (!$receita) {
    header('Location: /Trabalho2/receitas');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Visualizar Receita</title>
    <?php include 'head.php'; ?>
</head>
<body>

<!-- Barra de Navegação -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Sistema de Receitas</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="listar.view.php">Listar Receitas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adicionar.view.php">Adicionar Receita</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger" href="login.view.php?action=logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h1><?php echo $receita->getNome(); ?></h1>
    <hr>
    <h4>Ingredientes:</h4>
    <p><?php echo nl2br($receita->getIngredientes()); ?></p>
    
    <h4>Modo de Preparo:</h4>
    <p><?php echo nl2br($receita->getModoPreparo()); ?></p>

    <a href="editar.view.php?id=<?php echo $receita->getId(); ?>" class="btn btn-primary"><i class="fas fa-edit"></i> Editar Receita</a>
    <a href="listar.view.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar</a>
</div>

<!-- Scripts Bootstrap e jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
