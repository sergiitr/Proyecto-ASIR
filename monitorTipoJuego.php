<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tienda_videojuegos";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error)
        die("Error de conexión: " . $conn->connect_error);

    $sql = "SELECT DAYNAME(c.fecha) AS dia_semana, j.tipo AS tipo_juego, sum(cantidad) AS cantidad
            FROM compran c JOIN detalle_pedido d ON c.idPed = d.idPed JOIN juegos j ON d.idJuego = j.idJuego GROUP BY dia_semana, tipo_juego";
    $result = $conn->query($sql);
    $data = array();
    if ($result->num_rows > 0) {
        $diasSemana = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // Inicializar la cantidad para cada combinación de día y tipo de juego
        while ($row = $result->fetch_assoc()) {
            $dia_semana = $row['dia_semana'];
            $tipo_juego = $row['tipo_juego'];
            $cantidad = $row['cantidad'];

            // Inicializar la cantidad para cada tipo de juego
            if (!isset($data[$tipo_juego]))
                $data[$tipo_juego] = array_fill_keys($diasSemana, 0);
            
            // Asignar la cantidad correspondiente al día de la semana y al tipo de juego
            $data[$tipo_juego][$dia_semana] = $cantidad;
        }

        // Asegurarse de que cada tipo de juego tenga todos los días
        foreach ($data as &$tipo_juego_data) 
            $tipo_juego_data = array_replace(array_fill_keys($diasSemana, 0), $tipo_juego_data);  
    }
    echo json_encode($data);
    $conn->close();
?>
