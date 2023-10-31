<!-- Barra de Navegação -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/Trabalho2/receitas">Sistema de Receitas</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/Trabalho2/receitas">Listar Receitas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Trabalho2/receitas/adicionar">Adicionar Receita</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <?php if(isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true): ?>
                <li class="nav-item">
                    <span class="nav-link"><i class="fas fa-user"></i> Bem-vindo, <?php echo $_SESSION['usuario_logado']; ?>!</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="/Trabalho2/login?action=logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
