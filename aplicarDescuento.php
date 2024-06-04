<?php
    session_start();
    // Verificar si se ha enviado un código de descuento
    if(isset($_POST['codigoDescuento'])) {
        $codigoDescuento = $_POST['codigoDescuento'];
        // Conectar con la base de datos
        require_once "login.php"; // Asegúrate de que este archivo contenga la conexión a la base de datos
        $conexion = mysqli_connect($host, $user, $pass, $database);
        // Verificar conexión exitosa
        if (!$conexion)
            die("Error de conexión a la base de datos: " . mysqli_connect_error());
        // Consultar la base de datos para verificar si el código de descuento existe y está dentro del rango de fechas válido
        $query = "SELECT cantidad FROM codigosDescuento WHERE codigo = '$codigoDescuento' AND CURDATE() BETWEEN fechaInicio AND fechaFin";
        $result = mysqli_query($conexion, $query);
        // Verificar si la consulta fue exitosa
        if (!$result)
            die("Error al ejecutar la consulta: " . mysqli_error($conexion));
        // Verificar si se encontró algún resultado
        if(mysqli_num_rows($result) > 0) {
            // El código de descuento es válido, obtener el valor del descuento
            $row = mysqli_fetch_assoc($result);
            $descuento = $row['cantidad'];
            // Redondear el descuento a dos decimales
            $descuento = round($descuento, 2);
            // Actualizar el descuento aplicado en la sesión del usuario
            $_SESSION['descuento'] = $descuento;
            // Redireccionar de vuelta a la página del carrito
            header("Location: carrito.php");
            exit();
        } else {
            // No se encontró el código de descuento válido
            $_SESSION['descuento'] = 0; // Establecer el descuento en 0 en caso de código inválido
            $_SESSION['mensaje'] = "El código de descuento ingresado no es válido.";
            header("Location: carrito.php");
            exit();
        }
    } else {
        // No se envió ningún código de descuento
        $_SESSION['descuento'] = 0; // Establecer el descuento en 0 si no se envió ningún código
        $_SESSION['mensaje'] = "No se recibió ningún código de descuento.";
        header("Location: carrito.php");
        exit();
    }
?>