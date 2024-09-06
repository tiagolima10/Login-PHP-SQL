<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    // Redireciona para o login se o usuário não estiver autenticado
    header('Location: login.php');
    exit();
}

// Pega o nome do usuário da sessão
$usuario_logado = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sucesso ao fazer o Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/sucesso.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <ul>
                <li><a href="logout.php" class="logout">Deslogar</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <div class="container sucesso">
            <h1>Parabéns, <?php echo htmlspecialchars($usuario_logado); ?>, seu login foi um sucesso!</h1>
            <p>Obrigado por estar conosco, é uma honra!</p>
        </div>
    </main>
</body>
</html>
