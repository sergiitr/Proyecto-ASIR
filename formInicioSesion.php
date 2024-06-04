<?php
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
        <link rel="stylesheet" type="text/css" href="styles.css"/>
        <title>Proyecto</title>
        <link rel="shortcut icon" href="./imagenes/logo.jpeg"/>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script src="script.js"></script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="item container mt-2">
            <div class="form-container">
                <h1 class="title">Bienvenido de nuevo!</h1>
                <form id="loginForm" action="loginInicioSesion.php" method="post" class="form">
                    <input type="text" class="input" placeholder="Nick" name="usuario">
                    <input type="password" class="input" placeholder="Contraseña" name="contrasena" id="passwordField">
                    <button type="button" class="toggle-password-btn" onclick="togglePassword()">Mostrar/Ocultar</button>
                    <div class="g-recaptcha" data-sitekey="6LdKTXIpAAAAALC6THSUnyPqgNeBjhdcjJiPTCsw" data-callback="enableSubmit"></div>
                    <button id="submitButton" type="submit" class="form-btn" disabled>Log in</button>
                </form>
                <p class="sign-up-label">
                    ¿No tienes cuenta?<span class="sign-up-link"><a href="./crearUsuario.php">Crea Una</a></span>
                </p>
            </div>
        </div>
        <script>
            var isVerified = false;
            function enableSubmit() {
                isVerified = true;
                document.getElementById("submitButton").removeAttribute("disabled");
            }
            function validateForm() {
                if (!isVerified) {
                    alert("Por favor, marque la casilla 'No soy un robot'");
                    return false;
                }
                return true;
            }
            function togglePassword() {
                var passwordField = document.getElementById("passwordField");
                if (passwordField.type === "password")
                    passwordField.type = "text";
                else
                    passwordField.type = "password";
            }
        </script>
        <?php if (!empty($error_login)): ?>
            <script>showPopup('<?php echo $error_login; ?>');</script>
        <?php endif; ?>
        
            <?php include 'footer.php'; ?>
        
    </body>
</html>