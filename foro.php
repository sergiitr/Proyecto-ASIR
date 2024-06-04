<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="styles.css"/>
        <title>Proyecto</title>
        <link rel="shortcut icon" href="./imagenes/logo.jpeg"/>
        <script src="script.js"></script>
        <style>
            @media screen and (max-width:1024px) {
                .filtro-lateral {
                    position: fixed;
                    top: 50%;
                    right: -100%; /* Inicialmente oculto */
                    width: 10%;
                    transform: translateY(-50%);
                    background-color: #f8f9fa;
                    padding: 10px;
                    border: 1px solid #ced4da;
                    border-radius: 5px;
                    transition: right 0.5s; /* Animación de transición */
                    background-color:black;
                }
                .filtro-lateral h4 {
                    margin-top: 0;
                }
                .filtro-lateral.expandir {
                    right: -40%; /* Mostrar completamente */
                    background-color:black;
                }
                .mostrar-filtro {
                    position: fixed;
                    top: 40%;
                    right: -83%;
                    transform: translateY(-50%);
                    background-color: #f8f9fa;
                    border: 1px solid #ced4da;
                    border-radius: 5px 0 0 5px;
                    padding: 5px;
                    cursor: pointer;
                    z-index: 9999;
                }
                .mostrar-filtro span {
                    display: block;
                    width: 30px;
                    height: 30px;
                    background-color: #fff;
                    border: 1px solid #ced4da;
                    text-align: center;
                    line-height: 30px;
                }
            }
            @media screen and (min-width:1024px) {
                .filtro-lateral {
                    position: fixed;
                    top: 50%;
                    right: -100%; /* Inicialmente oculto */
                    width: 10%;
                    transform: translateY(-50%);
                    background-color: #f8f9fa;
                    padding: 10px;
                    border: 1px solid #ced4da;
                    border-radius: 5px;
                    transition: right 0.5s; /* Animación de transición */
                    background-color:black;
                }
                .filtro-lateral h4 {
                    margin-top: 0;
                }
                .filtro-lateral.expandir {
                    right: -80%; /* Mostrar completamente */
                }
                .mostrar-filtro {
                    position: fixed;
                    top: 40%;
                    right: -97%;
                    transform: translateY(-50%);
                    background-color: #f8f9fa;
                    border: 1px solid #ced4da;
                    border-radius: 5px 0 0 5px;
                    padding: 5px;
                    cursor: pointer;
                    z-index: 9999;
                }
                .mostrar-filtro span {
                    display: block;
                    width: 30px;
                    height: 30px;
                    background-color: #fff;
                    border: 1px solid #ced4da;
                    text-align: center;
                    line-height: 30px;
                }
            }
        </style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="text-center mt-3 botones-idiomas">
            <!-- Botones para cambiar de idioma -->
            <button type="button" class="btn btn-primary" onclick="cambiarIdioma('es')"><img src="./imagenes/espana.png" alt="Español" style="width: 30px; height: auto;"></button>
            <button type="button" class="btn btn-primary" onclick="cambiarIdioma('en')"><img src="./imagenes/inglaterra.png" alt="Inglés" style="width: 30px; height: auto;"></button>
        </div>
        <div class="container">
            <div class="row">
                <!-- Botón para mostrar/ocultar filtro -->
                <div class="mostrar-filtro" onclick="toggleFiltro()">
                    <span>&#187;</span>
                </div>
                <!-- Filtro lateral -->
                <div class="filtro-lateral" id="filtro-lateral">
                    <p>Filtrar por Fecha</p>
                    <form method="post" action="">
                        <select name="filtro_fecha" class="form-select">
                            <?php
                                // Generar opciones para el filtro de fecha
                                $anio_actual = date("Y");
                                $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
                                for ($i = $anio_actual; $i >= 2024; $i--) {
                                    echo "<optgroup label='$i'>";
                                    foreach ($meses as $mes) {
                                        // Convertir el mes a formato MM
                                        $mes_numerico = sprintf("%02d", array_search($mes, $meses) + 1);
                                        $fecha = $i . $mes_numerico;
                                        echo "<option value='$fecha'>$mes</option>";
                                    }
                                    echo "</optgroup>";
                                }
                            ?>
                        </select>
                        <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
                    </form>
                </div>
                <!-- Fin del filtro lateral -->
                <div class="col-md-11">
                    <h1 class="snos1">FORO</h1>
                    <div class="posts">
                        <?php
                            require_once "./login.php";
                            $conexion = mysqli_connect($host, $user, $pass, $database);
                            // Comprobar conexión
                            if (!$conexion)
                                die("Conexión fallida: " . mysqli_connect_error());
                            
                            // Procesamiento del filtro de fecha
                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["filtro_fecha"])) {
                                $fecha_filtro = $_POST["filtro_fecha"];
                                // Convertir la fecha de entrada al formato YYYYMM (año-mes)
                                $sql = "SELECT id_foro, titulo, usuario, descripcion, fecha FROM foro WHERE LEFT(fecha, 6) = ?";
                                $stmt = mysqli_prepare($conexion, $sql);
                                mysqli_stmt_bind_param($stmt, "s", $fecha_filtro);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                            } else {
                                // Consulta original sin filtro de fecha
                                $sql = "SELECT id_foro, titulo, usuario, descripcion, fecha FROM foro";
                                $result = mysqli_query($conexion, $sql);
                            }
    
                            // Comprobar si la consulta se realizó correctamente
                            if ($result) {
                                if (mysqli_num_rows($result) > 0) {
                                    // Mostrar posts
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $fecha_formateada = date("d/m/Y", strtotime($row['fecha']));
                                        echo '<div class="post mt-5" >
                                                <div id="pregunta">
                                                    <h2>' . $row['titulo'] . '</h2>
                                                    <p>' . $row['descripcion'] . '</p>
                                                    <p>' . $row['usuario'] . ' - ' . $fecha_formateada . '</p>
                                                </div>';
                                        // Consulta para obtener respuestas asociadas a este post
                                        $id_foro = $row['id_foro'];
                                        $sql_respuestas = "SELECT idUsuario, respuesta FROM respuestas WHERE id_foro = $id_foro";
                                        $result_respuestas = mysqli_query($conexion, $sql_respuestas);
    
                                        // Mostrar respuestas
                                        echo '<h2 id="foro">Respuestas Usuarios</h2>';
                                        if ($result_respuestas && mysqli_num_rows($result_respuestas) > 0) {
                                            echo '<div class="respuestas" id="foro">';
                                            while ($respuesta = mysqli_fetch_assoc($result_respuestas)) {
                                                echo '<div class="respuesta">
                                                        <p>Usuario: ' . $respuesta['idUsuario'] . '</p>
                                                        <p>' . $respuesta['respuesta'] . '</p>
                                                    </div>';
                                            }
                                            echo '</div>';
                                            mysqli_free_result($result_respuestas);
                                        } else
                                            echo "<p>No hay respuestas todavía.</p>";
                                        echo '<form method="post" action="responder.php">
                                                <input type="hidden" name="id_foro" value="' . $row['id_foro'] . '">
                                                <textarea name="respuesta" rows="4" ></textarea><br>
                                                <input type="submit" value="Responder">
                                            </form>
                                            </div>'; // Cierre de la etiqueta <div class="post">
                                    }
                                    $footerClass = 'relative';
                                } else {
                                    echo "<p>No hay posts todavía.</p>";
                                    $footerClass = 'absolute';
                                }
                                mysqli_free_result($result);
                            } else 
                                echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
                            // Cerrar conexión
                            mysqli_close($conexion);
                        ?>
                    </div>
                    <button onclick="pregunta()" id="pregunta-button">Agregar nueva pregunta</button>
                    <iframe src="./nuevaPregunta.php" id="pregunta" frameborder="1" width="100%" hidden></iframe>
                </div>
            </div>
        </div>
        <footer class="<?php echo $footerClass; ?>">
            <?php include 'footer.php'; ?>
        </footer>
        
        <script src="cambioFooter.js"></script>
        
        <script>
            function toggleFiltro() {
                var filtroLateral = document.getElementById("filtro-lateral");
                filtroLateral.classList.toggle("expandir");
            }
        </script>
        
        <script>
            function pregunta() {
                var preguntaFrame = document.getElementById("pregunta");
                var preguntaButton = document.getElementById("pregunta-button");
                if (preguntaFrame.hidden)
                    preguntaFrame.hidden = false;
                else
                    preguntaFrame.hidden = true;
            }
            // Función para cambiar el idioma del texto en el modal
            function cambiarIdioma(idioma) {
                var foros = document.querySelectorAll('[id^="foro"]');
                foros.forEach(function(foro) {
                    // Obtener el texto a traducir
                    var texto_a_traducir = foro.innerHTML.trim();
                    // Llamar a traducir_texto.php mediante una solicitud POST
                    fetch('traducir_texto.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'idioma=' + idioma + '&texto=' + encodeURIComponent(texto_a_traducir)
                    })
                    .then(response => response.text())
                    .then(data => foro.innerHTML = data)
                    .catch(error => console.error('Error:', error));
                });

                var preguntas = document.querySelectorAll('[id^="pregunta"]');
                preguntas.forEach(function(pregunta) {
                    // Obtener el texto a traducir
                    var texto_a_traducir = pregunta.innerHTML.trim();
                    // Llamar a traducir_texto.php mediante una solicitud POST
                    fetch('traducir_texto.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'idioma=' + idioma + '&texto=' + encodeURIComponent(texto_a_traducir)
                    })
                    .then(response => response.text())
                    .then(data => pregunta.innerHTML = data)
                    .catch(error => console.error('Error:', error));
                });
            }
        </script>
    </body>
</html>