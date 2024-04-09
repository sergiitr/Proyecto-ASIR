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
            <?php
                $db_hostname = "localhost";
                $db_database = "tienda_videojuegos";
                $db_username = "root";
                $db_password = "";
                $conexion = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
                if (mysqli_connect_errno()) {
                    die("Conexión fallida: " . mysqli_connect_error());
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $usuario = $_POST["usuarios"];
                    $contrasena = $_POST["contrasenas"];
                    $tlfn = $_POST["tlfn"];
                    $direccion = $_POST["direccion"];
                    $nombre = $_POST["nombre"];
                    $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO usuarios (idusuario, nombre, direccion, tlfn, contrasena, administrador) VALUES ('$usuario', '$nombre', '$direccion', '$tlfn', '$contrasena_cifrada',0)";

                    if (mysqli_query($conexion, $sql)) {
                        echo "Usuario registrado correctamente";
                        header("Location: formInicioSesion.php");
                    } else
                        echo "Error al registrar el usuario: " . mysqli_error($conexion);
                }

                mysqli_close($conexion);
            ?>

            <a href="./crearUsuario.php"><button class="ejemplo">
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
            </button></a>
        </div>
        <footer class="abajo">
            <?php include 'footer.php'; ?>
        </footer>
    </body>
</html>











