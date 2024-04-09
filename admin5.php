<?php 
    session_start();
    if (!isset($_SESSION["usuario"]) || $_SESSION["administrador"] !== 1) {
        header('Location: index.php');
        exit;
    }
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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="container">
            <h1>Monitor de Ventas x Precio</h1>
            <!-- Aquí se mostrará la gráfica de barras -->
            <div class="chart-container">
                <canvas id="barChart"></canvas>
            </div>
        </div>
        <script src="monitorizacion.js"></script>
        <div class="container">
            <h1>Monitor de Ventas x Tipo</h1>
            <div class="chart-container">
                <canvas id="barChartTipoJuego"></canvas>
            </div>
            <script src="monitorizacionTipoJuego.js"></script>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>