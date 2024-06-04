<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Busca Minas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="styles.css">
        <link rel="shortcut icon" href="./imagenes/logo.jpeg"/>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <?php
            require_once "login.php";
            $conexion=mysqli_connect($host,$user,$pass,$database);
            mysqli_select_db($conexion,$database);
            if (!$conexion)
                die("La conexión a la base de datos falló: " . mysqli_connect_error());

            $idUsuario = $_SESSION['usuario'];
            $consulta = "SELECT COUNT(*) AS total_pedidos FROM compran WHERE idUsuario = '$idUsuario'";
            $resultado = mysqli_query($conexion, $consulta);
            $fila = mysqli_fetch_assoc($resultado);
            $total_pedidos = $fila['total_pedidos'];

            mysqli_close($conexion);
        ?>
        <div class="container mt-4">
            <?php if ($total_pedidos >= 1 || $_SESSION['administrador']==1): ?>
                <h1>BuscaMinas</h1>
                <div class="row justify-content-center">
                    <div class="col-auto" id="container"></div>
                </div>
                <div class="row justify-content-center mt-3">
                    <button class="btn btn-primary" id="restartButton">Volver a Jugar</button>
                </div>
                <script src="buscaMinas.js" defer></script>
            <?php else: ?>
                <p>No has realizado suficientes compras para acceder al juego.</p>
            <?php endif; ?>
        </div>
        <div class="abajo">
        <?php include 'footer.php'; ?>
        </div>
    </body>
</html>