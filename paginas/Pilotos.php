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

        // Datos de pilotos (esto se puede guardar en la base de datos para hacerlo dinámico en el futuro)
        $pilotos = [
            "lewis_hamilton" => [
                "nombre" => "Lewis Hamilton",
                "descripcion" => "Lewis Hamilton es siete veces campeón del mundo y uno de los mejores pilotos de la historia.",
                "imagen" => "../Imagenes/hamilton.jpeg"
            ],
            "george_russell" => [
                "nombre" => "George Russell",
                "descripcion" => "George Russell es un joven talento de Mercedes con gran futuro en la F1.",
                "imagen" => "../Imagenes/russell.jpeg"
            ],
            "max_verstappen" => [
                "nombre" => "Max Verstappen",
                "descripcion" => "Max Verstappen es el actual campeón de la Fórmula 1 y uno de los pilotos más agresivos.",
                "imagen" => "../Imagenes/verstappen.jpeg"
            ],
            "sergio_perez" => [
                "nombre" => "Sergio Pérez",
                "descripcion" => "Sergio 'Checo' Pérez es el piloto mexicano de Red Bull con múltiples victorias en su haber.",
                "imagen" => "../Imagenes/perez.jpeg"
            ],
            "charles_leclerc" => [
                "nombre" => "Charles Leclerc",
                "descripcion" => "Charles Leclerc es el piloto monegasco estrella de Ferrari, conocido por su velocidad y destreza.",
                "imagen" => "../Imagenes/leclerc.jpeg"
            ],
            "carlos_sainz" => [
                "nombre" => "Carlos Sainz",
                "descripcion" => "Carlos Sainz es un piloto español de Ferrari, hijo del famoso piloto de rally Carlos Sainz Sr.",
                "imagen" => "../Imagenes/sainz.jpeg"
            ],
            "lando_norris" => [
                "nombre" => "Lando Norris",
                "descripcion" => "Lando Norris es el joven piloto británico de McLaren, conocido por su talento y carisma.",
                "imagen" => "../Imagenes/norris.jpeg"
            ],
            "oscar_piastri" => [
                "nombre" => "Oscar Piastri",
                "descripcion" => "Oscar Piastri es un prometedor piloto australiano de McLaren.",
                "imagen" => "../Imagenes/piastri.jpeg"
            ],
            "esteban_ocon" => [
                "nombre" => "Esteban Ocon",
                "descripcion" => "Esteban Ocon es el piloto francés de Alpine, ganador del Gran Premio de Hungría 2021.",
                "imagen" => "../Imagenes/ocon.jpeg"
            ],
            "pierre_gasly" => [
                "nombre" => "Pierre Gasly",
                "descripcion" => "Pierre Gasly, piloto francés de Alpine, es conocido por su victoria en Monza 2020.",
                "imagen" => "../Imagenes/gasly.jpeg"
            ],
            "alex_albon" => [
                "nombre" => "Alex Albon",
                "descripcion" => "Alex Albon es el piloto tailandés-británico de Williams, con experiencia en Red Bull.",
                "imagen" => "../Imagenes/albon.jpeg"
            ],
            "franco_colapinto" => [
                "nombre" => "Franco Colapinto",
                "descripcion" => "Franco Colapinto es un piloto argentino que compite en la academia de Williams.",
                "imagen" => "../Imagenes/colapinto.jpeg"
            ]
        ];
    ?>

    <header>
        <a href="../index.php"><img src="../Imagenes/F1.jpeg" alt="Logo de la F1" width="200" height="150"></a>
        <br><br>
        <h1>Aquí estarán los pilotos</h1>
        <div class="navbar">
            <a class="active" href="../index.php">Inicio</a>
            <a href="../paginas/Pilotos.php">Pilotos</a>
            <a href="../paginas/Pistas.html">Pistas</a>
            <a href="../paginas/Posiciones.html">Posiciones</a>
        </div>
        <br>
    </header>

    <main>
        <h2>Seleccione el piloto de F1 que desea ver:</h2>
        <select name="piloto" id="piloto">
            <?php
            foreach ($pilotos as $clave => $info) {
                echo "<option value='$clave'>{$info['nombre']}</option>";
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
            <img src="../Imagenes/todos.jpeg" alt="Foto de los pilotos" id="imgPilotos">
        </div>
    </div>

    <footer>
        <p>Todos los derechos están reservados para Alderete Exequiel 2024</p>
    </footer>

    <script>
        // Datos de pilotos en JavaScript
        const dataPilotos = <?php echo json_encode($pilotos); ?>;

        function mostrarPiloto() {
            const piloto = document.getElementById("piloto").value;
            const descripcion = dataPilotos[piloto].descripcion;
            const imagen = dataPilotos[piloto].imagen;

            document.getElementById("descripcionPiloto").innerText = descripcion;
            document.getElementById("imgPilotos").src = imagen;
        }
    </script>
</body>

</html>
