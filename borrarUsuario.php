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
    </head>
    <body>
        <?php include 'header.php'; ?>
        <script>
            var logoutLink = document.getElementById("logout-link");
            function redirectPage(value) {
                if (value === "carrito")
                    window.location.href = "./carrito.php";
                else if (value === "alquiler")
                    window.location.href = "./alquiler.php";
            }
            function redirectPage2(value) {
                if (value === "pedidos")
                    window.location.href = "./cliente.php";
                else if (value === "cerrarSesion") {
                    console.log("Cerrando sesión...");
                    logoutLink.style.display = "block";
                    cerrarSesion();
                }  else if (value === "borrarUsuario") {
                    var confirmar = confirm("¿Está seguro de que desea borrar su usuario? Esta acción no se puede deshacer.");
                    if (confirmar)
                        window.location.href = "./borrarUsuario.php";
                }
            }
            function cerrarSesion()
                window.location.href = './cerrarSesion.php';
        </script>
        <div>
            <?php
                require_once "./login.php";
                $conexion = mysqli_connect($host, $user, $pass, $database);
                if (mysqli_connect_errno())
                    die("Conexión fallida: " . mysqli_connect_error());
                $idUsuario = $_SESSION["usuario"];
                // Se elimina la sesión antes de ejecutar el trigger
                session_destroy();
                // Se prepara y ejecuta la consulta para borrar el usuario en la base de datos
                $sqlBorrarUsuario = "DELETE FROM usuarios WHERE idUsuario = ?";
                $stmt = mysqli_prepare($conexion, $sqlBorrarUsuario);
                if ($stmt === false)
                    die("Error al preparar la consulta para borrar usuario: " . mysqli_error($conexion));
                mysqli_stmt_bind_param($stmt, "s", $idUsuario);
                if (mysqli_stmt_execute($stmt))
                    echo "Usuario borrado exitosamente.";
                else
                    echo "Error al borrar el usuario: " . mysqli_stmt_error($stmt);
                mysqli_stmt_close($stmt);
                mysqli_close($conexion);
            ?>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>