<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");  // Redirigir si no está logueado
    exit;
}

include '../php/conexion.php';  // Conexión a la base de datos

// Insertar piloto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_piloto'])) {
    $nombre = $_POST['nombre'];
    $equipo = $_POST['equipo'];
    $imagen = $_FILES['imagen']['name'];  // Nombre de la imagen
    $imagen_tmp = $_FILES['imagen']['tmp_name'];  // Ruta temporal de la imagen
    $imagen_path = "../Imagenes/" . $imagen;  // Ruta de destino para la imagen

    // Subir imagen
    if (move_uploaded_file($imagen_tmp, $imagen_path)) {
        // Insertar piloto en la base de datos
        $stmt = $conn->prepare("INSERT INTO pilotos (nombre, equipo, imagen) VALUES (:nombre, :equipo, :imagen)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':equipo', $equipo);
        $stmt->bindParam(':imagen', $imagen_path);

        if ($stmt->execute()) {
            echo "Piloto agregado exitosamente.";
        } else {
            echo "Error al agregar piloto.";
        }
    } else {
        echo "Error al cargar la imagen.";
    }
}

// Insertar pista
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_pista'])) {
    $nombre_pista = $_POST['nombre_pista'];

    // Insertar pista en la base de datos
    $stmt = $conn->prepare("INSERT INTO pistas (nombre) VALUES (:nombre_pista)");
    $stmt->bindParam(':nombre_pista', $nombre_pista);

    if ($stmt->execute()) {
        echo "Pista agregada exitosamente.";
    } else {
        echo "Error al agregar pista.";
    }
}

// Obtener pilotos y pistas
$pilotos = $conn->query("SELECT * FROM pilotos")->fetchAll();
$pistas = $conn->query("SELECT * FROM pistas")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h1>Panel de Administración</h1>
    
    <!-- Formulario para agregar piloto -->
    <form method="POST" enctype="multipart/form-data">
        <h2>Agregar Piloto</h2>
        <input type="text" name="nombre" placeholder="Nombre del piloto" required>
        <input type="text" name="equipo" placeholder="Equipo" required>
        <input type="file" name="imagen" required>
        <button type="submit" name="agregar_piloto">Agregar Piloto</button>
    </form>

    <!-- Formulario para agregar pista -->
    <form method="POST">
        <h2>Agregar Pista</h2>
        <input type="text" name="nombre_pista" placeholder="Nombre de la pista" required>
        <button type="submit" name="add_pista">Agregar Pista</button>
    </form>

    <!-- Listado de Pilotos -->
    <h2>Listado de Pilotos</h2>
    <ul>
        <?php foreach ($pilotos as $piloto): ?>
            <li><?php echo $piloto['nombre'] . " - " . $piloto['equipo']; ?></li>
        <?php endforeach; ?>
    </ul>

    <!-- Listado de Pistas -->
    <h2>Listado de Pistas</h2>
    <ul>
        <?php foreach ($pistas as $pista): ?>
            <li><?php echo $pista['nombre']; ?></li>
        <?php endforeach; ?>
    </ul>

    <footer>
        <p>Todos los derechos reservados 2024</p>
    </footer>
</body>
</html>
