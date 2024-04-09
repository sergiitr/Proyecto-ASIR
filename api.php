<?php
    // Configura la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tienda_videojuegos";

    // Crea la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica la conexión
    if ($conn->connect_error) 
        die("Conexión fallida: " . $conn->connect_error);

    // Obtiene el nombre del juego del cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"));
    $gameName = $data->messages[0]->content;

    // Consulta la base de datos para verificar la disponibilidad del juego
    $sql = "SELECT nombre, plataforma FROM juegos WHERE nombre = '$gameName'";
    $result = $conn->query($sql);

    // Envia la respuesta al cliente
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $message = "Sí, el juego '" . $row["nombre"] . "' está disponible en la página. Plataformas: " . implode(', ', getPlatforms($gameName, $conn));
        echo json_encode(array("message" => $message));
    } else
        echo json_encode(array("message" => "Lo siento, no puedo determinar la disponibilidad del juego en este momento."));

    // Función para obtener todas las plataformas asociadas al juego
    function getPlatforms($gameName, $conn) {
        $platforms = array();
        $sql = "SELECT plataforma FROM juegos WHERE nombre = '$gameName'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $platforms[] = $row["plataforma"];
            }
        }
        return $platforms;
    }
    // Cierra la conexión a la base de datos
    $conn->close();
?>
