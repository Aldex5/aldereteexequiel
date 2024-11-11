<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Compra de Entradas F1</title>
</head>
<body>
    <?php include 'php/conexion.php'; ?>

    <header>
        <img src="Imagenes/F1.jpeg" alt="Logo de la F1" width="200" height="150"><br><br>
        <h1>Mi página de Fórmula 1</h1>
        <div class="navbar">
            <a class="active" href="index.php">Inicio</a>
            <a href="paginas/Pilotos.php">Pilotos</a>
            <a href="paginas/Pistas.php">Pistas</a>
            <a href="paginas/Posiciones.php">Posiciones</a>
        </div>
        <br>
    </header>
    <hr>

    <!-- Formulario de compra de entradas -->
    <section id="compra-entradas">
        <h2>Compra tus entradas</h2>

        <?php
            // Consultar entradas disponibles
            $stmt = $conn->prepare("SELECT total_disponibles FROM disponibilidad WHERE id = 1");
            $stmt->execute();
            $disponibilidad = $stmt->fetch(PDO::FETCH_ASSOC);
            $entradasDisponibles = $disponibilidad['total_disponibles'];
        ?>

        <p>Disponibilidad actual: <span id="entradas-disponibles"><?php echo $entradasDisponibles; ?></span> entradas</p>
        <form id="form-compra" method="POST">
            <label for="cantidad">Cantidad de entradas:</label>
            <input type="number" id="cantidad" name="cantidad" min="1" max="10" required>
            <button type="submit" name="accion" value="crear">Comprar</button>
        </form>
        <p id="mensaje">
            <?php
                // Crear entrada (compra de entradas)
                if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["accion"] == "crear") {
                    $cantidad = $_POST['cantidad'];

                    if ($cantidad <= $entradasDisponibles) {
                        // Restar entradas disponibles
                        $stmt = $conn->prepare("UPDATE disponibilidad SET total_disponibles = total_disponibles - :cantidad WHERE id = 1");
                        $stmt->bindParam(':cantidad', $cantidad);

                        if ($stmt->execute()) {
                            // Insertar compra en la tabla `entradas`
                            $stmt = $conn->prepare("INSERT INTO entradas (cantidad) VALUES (:cantidad)");
                            $stmt->bindParam(':cantidad', $cantidad);
                            $stmt->execute();
                            echo "¡Compra realizada con éxito!";
                            header("Location: ".$_SERVER['PHP_SELF']);
                            exit;
                        } else {
                            echo "Error al realizar la compra.";
                        }
                    } else {
                        echo "Lo sentimos, no hay suficientes entradas disponibles.";
                    }
                }
            ?>
        </p>
    </section>
    <hr>

    <!-- Listado de entradas -->
    <section id="listado-entradas">
        <h2>Listado de Compras</h2>
        <?php
            // Leer entradas
            $stmt = $conn->prepare("SELECT * FROM entradas");
            $stmt->execute();
            $entradas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($entradas as $entrada) {
                echo "ID: " . $entrada['id'] . " - Cantidad: " . $entrada['cantidad'];
                echo "
                    <form method='POST' style='display:inline;'>
                        <input type='hidden' name='id' value='{$entrada['id']}'>
                        <input type='number' name='cantidad' value='{$entrada['cantidad']}' required>
                        <button type='submit' name='accion' value='actualizar'>Actualizar</button>
                        <button type='submit' name='accion' value='eliminar'>Eliminar</button>
                    </form>
                    <br>";
            }

            // Actualizar entrada
            if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["accion"] == "actualizar") {
                $id = $_POST['id'];
                $cantidadNueva = $_POST['cantidad'];

                // Obtener la cantidad anterior
                $stmt = $conn->prepare("SELECT cantidad FROM entradas WHERE id = :id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $cantidadAnterior = $stmt->fetch(PDO::FETCH_ASSOC)['cantidad'];

                // Calcular la diferencia y ajustar disponibilidad
                $diferencia = $cantidadNueva - $cantidadAnterior;
                
                if ($entradasDisponibles - $diferencia >= 0) {
                    // Actualizar cantidad en la tabla entradas
                    $stmt = $conn->prepare("UPDATE entradas SET cantidad = :cantidadNueva WHERE id = :id");
                    $stmt->bindParam(':cantidadNueva', $cantidadNueva);
                    $stmt->bindParam(':id', $id);

                    if ($stmt->execute()) {
                        // Ajustar la disponibilidad en base a la diferencia
                        $stmt = $conn->prepare("UPDATE disponibilidad SET total_disponibles = total_disponibles - :diferencia WHERE id = 1");
                        $stmt->bindParam(':diferencia', $diferencia);
                        $stmt->execute();

                        echo "<p>Entrada actualizada con éxito!</p>";
                        header("Location: ".$_SERVER['PHP_SELF']);
                        exit;
                    } else {
                        echo "<p>Error al actualizar la entrada.</p>";
                    }
                } else {
                    echo "<p>No hay suficientes entradas disponibles para actualizar a esa cantidad.</p>";
                }
            }

            // Eliminar entrada y devolver las entradas a la disponibilidad
            if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["accion"] == "eliminar") {
                $id = $_POST['id'];

                // Recuperar la cantidad antes de eliminar la entrada
                $stmt = $conn->prepare("SELECT cantidad FROM entradas WHERE id = :id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $cantidadEliminada = $stmt->fetch(PDO::FETCH_ASSOC)['cantidad'];

                // Eliminar entrada
                $stmt = $conn->prepare("DELETE FROM entradas WHERE id = :id");
                $stmt->bindParam(':id', $id);

                if ($stmt->execute()) {
                    // Devolver entradas a la disponibilidad
                    $stmt = $conn->prepare("UPDATE disponibilidad SET total_disponibles = total_disponibles + :cantidad WHERE id = 1");
                    $stmt->bindParam(':cantidad', $cantidadEliminada);
                    $stmt->execute();

                    echo "<p>Entrada eliminada con éxito!</p>";
                    header("Location: ".$_SERVER['PHP_SELF']);
                    exit;
                } else {
                    echo "<p>Error al eliminar la entrada.</p>";
                }
            }
        ?>
    </section>
    <hr>

    <footer>
        <p>Todos los derechos están reservados para Alderete Exequiel 2024</p>
    </footer>
</body>
</html>
