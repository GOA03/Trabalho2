<?php

    // Inicia a sessão
    session_start();

    // Inclui as dependências
    include_once "./autenticador.php";
    include_once "./Models/receitas.model.php";
    include_once "./controllers/receitas.controller.php";

    // Verifica se o usuário autenticado é 'admin'
    if ($_SESSION['usuario_logado'] !== 'admin') {
        echo "Acesso restrito ao administrador.";
        exit();
    }

    // Instancia o controller de receitas
    $controller = new ReceitasController();

    // Processa o formulário, se a requisição for POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = strip_tags(trim($_POST['nome'] ?? ''));
        $ingredientes = strip_tags(trim($_POST['ingredientes'] ?? ''));
        $modo_preparo = strip_tags(trim($_POST['modo_preparo'] ?? ''));

        if (!empty($nome) && !empty($ingredientes) && !empty($modo_preparo)) {
            $receita = new Receita($nome, $ingredientes, $modo_preparo);
            
            // Exibe dados da receita (para debug)
            var_dump($receita);

            // Adiciona a receita
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
        <?php 
        // Inclui o cabeçalho padrão
        include 'head.php'; 
        ?>
        <link rel="stylesheet" href="../estilos.css">
    </head>

    <body>

        <!-- Inclui a barra de navegação -->
        <?php include 'navegacao.php'; ?>

        <!-- Conteúdo Principal -->
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

        <!-- Scripts Bootstrap e jQuery -->
        <?php include 'bootstrapJQuery.php'; ?>

    </body>
</html>