<?php
    require_once "./login.php";
    $conexion = mysqli_connect($host, $user, $pass, $database);
    if ($conexion->connect_error)
        die("Error de conexión: " . $conexion->connect_error);
    $sql = "SELECT DAYNAME(c.fecha) AS dia_semana, j.tipo AS tipo_juego, sum(cantidad) AS cantidad FROM compran c JOIN detalle_pedido d ON c.idPed = d.idPed JOIN juegos j ON d.idJuego = j.idJuego GROUP BY dia_semana, tipo_juego";
    $result = $conexion->query($sql);
    $data = array();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Codificar los valores de tipo_juego utilizando utf8_encode()
            $row['tipo_juego'] = utf8_encode($row['tipo_juego']);
            $data[] = $row;
        }
    } else
        echo "No se encontraron datos.";
    echo json_encode($data);
    $conexion->close();
?>