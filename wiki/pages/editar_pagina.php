<?php
session_start();
require_once '../includes/db.php';

// Redireciona se o usuário não estiver logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login.php");
    exit;
}

$pagina_id = $_GET['id'] ?? null;
$pagina = null;
$message = '';

if ($pagina_id) {
    // Busca a página
    $stmt = $conn->prepare("SELECT * FROM paginas WHERE id = ? AND autor_id = ?");
    $stmt->bind_param("ii", $pagina_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $pagina = $result->fetch_assoc();
    } else {
        $message = "Você não tem permissão para editar esta página.";
        $pagina_id = null; // Impede que o formulário seja exibido
    }
    $stmt->close();
}

// Lógica de atualização
if ($_SERVER["REQUEST_METHOD"] == "POST" && $pagina_id) {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    
    $stmt = $conn->prepare("UPDATE paginas SET titulo = ?, conteudo = ? WHERE id = ? AND autor_id = ?");
    $stmt->bind_param("ssii", $titulo, $conteudo, $pagina_id, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        $message = "Página atualizada com sucesso!";
    } else {
        $message = "Erro ao atualizar a página: " . $stmt->error;
    }
    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Página</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>Editar Página</h2>
        <p><?php echo $message; ?></p>
        
        <?php if ($pagina): ?>
            <form action="editar_pagina.php?id=<?php echo $pagina_id; ?>" method="post">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($pagina['titulo']); ?>" required>
                
                <label for="conteudo">Conteúdo:</label>
                <textarea id="conteudo" name="conteudo" rows="15" required><?php echo htmlspecialchars($pagina['conteudo']); ?></textarea>
                
                <button type="submit">Atualizar</button>
            </form>
        <?php else: ?>
            <p>Página não encontrada ou você não tem permissão para editá-la.</p>
        <?php endif; ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
<?php $conn->close(); ?>