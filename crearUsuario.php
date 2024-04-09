<?php
    session_start();
    $error_login = '';

    // Redirigir al usuario si ya ha iniciado sesión
    if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
        header('Location: index.php'); // Puedes cambiar 'index.php' por la página a la que desees redirigir al usuario
        exit;
    }

    if (isset($_SESSION['error_login'])) {
        $error_login = $_SESSION['error_login'];
        unset($_SESSION['error_login']);
    }
?>
<!DOCTYPE html>
<html lang="es">
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
        <div class="item container-fluid mt-2">
            <form class="form" action="registro.php" method="post" enctype="multipart/form-data">
                <p class="title">Registrate ya! </p>
                <div class="flex">
                    <label>
                        <input name='nombre' type="text" required class="input">
                        <span>Nombre usuario</span>
                    </label>
                    <label>
                        <input name='tlfn' type='number' required class="input">
                        <span>Telefono</span>
                    </label>
                    <label>
                        <input name='direccion' type='text' required class="input">
                        <span>Direccion</span>
                    </label>
                </div>  
                        
                <label>
                    <input name='usuarios' type="text" required class="input">
                    <span>Nick</span>
                </label> 
                    
                <label>
                    <input name='contrasenas' type='password' required class="input">
                    <span>Contraseña</span>
                </label>
                <button class="submit">Crear</button>
                <p class="signin">Ya tienes cuenta? <a href="./formInicioSesion.php">Inicia Sesion</a> </p>
            </form>
        </div>
        <footer class="abajo">
            <?php include 'footer.php'; ?>
        </footer>
    </body>
</html>