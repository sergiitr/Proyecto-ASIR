<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="styles.css"/>
        <title>Proyecto</title>
        <link rel="shortcut icon" href="./imagenes/logo.jpeg"/>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="container">
            <h1>Foro</h1>
            <div class="posts">
                <?php
                    require_once "./login.php";
                    $conexion = mysqli_connect($host, $user, $pass, $database);

                    // Comprobar conexión
                    if (!$conexion)
                        die("Conexión fallida: " . mysqli_connect_error());

                    // Consulta para obtener posts
                    $sql = "SELECT id_foro, titulo, usuario, descripcion, fecha FROM foro";
                    $result = mysqli_query($conexion, $sql);

                    // Comprobar si la consulta se realizó correctamente
                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            // Mostrar posts
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="post">
                                        <h2>' . $row['titulo'] . '</h2>
                                        <p>' . $row['descripcion'] . '</p>
                                        <small>' . $row['usuario'] . ' - ' . $row['fecha'] . '</small>';

                                // Consulta para obtener respuestas asociadas a este post
                                $id_foro = $row['id_foro'];
                                $sql_respuestas = "SELECT idUsuario, respuesta FROM respuestas WHERE id_foro = $id_foro";
                                $result_respuestas = mysqli_query($conexion, $sql_respuestas);

                                // Mostrar respuestas
                                echo '<h4>Respuestas Usuarios</h4>';
                                if ($result_respuestas && mysqli_num_rows($result_respuestas) > 0) {
                                    echo '<div class="respuestas">';
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
                                        <textarea name="respuesta" rows="4" cols="50"></textarea><br>
                                        <input type="submit" value="Responder">
                                    </form>
                                    </div>'; // Cierre de la etiqueta <div class="post">
                            }
                        } else
                            echo "<p>No hay posts todavía.</p>";

                        mysqli_free_result($result);
                    } else 
                        echo "Error al ejecutar la consulta: " . mysqli_error($conexion);

                    // Cerrar conexión
                    mysqli_close($conexion);
                ?>
            </div>
            <br><br>
            <button onclick="pregunta()" id="pregunta-button">Agregar nueva pregunta</button>
            <iframe src="./nuevaPregunta.php" id="pregunta" frameborder="1" width="100%" hidden></iframe>
            <script>
                function pregunta() {
                    var preguntaFrame = document.getElementById("pregunta");
                    var preguntaButton = document.getElementById("pregunta-button");

                    if (preguntaFrame.hidden)
                        preguntaFrame.hidden = false;
                    else
                        preguntaFrame.hidden = true;
                }
            </script>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>

