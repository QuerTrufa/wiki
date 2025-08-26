<?php
// Certifica-se de que a sessão já foi iniciada na página principal
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wiki de Ficção</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header class="main-header">
        <nav class="main-nav">
            <h1><a href="/index.php">Wiki de Ficção</a></h1>
            <ul>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <li>Olá, <?php echo htmlspecialchars($_SESSION['username']); ?>!</li>
                    <li><a href="/pages/criar_pagina.php">Criar Página</a></li>
                    <li><a href="/logout.php">Sair</a></li>
                <?php else: ?>
                    <li><a href="/login.php">Login</a></li>
                    <li><a href="/registro.php">Registrar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>