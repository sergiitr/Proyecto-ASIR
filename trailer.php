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
        <link rel="stylesheet" href="styles.css">
        <link rel="shortcut icon" href="./imagenes/logo.jpeg"/>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="item container mt-4">
            <?php
                // Verificar si se ha proporcionado el parámetro del nombre del juego en la URL
                if(isset($_GET['juego'])) {
                    // Obtener el nombre del juego de la URL y limpiarlo para evitar posibles ataques de inyección de SQL
                    $nombreJuego = htmlspecialchars($_GET['juego']);
                    // Establecer la conexión a la base de datos
                    require_once "login.php"; // Asegúrate de que este archivo contenga los datos de conexión
                    $conexion = mysqli_connect($host, $user, $pass, $database);
                    if (!$conexion) 
                        die("Error de conexión: " . mysqli_connect_error());

                    // Obtener el enlace del tráiler del juego desde la base de datos
                    $trailer = obtenerTrailerPorNombreJuego($nombreJuego, $conexion);

                    // Mostrar el tráiler si se encontró uno
                    if($trailer) {
                        echo '<h1>Tráiler de ' . $nombreJuego . '</h1>';
                        echo '<iframe class="yt" width="1024" src="', $trailer, '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
                    } else 
                        echo '<h1>No se encontró el tráiler para ' . $nombreJuego . '</h1>';
                    // Cerrar la conexión a la base de datos
                    mysqli_close($conexion);
                } else
                    echo '<h1>No se proporcionó el nombre del juego</h1>';

                // Función para obtener el enlace del tráiler de un juego por su nombre desde la base de datos
                function obtenerTrailerPorNombreJuego($nombreJuego, $conexion) {
                    // Escapar el nombre del juego para evitar inyección de SQL
                    $nombreJuegoEscapado = mysqli_real_escape_string($conexion, $nombreJuego);
                    // Consulta para obtener el enlace del tráiler del juego
                    $consulta = "SELECT trailer FROM juegos WHERE nombre = '$nombreJuegoEscapado'";
                    // Ejecutar la consulta
                    $resultado = mysqli_query($conexion, $consulta);
                    // Verificar si se encontró el tráiler y devolverlo
                    if($resultado && mysqli_num_rows($resultado) > 0) {
                        $fila = mysqli_fetch_assoc($resultado);
                        return $fila['trailer'];
                    } else
                        return null; // Devolver null si no se encontró el tráiler para el juego
                }
            ?>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>