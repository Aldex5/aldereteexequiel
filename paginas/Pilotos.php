<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Pilotos</title>
</head>

<body>
    <?php
    include '../php/conexion.php'; 

    // Obtengo todos los pilotos de la base de datos
    $stmt = $conn->prepare("SELECT * FROM pilotos");
    $stmt->execute();
    $pilotos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    
    <header>
        <a href="../index.php"><img src="../Imagenes/F1.jpeg" alt="Logo de la F1" width="200" height="150"></a>
        <br><br>
        <h1>Aquí estarán los pilotos</h1>
        <div class="navbar">
            <a class="active" href="../index.php">Inicio</a>
            <a href="../paginas/Pilotos.php">Pilotos</a>
            <a href="../paginas/Pistas.php">Pistas</a>
            <a href="../paginas/Posiciones.php">Posiciones</a>
        </div>
        <br>
    </header>

    <main>
        <h2>Seleccione el piloto de F1 que desea ver:</h2>
        <select name="piloto" id="piloto">
            <?php
            // Mostrar los pilotos en el select
            foreach ($pilotos as $piloto) {
                echo "<option value='{$piloto['id']}'>{$piloto['nombre']}</option>";
            }
            ?>
        </select>
        <br><br>
        <input type="button" value="Mostrar Piloto" onclick="mostrarPiloto()">
    </main>

    <div id="infoPiloto">
        <p>Descripción del piloto:</p>
        <p id="descripcionPiloto"></p>
        <div id="pilotoImagen">
            <img src="../Imagenes/todos.jpeg" alt="Foto de los pilotos" id="imgPilotos" width="300" height="200">
        </div>
    </div>

    <footer>
        <p>Todos los derechos están reservados para Alderete Exequiel 2024</p>
    </footer>

    <script>
       
        const dataPilotos = <?php echo json_encode($pilotos); ?>;

        function mostrarPiloto() {
           
            const pilotoId = document.getElementById("piloto").value;
            const piloto = dataPilotos.find(p => p.id == pilotoId);

            const descripcion = piloto ? piloto.descripcion : 'No se encontró descripción';
            const imagen = piloto ? piloto.imagen : '../Imagenes/todos.jpeg'; 

            document.getElementById("descripcionPiloto").innerText = descripcion;
            document.getElementById("imgPilotos").src = imagen;
        }
    </script>
</body>

</html>
