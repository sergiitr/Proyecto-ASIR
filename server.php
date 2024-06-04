<?php
// Establecer el tipo de contenido como JSON
header('Content-Type: application/json');
require_once "login.php";
        $conn = mysqli_connect($host, $user, $pass, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos de los clientes
$sql = "SELECT ip, pais FROM clientes";
$result = $conn->query($sql);

$clientes = array();

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener cada fila de resultados y agregarla al array de clientes
    while($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();

// Devolver los datos como respuesta JSON
echo json_encode(['clientes' => $clientes]);
?>
