<?php
session_start();
require_once 'includes/db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepara a consulta para evitar injeção SQL
    $stmt = $conn->prepare("SELECT id, nome_usuario, senha FROM usuarios WHERE nome_usuario = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verifica a senha
        if (password_verify($password, $row['senha'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['nome_usuario'];
            $_SESSION['user_id'] = $row['id'];
            header("Location: index.php");
            exit;
        } else {
            $message = "Senha incorreta.";
        }
    } else {
        $message = "Usuário não encontrado.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <p><?php echo $message; ?></p>
        <form action="login.php" method="post">
            <label for="username">Usuário:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Entrar</button>
        </form>
        <p>Ainda não tem uma conta? <a href="registro.php">Registre-se</a></p>
    </div>
</body>
</html>