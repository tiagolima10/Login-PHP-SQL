<?php
session_start();

// Destroi a sessão
session_unset();
session_destroy();

// Redireciona para a página de login
header('Location: login.php');
exit();
