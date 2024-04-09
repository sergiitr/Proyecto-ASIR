<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tienda_videojuegos";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error)
        die("Error de conexión a la base de datos: " . $conn->connect_error);

    // Obtener todos los nombres de los juegos disponibles en la base de datos
    $sql = "SELECT nombre FROM juegos";
    $result = $conn->query($sql);
    $games = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $games[] = preg_quote($row["nombre"], '/');
        }
    }
    $conn->close();

    // Construir la expresión regular con todos los nombres de los juegos
    $regex = '/\b(' . implode('|', $games) . ')\b/i';
    // Obtener el nombre del juego de la solicitud y limpiarlo para evitar inyección de SQL
    $question = trim($_GET['gameName']);
    // Extraer el nombre del juego de la pregunta del usuario
    preg_match($regex, $question, $matches);
    $gameName = isset($matches[1]) ? $matches[1] : null;

    // Consultar la disponibilidad del juego en la base de datos
    if ($gameName) {
        // Consulta de disponibilidad del juego aquí
        $platforms = obtenerPlataformas($gameName); // Función para obtener las plataformas asociadas al juego
        if ($platforms) {
            $platformsString = implode(", ", $platforms);
            $message = "El juego \"$gameName\" está disponible en las siguientes plataformas: $platformsString.";
        } else
            $message = "Lo siento, \"$gameName\" no está disponible en este momento.";
    } else
        $message = "Lo siento, no se pudo identificar el nombre del juego en la pregunta.";

    header('Content-Type: application/json');
    echo json_encode(array("message" => $message));

    // Función para obtener las plataformas asociadas a un juego
    function obtenerPlataformas($gameName) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "tienda_videojuegos";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Error de conexión a la base de datos: " . $conn->connect_error);
        }

        $sql = "SELECT plataforma FROM juegos WHERE nombre = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $gameName);
        $stmt->execute();
        $stmt->bind_result($platform);
        $platforms = array();
        while ($stmt->fetch()) {
            $platforms[] = $platform;
        }
        $stmt->close();
        $conn->close();
        return $platforms;
    }
?>