<?php
session_start();
// Redireciona se o usuário não estiver logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

require_once 'includes/db.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $autor_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO paginas (titulo, conteudo, autor_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $titulo, $conteudo, $autor_id);

    if ($stmt->execute()) {
        $message = "Página criada com sucesso!";
    } else {
        $message = "Erro ao criar a página: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Nova Página</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Criar Nova Página</h2>
        <p><?php echo $message; ?></p>
        <form action="criar_pagina.php" method="post">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
            
            <label for="conteudo">Conteúdo:</label>
            <textarea id="conteudo" name="conteudo" rows="15" required></textarea>
            
            <button type="submit">Publicar</button>
        </form>
    </div>
</body>
</html>