<?php
    session_start();
    if (!isset($_SESSION["usuario"]) || $_SESSION["administrador"] == 1) {
        header('Location: index.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Proyecto</title>
        <link rel="shortcut icon" href="./imagenes/logo.jpeg"/>
        <link rel="stylesheet" type="text/css" href="styles.css"/>
    </head>
    <body>
        <?php include 'header.php'; ?>

        <div class="container">
            <h1>Datos usuario</h1>
            <h2>Nombre</h2>
            <?php echo '<p>',$_SESSION["usuario"],'<p>';?>
            <h2>ID usuario</h2>
        </div>
        
        <footer class="abajo">
            <?php include 'footer.php'; ?>
        </footer>
    </body>
</html>