<?php

    session_start();

    // Incluir controlador de receitas
    $controller = new ReceitasController();

    // Buscar a receita pelo ID
    $receita = $controller->buscarPorId($id);

    // Verificar se a receita foi encontrada
    if (!$receita) {
        echo "Receita não encontrada. ID: " . (is_null($id) ? "Não fornecido" : $id);
        exit();
    }
    ?>

    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <title>Visualizar Receita</title>
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
        <h1><?php echo $receita->getNome(); ?></h1>
        <hr>
        <h4>Ingredientes:</h4>
        <p><?php echo nl2br($receita->getIngredientes()); ?></p>
        
        <h4>Modo de Preparo:</h4>
        <p><?php echo nl2br($receita->getModoPreparo()); ?></p>

        <a href="/Trabalho2/receitas/editar/<?php echo $receita->getId(); ?>" class="btn btn-primary"><i class="fas fa-edit"></i> Editar Receita</a>
        <a href="javascript:history.back()" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left"></i> Voltar</a>
    </div>

    <!-- Scripts Bootstrap e jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>
</html>
