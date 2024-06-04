<?php
    session_start();
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
        <style>
            body.dark-mode {
                background-color: #333;
                color: #fff;
            }
        </style>
        <script src="script.js"></script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="container mt-4">
            <?php
                // Verificar si se ha enviado el formulario
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Verificar si se ha enviado un correo electrónico
                    if (isset($_POST["email"]) && !empty($_POST["email"])) {
                        $email = $_POST["email"];
                        // Realizar la conexión a la base de datos (modifica según tus credenciales)
                        require_once "./login.php";
                        $conn = mysqli_connect($host, $user, $pass, $database);
                        // Verificar la conexión
                        if ($conn->connect_error) 
                            die("Error de conexión: " . $conn->connect_error);
                        // Consultar si el correo electrónico está en la base de datos
                        $sql_select = "SELECT * FROM usuarios WHERE correo = '$email'";
                        $result = $conn->query($sql_select);
                
                        if ($result->num_rows > 0) {
                            // Si el correo está en la base de datos, enviar código de descuento
                            $codigo_descuento = "BOLETIN";
                            echo "<h1>¡Gracias por suscribirte al boletín de noticias!</h1><br><p>Tu código de descuento es: $codigo_descuento y tendrás un 25% de descuento</p>";
                            // Actualizar el campo "subs" a 1 para el correo electrónico encontrado
                            $sql_update = "UPDATE usuarios SET subs = 1 WHERE correo = '$email'";
                            if ($conn->query($sql_update) === TRUE) {
                                // Actualización exitosa
                                echo "<br>";
                            } else {
                                // Error al actualizar
                                echo "Error al actualizar el campo 'subs': " . $conn->error;
                            }
                        } else 
                            echo "Lo sentimos, no eres cliente.";   // Si el correo no está en la base de datos, decir que no es cliente
                        // Cerrar la conexión a la base de datos
                        $conn->close();
                    } else
                        echo "Error: Debes proporcionar un correo electrónico válido."; // Mostrar un mensaje de error si no se proporcionó un correo electrónico
                }
            ?>
        </div>
        <div class="abajo">
            <?php include 'footer.php'; ?>
        </div>
    </body>
</html>