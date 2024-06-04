<?php
    require_once "login.php";
    $conn = mysqli_connect($host, $user, $pass, $database);
    // Verifica la conexión
    if ($conn->connect_error)
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    // Obtener la dirección IP del visitante
    $visitor_ip = $_SERVER['REMOTE_ADDR'];
    // Verificar si la dirección IP ha realizado demasiadas inserciones recientemente
    $max_inserts_per_hour = 5; // Cambia esto según tus necesidades
    if (!ipExceedsLimit($conn, $visitor_ip, $max_inserts_per_hour)) {
        // Función para obtener la ubicación del visitante utilizando la API de Geoplugin
        $location_data = getLocation();
        // Obtener datos específicos de la ubicación
        $country = $location_data['geoplugin_countryName'];
        $city = $location_data['geoplugin_city'];
        $latitude = $location_data['geoplugin_latitude'];
        $longitude = $location_data['geoplugin_longitude'];
        // Insertar datos en la base de datos
        if ($city != "")
            insertLocation($conn, $country, $city, $latitude, $longitude, $visitor_ip);
        else {
            $city = "No definida";
            insertLocation($conn, $country, $city, $latitude, $longitude, $visitor_ip);
        }
    }
    // Cierra la conexión
    $conn->close();
    /*
     * Función para obtener la ubicación del visitante utilizando la API de Geoplugin
     */
    function getLocation() {
        $url = "http://www.geoplugin.net/json.gp?ip=" . $_SERVER['REMOTE_ADDR'];
        $response = file_get_contents($url);
        return json_decode($response, true);
    }
    
    /*
     * Función para verificar si la IP excede el límite de inserciones
     */
    function ipExceedsLimit($conn, $ip, $max_inserts_per_hour) {
        $sql = "SELECT COUNT(*) AS num_inserts FROM ubicaciones WHERE ip = ? AND fecha_insert > DATE_SUB(NOW(), INTERVAL 1 HOUR)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $ip);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['num_inserts'] >= $max_inserts_per_hour;
        } else
            return false;
    }
    
    /*
     * Función para insertar datos de ubicación en la base de datos
     */
    function insertLocation($conn, $country, $city, $latitude, $longitude, $ip) {
        $sql = "INSERT INTO ubicaciones (pais, ciudad, latitud, longitud, ip) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdds", $country, $city, $latitude, $longitude, $ip);
        $stmt->execute();
    }
?>