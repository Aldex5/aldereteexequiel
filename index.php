<?php
  // Inicializar la variable mensaje
session_start();
$mensaje = "¡Ud se ha Deslogueado Correctamente!";

// Incluir archivo de conexión
include 'php/conexion.php';

// Manejo del inicio de sesión del administrador
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["accion"]) && $_POST["accion"] == "login") {
    if (isset($_POST['username']) && isset($_POST['contraseña'])) {
        $usuario = $_POST['username'];
        $contraseña = $_POST['contraseña'];

        // Consultar el administrador en la base de datos
        $stmt = $conn->prepare("SELECT * FROM administradores WHERE username = :username");
        $stmt->bindParam(':username', $usuario);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            if (password_verify($contraseña, $admin['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $mensaje = "¡Se ha logueado correctamente " . $usuario . "!";
            } else {
                $mensaje = "Usuario o contraseña incorrectos.";
            }
        } else {
            $mensaje = "Usuario no encontrado.";
        }
    }
}
// Verificar si el administrador está logueado
$admin_logueado = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Cerrar sesión si se requiere
if (isset($_GET['logout'])) {
    session_destroy();
    $mensaje = "Te has deslogueado correctamente.";  // Mensaje de cierre de sesión
    header("Location: index.php?mensaje=" . urlencode($mensaje));  // Pasar el mensaje a la URL
    exit;
}


// Manejo de CRUD de entradas (solo si el administrador está logueado)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] == 'crear') {
        $cantidad = $_POST['cantidad'];
        $email = $_POST['email'];

        // Consultar las entradas disponibles
        $stmt = $conn->prepare("SELECT total_disponibles FROM disponibilidad WHERE id = 1");
        $stmt->execute();
        $disponibles = $stmt->fetch(PDO::FETCH_ASSOC)['total_disponibles'];

        // Verificar si hay suficientes entradas disponibles
        if ($cantidad <= $disponibles) {
            // Insertar la entrada en la base de datos
            $stmt = $conn->prepare("INSERT INTO entradas (cantidad, email) VALUES (:cantidad, :email)");
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Actualizar la disponibilidad de entradas
            $stmt = $conn->prepare("UPDATE disponibilidad SET total_disponibles = total_disponibles - :cantidad WHERE id = 1");
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->execute();

            // Generar mensaje de confirmación
            $mensaje = "Compra realizada con éxito. Diríjase a su casilla de correo para realizar el pago.";
        } else {
            // Si no hay suficientes entradas disponibles
            $mensaje = "No hay suficientes entradas disponibles. Quedan " . $disponibles . " entradas.";
        }
    }

    // CRUD: Actualizar entradas
    if (isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
        $id = $_POST['id'];
        $cantidad = $_POST['cantidad'];

        $stmt = $conn->prepare("UPDATE entradas SET cantidad = :cantidad WHERE id = :id");
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $mensaje = "Entrada actualizada correctamente.";
    }

    // CRUD: Eliminar entradas
    if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM entradas WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $mensaje = "Entrada eliminada correctamente.";
    }
}

// Obtener listado de compras para mostrar en el CRUD
$stmt = $conn->prepare("SELECT * FROM entradas");
$stmt->execute();
$entradas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener las entradas disponibles
$stmt = $conn->prepare("SELECT total_disponibles FROM disponibilidad WHERE id = 1");
$stmt->execute();
$disponibles = $stmt->fetch(PDO::FETCH_ASSOC)['total_disponibles'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Compra de Entradas F1</title>
    <script>
        // Función para mostrar un mensaje emergente
        function mostrarMensaje() {
            var mensaje = "<?php echo $mensaje; ?>";
            if (mensaje) {
                alert(mensaje); // Mostrar el mensaje como alerta emergente
            }
        }
    </script>
</head>
<body onload="mostrarMensaje()">
    <header>
        <img src="Imagenes/F1.jpeg" alt="Logo de la F1" width="200" height="150"><br><br>
        <h1>Mi página de Fórmula 1</h1>
        <div class="navbar">
            <a class="active" href="index.php">Inicio</a>
            <a href="paginas/Pilotos.php">Pilotos</a>
            <a href="paginas/Pistas.php">Pistas</a>
            <a href="paginas/Posiciones.php">Posiciones</a>
            <?php if ($admin_logueado): ?>
                <a href="index.php?logout=true">Cerrar sesión</a>
            <?php else: ?>
                <a href="javascript:void(0);" onclick="document.getElementById('loginModal').style.display='block'">Iniciar sesión</a>
            <?php endif; ?>
        </div>
    </header>
    
    <hr>

    <!-- Modal de inicio de sesión -->
    <div id="loginModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('loginModal').style.display='none'">&times;</span>
            <h2>Iniciar sesión como Administrador</h2>
            <form method="POST" action="index.php">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="username" required>
                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" required>
                <button type="submit" name="accion" value="login">Iniciar sesión</button>
            </form>
            <?php if ($mensaje): ?>
                <p style="color:red;"><?php echo $mensaje; ?></p>
            <?php endif; ?>
        </div>
    </div>

    <hr>

    <?php if ($admin_logueado): ?>
        <h2>Panel de Administración</h2>
        <p>Desde aca se puede realizar el mantenimiento necesario para la página (agregar pistas,pilotos etc)</p>
        <br>
        <!-- Formulario para agregar piloto -->
        <h3>Agregar Piloto</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="piloto_nombre" placeholder="Nombre del Piloto" required>
            <input type="file" name="piloto_imagen" required>
            <button type="submit" name="accion" value="agregar_piloto">Agregar Piloto</button>
        </form>

        <!-- Formulario para agregar pista -->
        <h3>Agregar Pista</h3>
        <form method="POST">
            <input type="text" name="pista_nombre" placeholder="Nombre de la Pista" required>
            <button type="submit" name="accion" value="agregar_pista">Agregar Pista</button>
        </form>

        
    <?php else: ?>
        <h2>Compra de Entradas</h2>
        <p>Entradas disponibles: <?php echo $disponibles; ?></p>

        <!-- Formulario para comprar entradas -->
        <form method="POST">
            <label for="cantidad">Cantidad de Entradas:</label>
            <input type="number" id="cantidad" name="cantidad" required max="<?php echo $disponibles; ?>">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit" name="accion" value="crear">Comprar Entradas</button>
        </form>

        <hr>

        <!-- Listado de compras -->
        <h3>Listado de Compras</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cantidad</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entradas as $entrada): ?>
                    <tr>
                        <td><?php echo $entrada['id']; ?></td>
                        <td><?php echo $entrada['cantidad']; ?></td>
                        <td><?php echo $entrada['email']; ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $entrada['id']; ?>">
                                <input type="number" name="cantidad" value="<?php echo $entrada['cantidad']; ?>" required>
                                <button type="submit" name="accion" value="actualizar">Actualizar</button>
                            </form>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $entrada['id']; ?>">
                                <button type="submit" name="accion" value="eliminar">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <footer>
        <p> © Todos los derechos reservados para Alderete Exequiel - 2024</p>
    </footer>
</body>
</html>
