<?php
    session_start();  // Inicia a sessão 

    // Verificar se o usuário está autenticado
    include_once "./autenticador.php";

    // Verificar se o usuário é o admin
    if ($_SESSION['usuario_logado'] !== 'admin') {
        echo "Acesso restrito ao administrador.";
        exit();
    }

    // Incluindo o controlador
    $controller = new ReceitasController();
    

    // Se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'] ?? '';
        $ingredientes = $_POST['ingredientes'] ?? '';
        $modo_preparo = $_POST['modo_preparo'] ?? '';
        $idReceita = $_POST['id'] ?? null;

        $receita = new Receita($nome, $ingredientes, $modo_preparo, $idReceita);
        $controller->editar($receita);
            
        header('Location: /Trabalho2/receitas');
        exit();
    }

    $receita = $controller->buscarPorId($id);

?>

<!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <title>Editar Receita</title>
        <?php include 'head.php'; ?>
        <style> /* Movi os estilos para cá devido a view não usar o css do head, não sei pq :) */
            body {
                font-family: 'Trebuchet MS', sans-serif;
                background-color: #FFF8E5;
                margin: 0;
                padding: 0;
            }

            .container {
                background-color: rgba(255, 255, 255, 0.95); /* Fundo semi-transparente. */
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            .navbar, .navbar-light {
                background-color: #FFDAB9 !important; /* Cor de pêssego. */
            }

            .nav-link {
                color: #8B4513 !important; /* Cor marrom, similar ao chocolate. */
            }

            .nav-link:hover, .nav-link:focus {
                color: #5E2605 !important;
            }

            h1, h2 {
                color: #8B4513; /* Marrom chocolate. */
                text-align: center;
            }

            .btn-primary {
                background-color: #D2691E;
                border-color: #D2691E;
                color: white;
            }

            .btn-primary:hover {
                background-color: #8B4513;
                border-color: #8B4513;
            }

            .btn-secondary {
                background-color: #FFE4B5;
                border-color: #FFE4B5;
            }

            .btn-secondary:hover {
                background-color: #FFD39B;
                border-color: #FFD39B;
            }

        </style>
    </head>
    <body>

    <!-- Barra de Navegação -->
    <?php include 'navegacao.php'; ?>

    <div class="container mt-5">
        <h1>Editar Receita</h1>
        <form action="/Trabalho2/receitas/editar/<?php echo $receita->getId(); ?>" method="post">
            <div class="form-group">
                <label>Nome da Receita</label>
                <input type="text" name="nome" class="form-control" value="<?php echo $receita->getNome(); ?>" required>
            </div>
            <div class="form-group">
                <label>Ingredientes</label>
                <textarea name="ingredientes" class="form-control" rows="5" required><?php echo $receita->getIngredientes(); ?></textarea>
            </div>
            <div class="form-group">
                <label>Modo de Preparo</label>
                <textarea name="modo_preparo" class="form-control" rows="5" required><?php echo $receita->getModoPreparo(); ?></textarea>
            </div>
            <input type="hidden" name="id" value="<?php echo $receita->getId(); ?>">
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="/Trabalho2/receitas" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left"></i> Voltar</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>
</html>
