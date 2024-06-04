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
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="script.js"></script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <?php 
            if (!isset($_SESSION["usuario"]) || $_SESSION["administrador"] == 1) {
                header('Location: index.php');
                exit;
            }
        ?>
        <div class="item mt-2">
            <?php
                $footerClass = 'absolute';
                require_once "./login.php";
                $conexion = mysqli_connect($host, $user, $pass, $database);
                // Verificar la conexión
                if (!$conexion)
                    die("La conexión falló: " . mysqli_connect_error());
                // Obtener el ID del usuario
                $idUsuario = $_SESSION["usuario"];
                $resultadosPorPagina = 3;
                $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                $inicioConsulta = ($paginaActual - 1) * $resultadosPorPagina;

                // Obtener los pedidos del usuario
                $llamadaProcedimiento = mysqli_prepare($conexion, "CALL ObtenerPedidosCliente(?)");
                if ($llamadaProcedimiento) {
                    mysqli_stmt_bind_param($llamadaProcedimiento, "s", $idUsuario);
                    mysqli_stmt_execute($llamadaProcedimiento);
                    $result = mysqli_stmt_get_result($llamadaProcedimiento);

                    // Almacenar los pedidos agrupados por ID
                    $pedidosAgrupados = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $idPedido = $row['idPed'];
                        if (!isset($pedidosAgrupados[$idPedido])) {
                            $pedidoArray = array('idPed', $idPedido, 'total', $row['total'], 'detalles', array());
                            $pedidosAgrupados[$idPedido] = $pedidoArray;
                        }

                        // Agregar detalles del juego al pedido
                        $detalle = array('nombreJuego', $row['nombreJuego'], 'cantidad', $row['cantidad']);
                        array_push($pedidosAgrupados[$idPedido][5], $detalle);
                    }
                    // Mostrar los pedidos agrupados
                    $cantidadPedidos = count($pedidosAgrupados);
                    echo "<div class='container mt-4'>";
                        // Mensajes sobre los juegos según la cantidad de pedidos
                        if ($cantidadPedidos >= 1 && $cantidadPedidos < 3) 
                            echo "<h1>Enhorabuena! Puedes jugar al buscaminas</h1>";
                        if ($cantidadPedidos >= 3 && $cantidadPedidos < 5) 
                            echo "<h1>Enhorabuena! Puedes jugar al pacman y al buscaminas</h1>";
                        if ($cantidadPedidos >= 5)
                            echo "<h1>Enhorabuena! Puedes jugar a todos los minijuegos</h1>";
                    echo "</div>";
        
                    foreach ($pedidosAgrupados as $pedido) {
                        echo '
                        <div class="card5 mt-4">
                            <h1 align=center style="background-color: black; color:wheat; border-radius:15px 15px 0% 0%;">Pedido ID: ' . $pedido[1] . '</h1>';
                        foreach ($pedido[5] as $detalle) {
                            echo '
                            <p>Juego: ' . $detalle[1] . '</p>
                            <p>Cantidad: ' . $detalle[3] . '</p>
                            <hr>';
                        }
                        echo '<p>Total: €' . $pedido[3] . '</p>
                        </div>';
                    }

                    mysqli_stmt_close($llamadaProcedimiento);
                } else
                    echo "Error al preparar la llamada al procedimiento almacenado: " . mysqli_error($conexion);
                // Cerrar la conexión
                mysqli_close($conexion);
            ?>
        </div>
        <br><br><br>
        <footer class="cliente">
            <?php include 'footer.php'; ?>
        </footer>
        <script src="cambioFooter.js"></script>
    </body>
</html>