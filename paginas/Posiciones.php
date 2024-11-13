<?php
    include '../php/conexion.php';

    
    $stmt = $conn->prepare("SELECT p.nombre AS piloto, e.nombre AS equipo, pos.puntos
                            FROM posiciones pos
                            JOIN pilotos p ON pos.id_piloto = p.id
                            JOIN equipos e ON pos.id_equipo = e.id
                            ORDER BY pos.puntos DESC");
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Posiciones del Campeonato</title>
</head>
<body>
    <header>
        <a href="../index.php"><img src="../Imagenes/F1.jpeg" width="200" height="150" alt="Logo F1"></a>
        <h1>Posiciones del Campeonato</h1>
        <div class="navbar">
            <a class="active" href="../index.php">Inicio</a>
            <a href="Pilotos.php">Pilotos</a>
            <a href="Pistas.php">Pistas</a>
            <a href="Posiciones.php">Posiciones</a>
        </div>
    </header>

    <main>
        <table>
            <thead>
                <tr>
                    <th>Posición</th>
                    <th>Piloto</th>
                    <th>Equipo</th>
                    <th>Puntos</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Mostrar los resultados en la tabla
                    $position = 1;
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $position++ . "</td>";
                        echo "<td>" . $row['piloto'] . "</td>";
                        echo "<td>" . $row['equipo'] . "</td>";
                        echo "<td>" . $row['puntos'] . "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>Todos los derechos están reservados para Alderete Exequiel 2024</p>
    </footer>
</body>
</html>
