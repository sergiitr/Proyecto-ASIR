<?php 
    session_start();
    require_once "./login.php";
    $conexion = mysqli_connect($host, $user, $pass, $database);

    if (mysqli_connect_errno())
        die("Conexión fallida: " . mysqli_connect_error());

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = mysqli_real_escape_string($conexion, $_POST["usuario"]);
        $contrasena = $_POST["contrasena"];
        $sql = "SELECT contrasena, administrador FROM usuarios WHERE idusuario = ?";
        
        if ($stmt = mysqli_prepare($conexion, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $usuario);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            if (mysqli_stmt_num_rows($stmt) > 0) {
                mysqli_stmt_bind_result($stmt, $hashed_password, $administrador);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($contrasena, $hashed_password)) {
                        $_SESSION["usuario"] = $usuario;
                        $_SESSION["administrador"] = (int)$administrador;
                        $_SESSION['user_logged_in'] = true;
                        header("Location: index.php");
                    } else {
                        $_SESSION['error_login'] = "Contraseña equivocada";
                        header("Location: formInicioSesion.php");
                    }
                }
            } else {
                $_SESSION['error_login'] = "Usuario no encontrado";
                header("Location: formInicioSesion.php");
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conexion);
    }
?>