<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
    <div class="container">
        <h1>Cadastro</h1>
        <form>
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
