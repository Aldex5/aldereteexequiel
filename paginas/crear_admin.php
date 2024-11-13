<?php
include '../php/conexion.php'; // Asegúrate de que este archivo contiene la conexión correcta a la base de datos

// Definir el nombre de usuario y la contraseña
$username = 'admin';  // El nombre de usuario para el admin
$password = '123456';  // La contraseña en texto plano para el admin

// Cifrar la contraseña usando password_hash
$password_hashed = password_hash($password, PASSWORD_DEFAULT);

// Preparar y ejecutar la consulta SQL para insertar el administrador
$stmt = $conn->prepare("INSERT INTO administradores (username, password) VALUES (:username, :password)");
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $password_hashed);

if ($stmt->execute()) {
    echo "Administrador creado exitosamente.";
} else {
    echo "Error al crear el administrador.";
}
?>
