
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Proyecto</title>
        <link rel="shortcut icon" href="./imagenes/logo.jpeg"/>
        <link rel="stylesheet" type="text/css" href="styles.css"/>
        <style>
            @media screen and (max-width:1024px) {
                .form-group {
                    margin-bottom: 2%;
                    display: flex;
                    align-items: flex-start;
                    flex-wrap: wrap;
                }
                .form-group label {
                    width: 100%; /* Ancho fijo para las etiquetas */
                    margin-right: 2%; /* Espacio entre la etiqueta y el campo de entrada */
                }
                .form-group input {
                    flex: 1; /* El campo de entrada ocupa todo el espacio restante */
                    width: 20%;
                }
            }
            @media screen and (min-width:1024px) {
                .form-group {
                    margin-bottom: 2%;
                    display: flex;
                    align-items: center;
                }
                .form-group label {
                    width: 20%; /* Ancho fijo para las etiquetas */
                    margin-right: 2%; /* Espacio entre la etiqueta y el campo de entrada */
                }
                .form-group input {
                    width: 30%;
                }
            }
        </style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <?php
            if (!isset($_SESSION["usuario"])) {
                header('Location: index.php');
                exit;
            }
        ?>
        <div class="container mt-4">
            <h1>Datos usuario</h1>
        </div>
        <hr>
        <div class="container mt-4">
            <h2>Nombre</h2>
            <?php echo '<p>',$_SESSION["usuario"],'<p>';?>
            <h2>Cambio de contraseña</h2>
            <form action="actualizarContrasena.php" method="post">
                <div class="form-group">
                    <label for="currentPassword">Contraseña Actual:</label>
                    <input type="password" id="currentPassword" name="currentPassword" required>
                </div>
                <div class="form-group">
                    <label for="newPassword">Nueva Contraseña:</label>
                    <input type="password" id="newPassword" name="newPassword" pattern="^(?=.*[a-z])(?=.*[A-Z]).{7,}$" title="La contraseña debe tener al menos 7 caracteres, incluyendo al menos una letra mayúscula y una letra minúscula." required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirmar Nueva Contraseña:</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                </div>
                <button type="submit">Actualizar Contraseña</button>
            </form>
    
        </div>
    
        <footer class="abajo">
            <?php include 'footer.php'; ?>
        </footer>
    </body>
</html>