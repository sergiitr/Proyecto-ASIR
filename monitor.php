<?php
    // Conexión a la base de datos (reemplaza con tus datos)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tienda_videojuegos";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) 
        die("Error de conexión: " . $conn->connect_error);

    // Consulta SQL para obtener los datos
    $sql = "SELECT DAYNAME(fecha) AS dia_semana, SUM(total) AS total_ventas FROM compran GROUP BY dia_semana";
    $result = $conn->query($sql);
    // Crear un array para almacenar los datos
    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = array('dia_semana' => $row['dia_semana'], 'total_ventas' => $row['total_ventas']);
        }
    }
    // Convertir el array a formato JSON
    echo json_encode($data);
    // Cerrar conexión
    $conn->close();
?>
