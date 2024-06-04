<?php
    $error_login = '';
    // Redirigir al usuario si ya ha iniciado sesión
    if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
        header('Location: index.php');
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
        <script src="script.js"></script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="item container mt-4">
            <form class="form" action="registro.php" method="post" enctype="multipart/form-data">
                <h1 class="title">Regístrate ya!</h1>
                <div class="flex">
                    <label>
                        <input name='nombre' type="text" required class="input">
                        <span>Nombre de usuario</span>
                    </label>
                    <label>
                        <input name='usuarios' type="text" required class="input">
                        <span>Nick</span>
                    </label>
                </div>  
                <div class="flex">
                    <label>
                        <input name='correo' type="email" required class="input">
                        <span>Correo Electrónico</span>
                    </label> 
                    <label>
                        <input name='tlfn' type='number' required class="input">
                        <span>Teléfono</span>
                    </label>
                    <label>
                        <input name='direccion' type='text' required class="input">
                        <span>Dirección</span>
                    </label>
                </div> 
                <div class="flex">
                    <label>
                        <input id="contrasena" name='contrasena' type='password' required class="input">
                        <span>Contraseña</span>
                        <button type="button" class="toggle-password-btn" onclick="togglePassword()">Mostrar/Ocultar</button>
                    </label>
                    <label>
                        <input id="confirmcontrasena" name='confirmar_contrasena' type='password' required class="input">
                        <span>Confirmar Contraseña</span>
                    </label>

                </div>
                <div id="password-strength-meter">
                    <script src="./contrasena.js"></script>
                </div>
                <button id="submitButton"class="submit">Crear</button>
                <p class="signin">¿Ya tienes cuenta? <a href="./formInicioSesion.php">Inicia Sesión</a></p>
            </form>
        </div>
        <script>
            function togglePassword() {
                var passwordField = document.getElementById("contrasena");
                var confirmPasswordField = document.getElementById("confirmcontrasena");
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    confirmPasswordField.type = "text";
                } else {
                    passwordField.type = "password";
                    confirmPasswordField.type = "password";
                }
            }
        </script>
        <?php include 'footer.php'; ?>
    </body>
</html>