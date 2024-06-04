<?php
    $mostrar_popup = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>Proyecto</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="shortcut icon" href="./imagenes/logo.jpeg"/>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        
        
        <style>
            body.dark-mode {
                background-color: #333;
                color: #fff;
            }
            .popup {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: black;
                padding: 20px;
                border: 1px solid #ccc;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                z-index: 9999;
            }
        </style>
    </head>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($mostrar_popup): ?>
                // Mostrar el pop-up si el usuario ha iniciado sesión
                document.getElementById("popup").style.display = "block";
            <?php endif; ?>
        });

        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }
    </script>
    <body>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="script.js"></script>
        <?php include 'header.php'; ?>
        <div class="container mt-4">
            <div id="popup" class="popup">
                <h2>Suscripción al Boletín de Noticias</h2>
                <form action="subcripcion.php" method="post">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" required>
                    <button type="submit">Suscribirse</button>
                </form>
                <button onclick="closePopup()">Cerrar</button>
            </div>
            
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">¡Leeme!</button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-primary" id="exampleModalLabel">Aviso sobre la Naturaleza del Proyecto:</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modal-body">
                            <!-- Aquí se mostrará el texto traducido -->
                            <p class="texto-idioma">
                                <?php
                                    // Texto original en español
                                    $texto_es = "Este proyecto de Final de Grado Superior tiene como objetivo exclusivamente educativo. Los datos introducidos y cualquier interacción realizada dentro del sistema no tienen efectos prácticos y se utilizan únicamente con fines educativos.
                                        <br>
                                        Es importante destacar que no se utilizarán los datos con fines comerciales ni serán compartidos con terceros en ningún caso. Además, en línea con las regulaciones de privacidad, no se almacenarán los datos de tarjetas de crédito ni se requerirá su introducción real en ningún momento.
                                        <br>
                                        Agradecemos su comprensión y colaboración en la utilización responsable de este proyecto con fines educativos.";
                                    // Texto original en inglés
                                    $texto_en = "This Senior High School Final Project is exclusively educational. The data entered and any interactions made within the system have no practical effects and are used solely for educational purposes.
                                        <br>
                                        It is important to note that the data will not be used for commercial purposes or shared with third parties under any circumstances. Furthermore, in line with privacy regulations, credit card data will not be stored or required for actual entry at any time.
                                        <br>
                                        We appreciate your understanding and cooperation in the responsible use of this project for educational purposes.";
                                    // Determinar el idioma destino
                                    $idioma_destino = isset($_GET['idioma']) ? $_GET['idioma'] : 'es';
                                    // Traducir el texto al idioma destino
                                    if ($idioma_destino == 'en')
                                        echo $texto_en;
                                    else
                                        echo $texto_es;
                                ?>
                            </p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        <div class="text-center mt-3 botones-idiomas">
                            <!-- Botones para cambiar de idioma -->
                            <button type="button" class="btn btn-primary" onclick="cambiarIdioma('es')">Español</button>
                            <button type="button" class="btn btn-primary" onclick="cambiarIdioma('en')">Inglés</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Scripts -->
        <script>
            // Función para cambiar el idioma del texto en el modal
            function cambiarIdioma(idioma) {
                var modalBody = document.getElementById("modal-body");
                // Obtener el texto a traducir
                var texto_a_traducir = modalBody.innerHTML.trim();
                // Llamar a traducir_texto.php mediante una solicitud POST
                fetch('traducir_texto.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'idioma=' + idioma + '&texto=' + encodeURIComponent(texto_a_traducir)
                })
                .then(response => response.text())
                .then(data => modalBody.innerHTML = data)
                .catch(error => console.error('Error:', error));
            }
        </script>
        <div class="container">
            <div class="mt-4">
                <h1 class="textInicio">Tu tienda de videojuegos en &Uacute;beda</h1>
                <h2 class="textInicio2">En nuestra tienda tenemos los siguientes catalogos:</h2>
            </div>
            <div id="carouselExampleDark" class="carousel carousel-dark slide h-10 mt-4" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="4" aria-label="Slide 5"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="10000">
                        <img src="./imagenes/ps5.png" class="d-block w-100" class="imagenesConsolas">
                        <div class="carousel-caption d-block">
                            <h3 class="catalogos"><a class="catalogos" href="./ps5.php">Juegos PS5</a></h3>
                        </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                        <img src="./imagenes/xbox.png" class="d-block w-100" class="imagenesConsolas">
                        <div class="carousel-caption d-block">
                            <h3 class="catalogos"><a class="catalogos" href="./xbox.php">Juegos XBOX One</a></h3>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="./imagenes/switch.png" class="d-block w-100" class="imagenesConsolas">
                        <div class="carousel-caption d-block">
                            <h3 class="catalogos"><a class="catalogos" href="./switch.php">Juegos Nintendo Switch</a></h3>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="./imagenes/pc.png" class="d-block w-100" class="imagenesConsolas">
                        <div class="carousel-caption d-block">
                            <h3 class="catalogos"><a class="catalogos" href="./pc.php">Juegos PC</a></h3>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="./imagenes/pc.png" class="d-block w-100" class="imagenesConsolas">
                        <div class="carousel-caption d-block">
                            <h3 class="catalogos"><a class="catalogos" href="./clasicos.php">Juegos Clasicos</a></h3>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
            <button onclick="chat()" id="chat-button" class="mt-4">.</button>
            <iframe src="./chat.php" id="chat" frameborder="1" width="100%" hidden></iframe>
            
            <script>
                function chat() {
                    var chatFrame = document.getElementById("chat");
                    var chatButton = document.getElementById("chat-button");
                    if (chatFrame.hidden) 
                        chatFrame.hidden = false;
                    else
                        chatFrame.hidden = true;
                }
            </script>
        </div>
        <?php include 'verClientes.php'; ?>
        <?php include 'footer.php'; ?>
    </body>
</html>

<?php
    function traducirTexto($texto, $idioma_destino) {
        // Aquí llamarías a la API de Google Cloud Translation AI para traducir el texto
        $api_key = 'AIzaSyBshvytk6EsJL91mCYa9KyCjrdPKUeLWEk';
        $url = 'https://translation.googleapis.com/language/translate/v2?key=' . $api_key;
        $data = array(
            'q' => $texto,
            'target' => $idioma_destino
        );
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            return 'Error al traducir el texto';
        } else {
            $json_response = json_decode($result, true);
            return $json_response['data']['translations'][0]['translatedText'];
        }
    }
?>