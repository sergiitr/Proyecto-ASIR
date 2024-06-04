<?php
    // Incluir archivo de conexión a la base de datos
    require_once "./login.php";
    
    // Intentar establecer la conexión a la base de datos
    $conn = mysqli_connect($host, $user, $pass, $database);
    
    // Verificar la conexión
    if (!$conn) {
        // En caso de error de conexión, enviar un mensaje de error y terminar el script
        die("Error de conexión a la base de datos: " . mysqli_connect_error());
    }
    
    // Consulta para obtener las ventas por país
    $sql = "SELECT ciudad, COUNT(id) AS total_ventas FROM ubicaciones GROUP BY ciudad";
    
    // Ejecutar la consulta
    $result = mysqli_query($conn, $sql);
    
    // Verificar si la consulta fue exitosa
    if ($result) {
        // Verificar si se obtuvieron resultados
        if (mysqli_num_rows($result) > 0) {
            // Array para almacenar los datos de ventas por país
            $ventas_por_ciudad = array();
    
            // Obtener los datos de la consulta y almacenarlos en el array
            while ($row = mysqli_fetch_assoc($result)) {
                $ventas_por_ciudad[] = array(
                    'ciudad' => $row['ciudad'], // Aquí se debe usar 'ciudad' en lugar de 'pais'
                    'cantidad' => $row['total_ventas']
                );
            }
    
            // Devolver los datos en formato JSON
            echo json_encode($ventas_por_ciudad);
        } else {
            // Si no se encontraron resultados, enviar un mensaje indicando esto
            echo "No se encontraron datos de ventas por país.";
        }
    } else {
        // Si hubo un error al ejecutar la consulta, enviar un mensaje de error
        echo "Error al ejecutar la consulta: " . mysqli_error($conn);
    }
    
    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
?>
