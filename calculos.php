<?php
    require_once "./login.php";
    $conexion = mysqli_connect($host, $user, $pass, $database);
    // Verificar la conexión
    if ($conexion->connect_error)
        die("Error de conexión: " . $conexion->connect_error);
    // Consulta SQL para obtener el día con menos ingresos
    $sql_dia_oferta = "SELECT DAYNAME(fecha) AS dia_oferta FROM compran WHERE WEEK(fecha) = WEEK(CURDATE()) ORDER BY SUM(total) ASC LIMIT 1";
    $result_dia_oferta = $conexion->query($sql_dia_oferta);

    // Obtener el día con menos ingresos
    $dia_oferta = "";
    if ($result_dia_oferta->num_rows > 0) {
        $row_dia_oferta = $result_dia_oferta->fetch_assoc();
        $dia_oferta = $row_dia_oferta['dia_oferta'];
    }

    // Marcar el día con oferta en la base de datos
    $sql_update = "UPDATE compran SET oferta = 1 WHERE DAYNAME(fecha) = '$dia_oferta' AND WEEK(fecha) = WEEK(CURDATE())";
    if ($conexion->query($sql_update) === TRUE)
        echo "Día con oferta actualizado correctamente. ";
    else
        echo "Error al actualizar el día con oferta: " . $conexion->error . ". ";
    $conexion->close();
?>
