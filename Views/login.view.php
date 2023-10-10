<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php include 'head.php'; ?>
</head>
<body>

<div class="container mt-5">
    <h2>Login</h2>

    <?php if (isset($erro) && $erro): ?>
        <div class="alert alert-danger">
            <?php echo $erro; ?>
        </div>
    <?php endif; ?>

    <form action="../controllers/login.controller.php" method="post">
        <div class="form-group">
            <label for="usuario">Usuário:</label>
            <input type="text" name="usuario" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" name="senha" class="form-control" required>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
    </form>
    
    <div class="container mt-5">
        <h2>Cadastro</h2>
        <form action="../controllers/login.controller.php" method="post">
            <div class="form-group">
                <label for="usuario">Usuário:</label>
                <input type="text" name="usuario" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" class="form-control" required minlength="6">
            </div>
            <div class="form-group">
                <input type="submit" name="cadastrar" class="btn btn-success" value="Cadastrar">
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
