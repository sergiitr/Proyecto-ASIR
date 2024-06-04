<?php
    // Incluir archivo de conexión a la base de datos
    require_once "./login.php";
    // Intentar establecer la conexión a la base de datos
    $conexion = mysqli_connect($host, $user, $pass, $database);
    // Verificar la conexión
    if (!$conexion)
        die("Error de conexión a la base de datos: " . mysqli_connect_error()); // En caso de error de conexión, enviar un mensaje de error y terminar el script
    // Consulta para obtener las ventas por país
    $sql = "SELECT pais, COUNT(id) AS total_ventas FROM ubicaciones GROUP BY pais";
    // Ejecutar la consulta
    $result = mysqli_query($conexion, $sql);
    // Verificar si la consulta fue exitosa
    if ($result) {
        // Verificar si se obtuvieron resultados
        if (mysqli_num_rows($result) > 0) {
            // Array para almacenar los datos de ventas por país
            $ventas_por_pais = array();
            // Obtener los datos de la consulta y almacenarlos en el array
            while ($row = mysqli_fetch_assoc($result)) {
                $ventas_por_pais[] = array(
                    'pais' => $row['pais'],
                    'cantidad' => $row['total_ventas']
                );
            }
            // Devolver los datos en formato JSON
            echo json_encode($ventas_por_pais);
        } else {
            // Si no se encontraron resultados, enviar un mensaje indicando esto
            echo "No se encontraron datos de ventas por país.";
        }
    } else
        echo "Error al ejecutar la consulta: " . mysqli_error($conexion);    // Si hubo un error al ejecutar la consulta, enviar un mensaje de error
    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
?>