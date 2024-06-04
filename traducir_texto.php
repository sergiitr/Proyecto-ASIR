<?php
    // Verifica si se proporcionó un texto y un idioma destino
    if(isset($_POST['texto']) && isset($_POST['idioma'])) {
        // Texto a traducir y idioma destino
        $texto = $_POST['texto'];
        $idioma_destino = $_POST['idioma'];
        // Llama a la función para traducir el texto
        $texto_traducido = traducirTexto($texto, $idioma_destino);
        // Devuelve el texto traducido
        echo $texto_traducido;
    } else
        echo "Error: Texto o idioma no proporcionados.";    // Si no se proporcionó texto o idioma, muestra un mensaje de error
    /**
     * Función para traducir el texto utilizando la API de Google Cloud Translation.
     * Requiere una clave de API válida de Google Cloud Translation para funcionar correctamente.
     * @param string $texto El texto que se desea traducir.
     * @param string $idioma_destino El idioma al que se desea traducir el texto.
     * @return string El texto traducido o un mensaje de error si la traducción falla.
     */
    function traducirTexto($texto, $idioma_destino) {
        // Aquí debes reemplazar 'TU_API_KEY' con tu propia clave de API de Google Cloud Translation
        $api_key = 'AIzaSyBshvytk6EsJL91mCYa9KyCjrdPKUeLWEk';
        // URL de la API de Google Cloud Translation
        $url = 'https://translation.googleapis.com/language/translate/v2?key=' . $api_key;
        // Datos para enviar a la API
        $data = array(
            'q' => $texto,
            'target' => $idioma_destino
        );
        // Configuración de la solicitud HTTP
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        // Crear contexto de flujo
        $context = stream_context_create($options);
        // Realizar la solicitud a la API y obtener la respuesta
        $result = file_get_contents($url, false, $context);
    
        // Verificar si se recibió una respuesta válida
        if ($result === FALSE)
            return 'Error al traducir el texto';
        else {
            // Decodificar la respuesta JSON
            $json_response = json_decode($result, true);
            // Extraer y devolver el texto traducido
            return $json_response['data']['translations'][0]['translatedText'];
        }
    }
?>