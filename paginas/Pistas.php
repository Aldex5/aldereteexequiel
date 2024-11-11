<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Pistas</title>
</head>
<body>
    <?php
        // Incluir archivo de conexión
        include '../php/conexion.php';

        // Consulta para obtener la disponibilidad de entradas desde la base de datos
        $stmt = $conn->prepare("SELECT * FROM disponibilidad WHERE id = 1");
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener datos como array asociativo
    ?>
    <header>
        <a href="../index.php"><img src="../Imagenes/F1.jpeg" width="200" height="150"></a>
        <h1>Pistas donde se Correrán a lo Largo del Año</h1>
        <div class="navbar">
            <a class="active" href="../index.php">Inicio</a>
            <a href="Pilotos.php">Pilotos</a>
            <a href="Pistas.php">Pistas</a>
            <a href="Posiciones.php">Posiciones</a>
        </div>
        <br>
    </header>
    <br><br>
    <main>
        <form id="pistaForm">
            Seleccione La pista a Analizar:
            <select name="circuito" id="circuito">
                <option value="bahrain">Gran Premio de Baréin (Circuito Internacional de Baréin)</option>
                <option value="arabia_saudita">Gran Premio de Arabia Saudita (Circuito de la Corniche de Yeda)</option>
                <option value="australia">Gran Premio de Australia (Circuito de Albert Park)</option>
                <option value="italia_imola">Gran Premio de Emilia-Romaña (Autódromo Enzo e Dino Ferrari, Imola)</option>
                <option value="españa">Gran Premio de España (Circuit de Barcelona-Catalunya)</option>
                <option value="monaco">Gran Premio de Mónaco (Circuito de Mónaco)</option>
            </select>
            <br><br> 
            <!-- Muestran las entradas disponibles de la base de datos-->
            <p>Entradas disponibles: <?php echo $data['total_disponibles']; ?></p> 
            <input type="button" value="Mostrar Descripción" onclick="mostrarDescripcion()">
        </form>

        <div id="descripcion">
            <p>Descripción de la pista:</p>
            <p id="descripcionPista"></p>
            <div class="carousel" id="carousel">
                <img src="../Imagenes/barein1.jpeg" alt="Imagen 1" id="img1" class="active">
                <img src="../Imagenes/barein2.jpeg" alt="Imagen 2" id="img2">
                <img src="../Imagenes/barein4.jpeg" alt="Imagen 3" id="img3">
            </div>
        </div>
    </main>
    <br><br>
    <footer>
        <p>Todos los derechos están reservados para Alderete Exequiel 2024</p>
    </footer>

    <script>
        const dataPistas = {
            bahrain: {
                descripcion: "El Circuito Internacional de Baréin es un circuito típico de Hermann Tilke con muchas rectas largas y curvas lentas. Los coches circulan en el sentido de las agujas del reloj, al igual que la mayoría de los circuitos están diseñados. El Circuito Internacional de Baréin se encuentra en el desierto y es conocido por sus largas rectas y zonas de frenado fuerte.",
                imagenes: ["../Imagenes/barein1.jpeg", "../Imagenes/barein2.jpeg", "../Imagenes/barein4.jpeg"]
            },
            arabia_saudita: {
                descripcion: "El circuito está ubicado en el área de Corniche de Yeda, que está a unos 12 km al norte del centro principal de la ciudad. Es uno de los más rápidos de la temporada, ubicado a lo largo del Mar Rojo.",
                imagenes: ["../Imagenes/arabia1.jpeg", "../Imagenes/arabia2.jpeg", "../Imagenes/arabia3.jpeg"]
            },
            australia: {
                descripcion: "El circuito de Albert Park es un circuito urbano que combina zonas rápidas con curvas técnicas.",
                imagenes: ["../Imagenes/australia1.jpeg", "../Imagenes/australia2.jpeg", "../Imagenes/australia3.jpeg"]
            },
            italia_imola: {
                descripcion: "El Autódromo Enzo e Dino Ferrari, conocido como Imola, es un circuito histórico lleno de desafíos técnicos.",
                imagenes: ["../Imagenes/imola1.jpeg", "../Imagenes/imola2.jpeg", "../Imagenes/imola3.jpeg"]
            },
            españa: {
                descripcion: "El Circuit de Barcelona-Catalunya es uno de los favoritos de los pilotos por su mezcla de curvas rápidas y técnicas.",
                imagenes: ["../Imagenes/espana1.jpeg", "../Imagenes/espana2.jpeg", "../Imagenes/espana3.jpeg"]
            },
            monaco: {
                descripcion: "El Circuito de Mónaco es uno de los más icónicos y desafiantes de la Fórmula 1, estrecho y lleno de curvas cerradas.",
                imagenes: ["../Imagenes/monaco1.jpeg", "../Imagenes/monaco2.jpeg", "../Imagenes/monaco3.jpeg"]
            }
        };

        let currentImage = 0;
        let imageInterval;

        function mostrarDescripcion() {
            const circuito = document.getElementById("circuito").value;
            const descripcion = dataPistas[circuito].descripcion;
            const imagenes = dataPistas[circuito].imagenes;

            document.getElementById("descripcionPista").innerText = descripcion;
            document.getElementById("img1").src = imagenes[0];
            document.getElementById("img2").src = imagenes[1];
            document.getElementById("img3").src = imagenes[2];

            currentImage = 0;
            clearInterval(imageInterval);
            imageInterval = setInterval(cambiarImagen, 3000);
            cambiarImagen();
        }

        function cambiarImagen() {
            const imgs = document.querySelectorAll(".carousel img");
            imgs.forEach((img, index) => {
                img.classList.remove("active");
                if (index === currentImage) {
                    img.classList.add("active");
                }
            });
            currentImage = (currentImage + 1) % imgs.length;
        }
    </script>
</body>
</html>
