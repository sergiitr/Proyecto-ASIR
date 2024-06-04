<?php
    session_start();
    // Verificar si el usuario está logueado
    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit;
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperar las contraseñas del formulario
        $currentPassword = $_POST["currentPassword"];
        $newPassword = $_POST["newPassword"];
        $confirmPassword = $_POST["confirmPassword"];
        // Validar que la nueva contraseña coincida con la confirmación
        if ($newPassword !== $confirmPassword) {
            $_SESSION['error_login'] = 'Las contraseñas no coinciden.';
            header('Location: datosUsuario.php');
            exit;
        }
        // Validar la fortaleza de la nueva contraseña
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{7,}$/', $newPassword)) {
            $_SESSION['error_login'] = 'La contraseña debe tener al menos 7 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula y un número.';
            header('Location: datosUsuario.php');
            exit;
        }
        // Conectarse a la base de datos (asegúrate de reemplazar los valores con los de tu propia base de datos)
        require_once "login.php";
        $conexion = new mysqli($host, $user, $pass, $database);
        // Verificar la conexión
        if ($conexion->connect_error)
            die("La conexión ha fallado: " . $conexion->connect_error);
        // Escapar las variables para evitar inyección de SQL
        $currentPassword = $conexion->real_escape_string($currentPassword);
        $newPassword = $conexion->real_escape_string($newPassword);
        // Obtener el ID de usuario de la sesión actual
        $userId = $_SESSION['usuario'];
        // Consulta SQL para obtener la contraseña almacenada en la base de datos
        $sql = "SELECT contrasena FROM usuarios WHERE idUsuario = '$userId'";
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            // Obtener la contraseña almacenada en la base de datos
            $row = $result->fetch_assoc();
            $storedPassword = $row["contrasena"];
            // Verificar si la contraseña actual proporcionada coincide con la contraseña almacenada
            if (password_verify($currentPassword, $storedPassword)) {
                // La contraseña actual es correcta, proceder a actualizarla en la base de datos
                // Hashear la nueva contraseña antes de almacenarla en la base de datos
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                // Consulta SQL para actualizar la contraseña
                $updateSql = "UPDATE usuarios SET contrasena = '$hashedPassword' WHERE idUsuario = '$userId'";
                if ($conexion->query($updateSql) === TRUE) {
                    // Contraseña actualizada con éxito
                    $_SESSION['success_message'] = 'Contraseña actualizada con éxito.';
                    header('Location: index.php');
                    exit;
                } else {
                    // Error al actualizar la contraseña
                    $_SESSION['error_login'] = 'Error al actualizar la contraseña: ' . $conexion->error;
                    header('Location: datosUsuario.php');
                    exit;
                }
            } else {
                // La contraseña actual proporcionada no coincide
                $_SESSION['error_login'] = 'La contraseña actual es incorrecta.';
                header('Location: datosUsuario.php');
                exit;
            }
        } else {
            // No se encontró el usuario en la base de datos
            $_SESSION['error_login'] = 'Usuario no encontrado.';
            header('Location: datosUsuario.php');
            exit;
        }
        // Cerrar la conexión a la base de datos
        $conexion->close();
    }
?>