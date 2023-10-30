<?php

    // Inicia a sessão
    session_start();

    // Inclui o autenticador
    include_once("./autenticador.php");

    // Instancia o controller de receitas
    $controller = new ReceitasController();

    // Verifica a ação de exclusão
    if (isset($_GET['action']) && $_GET['action'] == 'excluir' && isset($_GET['id'])) {
        if ($_SESSION['usuario_logado'] === 'admin') {
            $controller->remover($_GET['id']);
            header('Location: /Trabalho2/receitas');
            exit();
        } else {
            echo "Acesso restrito ao administrador.";
            exit();
        }
    }

    // Lista as receitas
    $receitas = $controller->listar();

?>

<!DOCTYPE html>

    <html lang="pt-BR">

    <head>
        <title>Listar Receitas</title>
        <?php 
        // Inclui o cabeçalho
        include 'head.php'; 
        ?>
    </head>

    <body>

        <!-- Inclui a barra de navegação -->
        <?php include 'navegacao.php'; ?>

        <!-- Conteúdo principal -->
        <div class="container mt-5">
            <h1 class="mb-4"><i class="fas fa-utensils"></i> Lista de Receitas</h1>
            
            <!-- Verifica se há receitas cadastradas -->
            <?php if(count($receitas) == 0): ?>
                <div class="alert alert-warning">
                    Nenhuma receita foi adicionada ainda.
                </div>
            <?php else: ?>
                <div class="row">
                    <!-- Percorre as receitas e as exibe -->
                    <?php foreach($receitas as $receita): ?>
                        <div class="col-md-4 mb-4">
                            <div class="receita-card p-4 d-flex flex-column justify-content-between align-items-center">
                                <a href="/Trabalho2/receitas/visualizar/<?php echo $receita->getId(); ?>" class="list-item-link <?php echo ($_SESSION['usuario_logado'] !== 'admin') ? 'no-admin' : ''; ?>">
                                    <?php echo $receita->getNome(); ?>
                                </a>
                                <span>
                                    <?php if ($_SESSION['usuario_logado'] === 'admin'): ?>
                                        <!-- Botões de editar e excluir para o admin -->
                                        <a href="/Trabalho2/receitas/editar/<?php echo $receita->getId(); ?>" class="btn btn-light btn-sm mr-2" title="Editar Receita"><i class="fas fa-edit"></i></a>
                                        <a href="/Trabalho2/receitas?action=excluir&id=<?php echo $receita->getId(); ?>" class="btn btn-danger btn-sm" title="Excluir Receita" onclick="return confirm('Tem certeza que deseja excluir esta receita?');"><i class="fas fa-trash-alt"></i></a>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Scripts Bootstrap e jQuery -->
        <?php include 'bootstrapJQuery.php'; ?>

    </body>
</html>
