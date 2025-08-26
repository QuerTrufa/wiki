<?php
session_start();
require_once 'includes/db.php';

// Busca todas as páginas do banco de dados
$sql = "SELECT p.id, p.titulo, p.conteudo, p.data_criacao, u.nome_usuario 
        FROM paginas AS p 
        JOIN usuarios AS u ON p.autor_id = u.id 
        ORDER BY p.data_criacao DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Wiki de Ficção</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h2>Páginas da Wiki</h2>
        <?php
        if ($result->num_rows > 0) {
            // Exibe cada página
            while($row = $result->fetch_assoc()) {
                echo "<div class='wiki-page-summary'>";
                echo "<h3><a href='pages/view_pagina.php?id=" . $row["id"] . "'>" . htmlspecialchars($row["titulo"]) . "</a></h3>";
                echo "<p>Criado por " . htmlspecialchars($row["nome_usuario"]) . " em " . $row["data_criacao"] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Nenhuma página foi criada ainda.</p>";
        }
        ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
<?php $conn->close(); ?>