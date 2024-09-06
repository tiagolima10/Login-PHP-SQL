<?php
require 'database/db.php'; // Inclui a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        // Verifica se o usuário ou email já existem
        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE username = :username OR email = :email');
        $stmt->execute(['username' => $username, 'email' => $email]);
    
        if ($stmt->fetch()) {
            $error = 'Usuário ou email já estão em uso.';
        } else {
            // Insere o novo usuário com a senha criptografada usando password_hash
            $stmt = $pdo->prepare('INSERT INTO usuarios (username, email, password) VALUES (:username, :email, :password)');
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password_hashed]);
    
            // Define a mensagem de sucesso
            $success = 'Cadastro realizado com sucesso! Redirecionando...';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/response.css">
    <script>
        // Redirecionar ao login
        function redirectToLogin() {
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 1000);
        }

        function showMessage() {
            const success = document.querySelector('.success-message');
            if (success) {
                success.style.opacity = '1';
                setTimeout(() => {
                    success.style.opacity = '0';
                    redirectToLogin();
                }, 1000);
            }

            const error = document.querySelector('.error-message');
            if (error) {
                error.style.opacity = '1';
                setTimeout(() => error.style.opacity = '0', 3000);
            }
        }

        window.onload = showMessage;
    </script>
</head>
<body>
    <div class="container">
        <h1>Cadastro</h1>

        <?php if (isset($error)): ?>
            <div class="error-message"><?= $error ?></div>
        <?php elseif (isset($success)): ?>
            <div class="success-message"><?= $success ?></div>
        <?php endif; ?>

        <form method="post">
            <label for="username">Usuário:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="confirm_password">Confirme a Senha:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <input type="submit" value="Cadastrar">

            <a href="login.php" class="cadastro-login">Login</a>
        </form>
    </div>
</body>
</html>
