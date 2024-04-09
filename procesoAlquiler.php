<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>Proyecto</title>
        <link rel="shortcut icon" href="./imagenes/logo.jpeg"/>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="item container-fluid mt-4">
            <div class="row">
                <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $host = "localhost";
                        $user = "root";
                        $pass = "";
                        $database = "tienda_videojuegos";
                        $conexion = mysqli_connect($host, $user, $pass, $database);

                        if (!$conexion)
                            die("Error de conexión a la base de datos: " . mysqli_connect_error());

                        $idJuego = mysqli_real_escape_string($conexion, $_POST['idJuego']);
                        $idUsuario = mysqli_real_escape_string($conexion, $_POST['idUsuario']);
                        $f_inicio = mysqli_real_escape_string($conexion, $_POST['f_inicio']);
                        $f_fin = mysqli_real_escape_string($conexion, $_POST['f_fin']);

                        // Insertar el alquiler en la tabla 'alquilan'
                        $query = "INSERT INTO alquilan (idJuego, idUsuario, f_inicio, f_fin) VALUES ('$idJuego', '$idUsuario', '$f_inicio', '$f_fin')";
                        $resultado = mysqli_query($conexion, $query);

                        if (!$resultado) 
                            die("Error al realizar el alquiler: " . mysqli_error($conexion));
                        unset($_SESSION['carrito']);

                        // Generar nombres únicos para el procedimiento y el evento
                        $uniqueName = "DevolverJuego_" . $idJuego . "_" . $idUsuario . "_" . time();

                        // Crear el procedimiento almacenado de manera dinámica si no existe
                        $procedimientoSQL = "
                            DROP PROCEDURE IF EXISTS `$uniqueName`;
                            CREATE PROCEDURE `$uniqueName`(IN juegoID INT, IN usuarioID INT)
                            BEGIN
                                UPDATE juegos SET stock = stock + 1 WHERE idJuego = juegoID;
                                DROP EVENT IF EXISTS `evt_$uniqueName`;
                                DROP PROCEDURE IF EXISTS `$uniqueName`;
                            END;
                        ";

                        if (!mysqli_multi_query($conexion, $procedimientoSQL))
                            die("Error al verificar/crear el procedimiento almacenado: " . mysqli_error($conexion));
                        
                        // Esperar a que los comandos anteriores finalicen
                        while (mysqli_next_result($conexion)) {;}

                        // Crear el evento de devolución único para este alquiler
                        $eventoDevolucion = "
                            CREATE EVENT `evt_$uniqueName` ON SCHEDULE AT '$f_fin' DO
                                CALL `$uniqueName`('$idJuego', '$idUsuario');
                        ";

                        $resultadoEvento = mysqli_query($conexion, $eventoDevolucion);

                        if (!$resultadoEvento)
                            die("Error al programar el evento de devolución: " . mysqli_error($conexion));

                        echo '<p>Alquiler realizado con éxito.</p>';
                        mysqli_close($conexion);
                    }
                ?>
                <a href="./index.php"><button class="ejemplo">
                    <span class="span-mother">
                        <span>V</span>
                        <span>O</span>
                        <span>L</span>
                        <span>V</span>
                        <span>E</span>
                        <span>R</span>
                    </span>
                    <span class="span-mother2">
                        <span>V</span>
                        <span>O</span>
                        <span>L</span>
                        <span>V</span>
                        <span>E</span>
                        <span>R</span>
                    </span>
                </button></a>
            </div>
        </div>
        <footer class="abajo">
            <?php include 'footer.php'; ?>
        </footer>
    </body>
</html>
