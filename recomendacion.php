
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
        <script src="script.js"></script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="container mt-4">
            <h1>Bienvenido a la Tienda de Videojuegos</h1>
            <div id="recomendaciones" class="mt-4">
                <?php
                    require_once "./login.php";
                    $conexion = mysqli_connect($host, $user, $pass, $database);
                    // Verifica la conexión
                    if ($conexion->connect_error)
                        die("Conexión fallida: " . $conexion->connect_error);
                    // Recupera la información del usuario desde la base de datos
                    $idUsuario = isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : '';
                    if ($idUsuario) {
                        // Verifica si el usuario ha realizado pedidos anteriormente
                        $query = "SELECT c.idCompania, c.nombreCompania, SUM(dp.cantidad) as totalUnidadesCompradas FROM compran co JOIN detalle_pedido dp ON co.idPed = dp.idPed JOIN juegos j ON dp.idJuego = j.idJuego 
                                    JOIN compania c ON j.idCompania = c.idCompania WHERE co.idUsuario = '$idUsuario' GROUP BY c.idCompania ORDER BY totalUnidadesCompradas DESC LIMIT 1";
                        $resultado_compras = $conexion->query($query);
                        if ($resultado_compras) {
                            if ($resultado_compras->num_rows > 0) {
                                // El usuario ha realizado pedidos anteriormente
                                $fila = $resultado_compras->fetch_assoc();
                                $idCompaniaRecomendada = $fila['idCompania'];
                                // Ahora, vamos a seleccionar juegos de la compañía recomendada
                                $queryRecomendacion = "SELECT nombre, plataforma, precio FROM juegos WHERE idCompania = $idCompaniaRecomendada AND 
                                                        idJuego NOT IN (SELECT idJuego FROM detalle_pedido WHERE idPed IN (SELECT idPed FROM compran WHERE idUsuario = '$idUsuario')) ORDER BY RAND() LIMIT 3";
                                $resultadoRecomendacion = $conexion->query($queryRecomendacion);
                                if ($resultadoRecomendacion->num_rows > 0) {
                                    // Muestra los juegos recomendados
                                    while ($filaRecomendada = $resultadoRecomendacion->fetch_assoc()) {
                                        $recomendacion .= "<p>Nombre: " . $filaRecomendada['nombre'] . "</p>";
                                        $recomendacion .= "<p>Plataforma: " . $filaRecomendada['plataforma'] . "</p>";
                                        $recomendacion .= "<p>Precio: €" . $filaRecomendada['precio'] . "</p>";
                                        $recomendacion .= "-------------------------<br>";
                                    }
                                } else 
                                    $recomendacion = "No hay juegos de la compañía recomendada en este momento."; 
                            } else {
                                $queryJuegoMasStockVendido = "SELECT j.idJuego, j.nombre, j.plataforma, j.precio, j.stock - COALESCE(SUM(dp.cantidad), 0) as stockVendido FROM juegos j LEFT JOIN detalle_pedido dp ON j.idJuego = dp.idJuego 
                                                                GROUP BY j.idJuego ORDER BY stockVendido DESC LIMIT 1";
                                $resultadoJuegoMasStockVendido = $conexion->query($queryJuegoMasStockVendido);
                                if ($resultadoJuegoMasStockVendido->num_rows > 0) {
                                    // Se encontró un juego con más stock vendido
                                    $juegoMasStockVendido = $resultadoJuegoMasStockVendido->fetch_assoc();
                                    $recomendacion = "Como no has realizado pedidos anteriormente, te recomendamos el juego con más stock vendido:<br>";
                                    $recomendacion .= "Nombre: " . $juegoMasStockVendido['nombre'] . "<br>";
                                    $recomendacion .= "Plataforma: " . $juegoMasStockVendido['plataforma'] . "<br>";
                                    $recomendacion .= "Precio: €" . $juegoMasStockVendido['precio'] . "<br>";
                                    $recomendacion .= "Stock Vendido: " . $juegoMasStockVendido['stockVendido'] . "<br>";
                                } else
                                    $recomendacion = "No hay juegos disponibles en este momento."; // No se encontraron juegos con stock vendido, puedes manejar esto según tus necesidades
                            }
                        } else
                            $recomendacion = "Error al realizar la consulta: " . $conexion->error; // Manejar el error de la consulta
                    } else
                        $recomendacion = "No hay información de usuario en la sesión."; // Manejar el caso cuando idUsuario no está definido en la sesión
                    $conexion->close();
                ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        // Simula una solicitud AJAX (puedes usar jQuery o fetch API para una implementación real)
                        // Aquí suponemos que el servidor devuelve las recomendaciones como un string
                        // Puedes ajustar esto según cómo esté estructurada tu respuesta del servidor
                        var recomendaciones = "<?php echo isset($recomendacion) ? $recomendacion : 'No hay recomendaciones disponibles'; ?>";
                        // Muestra las recomendaciones en el elemento con id 'recomendaciones'
                        document.getElementById('recomendaciones').innerHTML = '<h2>Juegos recomendados: </h2>' + recomendaciones;
                    });
                </script>
            </div>
        </div>
        <footer class="abajo">
            <?php include 'footer.php'; ?>
        </footer>
    </body>
</html>
