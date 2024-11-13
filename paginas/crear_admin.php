<?php
include '../php/conexion.php'; 

$username = 'admin';  
$password = '123456';  

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
