<?php
require 'database/db.php'; // Inclui a conexão com o banco de dados

session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Verifica se o usuário existe no banco de dados
        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE username = :username OR email = :email');
        $stmt->execute(['username' => $username, 'email' => $username]);
        $user = $stmt->fetch();

        // Verifica se o usuário foi encontrado e se a senha está correta
        if ($user && password_verify($password, $user['password'])) {
            // Login bem-sucedido
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
        
            // Redireciona para a página interna
            $success = 'Login realizado com sucesso! Redirecionando...';
        } elseif (md5($password) === $user['password']) {
            // Atualiza a senha para o formato novo com password_hash
            $new_password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('UPDATE usuarios SET password = :password WHERE id = :id');
            $stmt->execute(['password' => $new_password_hashed, 'id' => $user['id']]);
    
            // Login bem-sucedido após a atualização da senha
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
    
            $success = 'Login realizado com sucesso! Senha atualizada.'; 
        } else {
            $error = 'Usuário ou senha inválidos.';
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/response.css">
    <script>
        // Redirecionamento do login
        function redirectToSuccess() {
            setTimeout(function() {
                window.location.href = 'sucesso.html';
            }, 1000);
        }

        // Mensagens de sucesso ou erro do login
        function showMessage() {
            const success = document.querySelector('.success-message');
            if (success) {
                success.style.opacity = '1';
                setTimeout(() => {
                    success.style.opacity = '0';
                    redirectToSuccess();
                }, 1000);
            }

            const error = document.querySelector('.error-message');
            if (error) {
                error.style.opacity = '1';
                setTimeout(() => error.style.opacity = '0', 2000);
            }
        }

        window.onload = showMessage;
    </script>
</head>
<body>
    <div class="container">
        <h1>Login</h1>

        <?php if (isset($error)): ?>
            <div class="error-message"><?= $error ?></div>
        <?php elseif (isset($success)): ?>
            <div class="success-message"><?= $success ?></div>
        <?php endif; ?>

        <form id="form-login" method="post">
            <label for="username">Usuário/E-mail:</label>
            <input type="text" id="username" name="username" required>
            <span class="error-message" id="usernameError"></span>

            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
            <span class="error-message" id="passwordError"></span>
            
            <input type="submit" value="Entrar">

            <a href="cadastro.php" class="cadastro-login">Cadastro</a>
        </form>
    </div>
</body>
</html>
