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
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="script.js"></script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <?php 
            if (!isset($_SESSION["usuario"]) || $_SESSION["administrador"] !== 1) {
                header('Location: index.php');
                exit;
            }
        ?>
        <?php
            require_once "login.php";
            // Establecer la conexión a la base de datos
            $conexion = mysqli_connect($host, $user, $pass, $database);
            // Verificar la conexión
            if (mysqli_connect_errno())
                die("Conexión fallida: " . mysqli_connect_error());
            // Crear el procedimiento almacenado
            $sql = "DROP PROCEDURE IF EXISTS CopiaSeguridad;
                    CREATE PROCEDURE CopiaSeguridad()
                    BEGIN
                        DROP TABLE IF EXISTS alquilan_bk, compania_bk, compran_bk, detalle_pedido_bk, juegos_bk, usuarios_bk;
                        CREATE TABLE alquilan_bk LIKE alquilan;
                        INSERT INTO alquilan_bk SELECT * FROM alquilan;
                        CREATE TABLE compania_bk LIKE compania;
                        INSERT INTO compania_bk SELECT * FROM compania;
                        CREATE TABLE compran_bk LIKE compran;
                        INSERT INTO compran_bk SELECT * FROM compran;
                        CREATE TABLE detalle_pedido_bk LIKE detalle_pedido;
                        INSERT INTO detalle_pedido_bk SELECT * FROM detalle_pedido;
                        CREATE TABLE juegos_bk LIKE juegos;
                        INSERT INTO juegos_bk SELECT * FROM juegos;
                        CREATE TABLE usuarios_bk LIKE usuarios;
                        INSERT INTO usuarios_bk SELECT * FROM usuarios;
                    END";
            // Si se ha pulsado el botón
            if (isset($_POST['backup_button'])) {
                // Llamar al procedimiento almacenado
                $sql2 = "CALL CopiaSeguridad()";
                if (mysqli_query($conexion, $sql2))
                    echo "Copia de seguridad creada exitosamente.";
                else
                    echo "Error al crear copia de seguridad: " . mysqli_error($conexion);
            }
            // Cerrar la conexión a la base de datos
            mysqli_close($conexion);
        ?>

        <form method="post">
            <button type="submit" name="backup_button">Crear Copia de Seguridad</button>
        </form>
        <footer class="abajo">
            <?php include 'footer.php'; ?>
        </footer>
    </body>
</html>