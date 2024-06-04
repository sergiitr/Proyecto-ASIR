<?php session_start(); ?>
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
    <div class="item container-fluid mt-4">
        <div class="row">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $idUsuario = $_POST['idUsuario'];
                require_once "./login.php";
                $conexion = mysqli_connect($host, $user, $pass, $database);

                if (!$conexion) {
                    die("Error de conexi¨®n a la base de datos: " . mysqli_connect_error());
                }

                $idUsuario = mysqli_real_escape_string($conexion, $idUsuario);
                $descuento = $_SESSION['descuento'];
                $totalGeneral = $_POST['totalGeneral'];
                $totalPedido = 0;

                // Calcular el total de la compra
                foreach ($_SESSION['carrito'] as $item) {
                    $idJuego = $item[0];
                    $cantStock = intval($item[2]); // Asegurarse de que la cantidad es un entero

                    $queryPrecio = "SELECT precio FROM juegos WHERE idJuego = '$idJuego'";
                    $resultadoPrecio = mysqli_query($conexion, $queryPrecio);

                    if ($resultadoPrecio && mysqli_num_rows($resultadoPrecio) > 0) {
                        $filaPrecio = mysqli_fetch_assoc($resultadoPrecio);
                        $precioJuego = floatval($filaPrecio['precio']);

                        $totalPorJuego = $cantStock * $precioJuego;
                        $totalPedido += $totalPorJuego;
                    } else {
                        die("No se encontr¨® el juego en la base de datos. Nombre del juego: $idJuego");
                    }
                }

                // Aplicar descuento
                $totalPedidoConDescuento = $totalPedido - ($totalPedido * $descuento / 100);

                // Insertar en la tabla compran
                $queryCompran = "INSERT INTO compran (idUsuario, total, fecha) VALUES ('$idUsuario', '$totalPedidoConDescuento', CURDATE())";
                $resultadoCompran = mysqli_query($conexion, $queryCompran);

                if ($resultadoCompran) {
                    $idPed = mysqli_insert_id($conexion); // Obtener el ID del pedido insertado

                    foreach ($_SESSION['carrito'] as $item) {
                        $idJuego = $item[0];
                        $cantStock = intval($item[2]); // Asegurarse de que la cantidad es un entero

                        // Insertar en la tabla detalle_pedido
                        $queryDetallesPedido = "INSERT INTO detalle_pedido (idPed, idJuego, cantidad) VALUES ('$idPed', '$idJuego', '$cantStock')";
                        $resultadoDetallesPedido = mysqli_query($conexion, $queryDetallesPedido);

                        if (!$resultadoDetallesPedido) {
                            die("Error al insertar detalle_pedido: " . mysqli_error($conexion));
                        }

                        // Actualizar el stock en la tabla juegos
                        $queryActualizarStock = "UPDATE juegos SET stock = stock - '$cantStock' WHERE idJuego = '$idJuego'";
                        $resultadoActualizarStock = mysqli_query($conexion, $queryActualizarStock);

                        if (!$resultadoActualizarStock) {
                            die("Error al actualizar el stock: " . mysqli_error($conexion));
                        }
                    }

                    echo '<p>Compra realizada con ¨¦xito.</p>';
                    unset($_SESSION['carrito']);
                } else {
                    die("Error al insertar en compran: " . mysqli_error($conexion));
                }

                mysqli_close($conexion);
            }
            ?>
            <a href="./index.php">
                <button class="ejemplo">
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
                </button>
            </a>
        </div>
    </div>
    <footer class="abajo">
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>