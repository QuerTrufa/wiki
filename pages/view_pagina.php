<?php
session_start();
require_once '../includes/db.php';

$pagina_id = $_GET['id'] ?? null;
$pagina = null;
$pode_editar = false;

if ($pagina_id) {
    // Busca a página e o nome do autor
    $stmt = $conn->prepare("SELECT p.*, u.nome_usuario FROM paginas AS p JOIN usuarios AS u ON p.autor_id = u.id WHERE p.id = ?");
    $stmt->bind_param("i", $pagina_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $pagina = $result->fetch_assoc();
        // Verifica se o usuário logado é o autor da página
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $pagina['autor_id']) {
            $pode_editar = true;
        }
    }
    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo $pagina ? htmlspecialchars($pagina['titulo']) : "Página Não Encontrada"; ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <?php if ($pagina): ?>
            <div class="wiki-content">
                <h1><?php echo htmlspecialchars($pagina['titulo']); ?></h1>
                <p class="meta-info">Criado por <?php echo htmlspecialchars($pagina['nome_usuario']); ?> em <?php echo $pagina['data_criacao']; ?></p>
                
                <?php if ($pode_editar): ?>
                    <a href="editar_pagina.php?id=<?php echo $pagina['id']; ?>" class="edit-btn">Editar Página</a>
                <?php endif; ?>
                
                <div class="page-content">
                    <?php echo nl2br(htmlspecialchars($pagina['conteudo'])); ?>
                </div>
            </div>
        <?php else: ?>
            <div class="error-message">
                <h2>Página Não Encontrada</h2>
                <p>Desculpe, a página que você procura não existe.</p>
            </div>
        <?php endif; ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
<?php $conn->close(); ?>