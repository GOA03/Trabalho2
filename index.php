<?php
// Inicia a sessão se ainda não foi iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está autenticado
if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true) {
    // Se estiver autenticado, redireciona para a lista de receitas
    header('Location: views/listar.view.php');
} else {
    // Se não estiver autenticado, redireciona para a página de login
    header('Location: views/login.view.php');
}

// Finaliza a execução do script para evitar qualquer processamento adicional
exit();
?>