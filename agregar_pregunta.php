<?php
    // Verificar si se recibieron datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar si se recibieron los datos necesarios
        if (isset($_POST['titulo']) && isset($_POST['descripcion'])) {
            // Recibir y limpiar los datos del formulario
            $titulo = htmlspecialchars($_POST['titulo']);
            $descripcion = htmlspecialchars($_POST['descripcion']);
            // Iniciar la sesión (si no se ha iniciado ya)
            session_start();
            // Verificar si el usuario ha iniciado sesión
            if (isset($_SESSION['usuario'])) {
                // Conexión a la base de datos
                require_once "./login.php";
                $conexion = mysqli_connect($host, $user, $pass, $database);
                // Comprobar conexión
                if (!$conexion)
                    die("Conexión fallida: " . mysqli_connect_error());

                // Preparar consulta para insertar la nueva pregunta en la base de datos
                $sql = "INSERT INTO foro (titulo, usuario, descripcion, fecha) VALUES (?, ?, ?,curdate())";
                $stmt = mysqli_prepare($conexion, $sql);
                // Verificar si la preparación de la consulta fue exitosa
                if ($stmt) {
                    // Vincular parámetros a la consulta
                    $usuario = $_SESSION["usuario"];
                    mysqli_stmt_bind_param($stmt, "sss", $titulo, $usuario, $descripcion);
                    // Ejecutar la consulta
                    if (mysqli_stmt_execute($stmt))
                        echo "Nueva pregunta agregada correctamente.";
                    else
                        echo "Error al agregar la nueva pregunta: " . mysqli_error($conexion);
                    mysqli_stmt_close($stmt);
                } else
                    echo "Error al preparar la consulta: " . mysqli_error($conexion);
                mysqli_close($conexion);
            } else
                echo "El usuario no ha iniciado sesión.";
        } else
            echo "Faltan datos del formulario.";
    } else
        echo "Acceso no permitido.";
?>