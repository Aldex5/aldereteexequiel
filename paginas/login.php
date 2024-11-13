<?php
session_start();
include '../php/conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar si el administrador existe en la base de datos
    $stmt = $conn->prepare("SELECT * FROM administradores WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        // Inicio de sesión exitoso, guardamos la sesión
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['username'] = $admin['username'];
        header("Location: admin.php");  // Redirigimos al panel de administración
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador</title>
</head>
<body>
    <h2>Iniciar sesión como Administrador</h2>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    <form method="POST">
        <label for="username">Usuario:</label>
        <input type="text" name="username" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Iniciar sesión</button>
    </form>
</body>
</html>
