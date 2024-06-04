<?php
    require_once "login.php"; // Incluye los datos de conexión desde el archivo login.php
    function obtenerPlataformas($gameName) {
        global $host, $user, $pass, $database; // Accede a las variables de conexión globales definidas en login.php
        $conexion = mysqli_connect($host, $user, $pass, $database); // Establece la conexión a la base de datos
        if ($conexion->connect_error) 
            die("Error de conexión a la base de datos: " . $conexion->connect_error);
        $sql = "SELECT plataforma FROM juegos WHERE nombre = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $gameName);
        $stmt->execute();
        $stmt->bind_result($platform);
        $platforms = array();
        while ($stmt->fetch()) {
            $platforms[] = $platform;
        }
        $stmt->close();
        $conexion->close();
        return $platforms;
    }
    $conexion = mysqli_connect($host, $user, $pass, $database); // Conexión para el bloque principal del código
    if ($conexion->connect_error) 
        die("Error de conexión a la base de datos: " . $conexion->connect_error);
    // Obtener todos los nombres de los juegos disponibles en la base de datos
    $sql = "SELECT nombre FROM juegos";
    $result = $conexion->query($sql);
    $games = array();
    if ($result->num_rows > 0)
        while ($row = $result->fetch_assoc()) {
            $games[] = preg_quote($row["nombre"], '/');
        }
    $conexion->close();
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
        $platforms = obtenerPlataformas($gameName); // Llamada a la función para obtener las plataformas asociadas al juego
        if ($platforms) {
            $platformDetected = false;
            // Revisar si se menciona una plataforma específica en la pregunta
            $platformKeywords = array("para ", "en ", "dispon", "en ");
            foreach ($platformKeywords as $keyword) {
                if (strpos($question, $keyword) !== false) {
                    $platformDetected = true;
                    $platform = substr($question, strpos($question, $keyword) + strlen($keyword));
                    if (in_array($platform, $platforms))
                        $message = "Sí, el juego \"$gameName\" está disponible para $platform.";
                     else
                        $message = "No, el juego \"$gameName\" no está disponible para $platform.";
                    break;
                }
            }
            // Si no se detectó una plataforma específica en la pregunta, mostrar todas las plataformas
            if (!$platformDetected) {
                $platformsString = implode(", ", $platforms);
                $message = "El juego \"$gameName\" está disponible en las siguientes plataformas: $platformsString.";
            }
        } else
            $message = "Lo siento, \"$gameName\" no está disponible en este momento.";
    } else
        $message = "Lo siento, no se pudo identificar el nombre del juego en la pregunta.";
    header('Content-Type: application/json');
    echo json_encode(array("message" => $message));
?>