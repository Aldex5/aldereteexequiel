CREATE DATABASE f1db
USE f1db

CREATE TABLE entradas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cantidad INT NOT NULL,
    fecha_compra TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS config (
    id INT PRIMARY KEY,
    entradas_disponibles INT NOT NULL
);

INSERT INTO config (id, entradas_disponibles) VALUES (1, 100);
CREATE TABLE disponibilidad (
    id INT PRIMARY KEY AUTO_INCREMENT,
    total_disponibles INT NOT NULL
);

INSERT INTO disponibilidad (total_disponibles) VALUES (100);
UPDATE disponibilidad SET total_disponibles = 100 WHERE id = 1;

CREATE TABLE pilotos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    imagen VARCHAR(255) NOT NULL
);
-- Inserto los pilotos
INSERT INTO pilotos (nombre, descripcion, imagen) VALUES
('Lewis Hamilton', 'Lewis Hamilton es siete veces campeón del mundo y uno de los mejores pilotos de la historia.', '../Imagenes/hamilton.jpeg'),
('George Russell', 'George Russell es un joven talento de Mercedes con gran futuro en la F1.', '../Imagenes/russell.jpeg'),
('Max Verstappen', 'Max Verstappen es el actual campeón de la Fórmula 1 y uno de los pilotos más agresivos.', '../Imagenes/verstappen.jpeg'),
('Sergio Pérez', 'Sergio "Checo" Pérez es el piloto mexicano de Red Bull con múltiples victorias en su haber.', '../Imagenes/perez.jpeg'),
('Charles Leclerc', 'Charles Leclerc es el piloto monegasco estrella de Ferrari, conocido por su velocidad y destreza.', '../Imagenes/leclerc.jpeg'),
('Carlos Sainz', 'Carlos Sainz es un piloto español de Ferrari, hijo del famoso piloto de rally Carlos Sainz Sr.', '../Imagenes/sainz.jpeg'),
('Lando Norris', 'Lando Norris es el joven piloto británico de McLaren, conocido por su talento y carisma.', '../Imagenes/norris.jpeg'),
('Oscar Piastri', 'Oscar Piastri es un prometedor piloto australiano de McLaren.', '../Imagenes/piastri.jpeg'),
('Esteban Ocon', 'Esteban Ocon es el piloto francés de Alpine, ganador del Gran Premio de Hungría 2021.', '../Imagenes/ocon.jpeg'),
('Pierre Gasly', 'Pierre Gasly, piloto francés de Alpine, es conocido por su victoria en Monza 2020.', '../Imagenes/gasly.jpeg'),
('Alex Albon', 'Alex Albon es el piloto tailandés-británico de Williams, con experiencia en Red Bull.', '../Imagenes/albon.jpeg'),
('Franco Colapinto', 'Franco Colapinto es un piloto argentino que compite en la academia de Williams.', '../Imagenes/colapinto.jpeg');

CREATE TABLE pistas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

CREATE TABLE equipos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

INSERT INTO equipos (nombre) VALUES ('Williams Racing');
INSERT INTO equipos (nombre) VALUES ('Red Bull Racing');
INSERT INTO equipos (nombre) VALUES ('Mercedes');
INSERT INTO equipos (nombre) VALUES ('Aston Martin');
INSERT INTO equipos (nombre) VALUES ('Ferrari');
INSERT INTO equipos (nombre) VALUES ('McLaren');
INSERT INTO equipos (nombre) VALUES ('Alpine');

CREATE TABLE posiciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_piloto INT NOT NULL,
    id_equipo INT NOT NULL,
    puntos INT NOT NULL,
    FOREIGN KEY (id_piloto) REFERENCES pilotos(id),
    FOREIGN KEY (id_equipo) REFERENCES equipos(id)
);

-- Insertar las posiciones con los puntos
INSERT INTO posiciones (id_piloto, id_equipo, puntos) 
VALUES 
(1, 1, 777),  -- Franco Colapinto, Williams Racing, 777 puntos
(2, 2, 400),  -- Max Verstappen, Red Bull Racing, 400 puntos
(3, 2, 300),  -- Sergio Pérez, Red Bull Racing, 300 puntos
(4, 3, 290),  -- Lewis Hamilton, Mercedes, 290 puntos
(5, 4, 270),  -- Fernando Alonso, Aston Martin, 270 puntos
(6, 5, 250),  -- Charles Leclerc, Ferrari, 250 puntos
(7, 3, 230),  -- George Russell, Mercedes, 230 puntos
(8, 6, 220),  -- Lando Norris, McLaren, 220 puntos
(9, 5, 210),  -- Carlos Sainz, Ferrari, 210 puntos
(10, 7, 200), -- Pierre Gasly, Alpine, 200 puntos
(11, 7, 190); -- Esteban Ocon, Alpine, 190 puntos

CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);



