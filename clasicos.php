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
        <script src="script.js"></script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="item container-fluid mt-4">
            <div class="row">
                <?php require_once "login.php";
                    $conexion=mysqli_connect($host,$user,$pass,$database);
                    mysqli_select_db($conexion,$database);
                    if (!$conexion)
                        die("Error de conexión: " . mysqli_connect_error());
                    
                    // Crear la función si no existe
                    $sqlCrearFuncion = "
                        DROP FUNCTION IF EXISTS ContarVideojuegosPorPlataforma;
                    ";
                    if (!mysqli_query($conexion, $sqlCrearFuncion))
                        echo "Error al eliminar la función si existe: " . mysqli_error($conexion);
                    
                    $sqlCrearFuncion = "
                        CREATE FUNCTION ContarVideojuegosPorPlataforma(plataformaJuego VARCHAR(50)) 
                        RETURNS INT
                        DETERMINISTIC
                        BEGIN
                            DECLARE totalJuegos INT;
                            SELECT COUNT(*) INTO totalJuegos FROM juegos WHERE plataforma = plataformaJuego;
                            RETURN totalJuegos;
                        END;
                    ";
                    if (!mysqli_query($conexion, $sqlCrearFuncion))
                        echo "Error al crear la función: " . mysqli_error($conexion);
                    else {
                        // Llamada a la función almacenada
                        $queryFuncion = "SELECT ContarVideojuegosPorPlataforma('clasicos') AS totalJuegos";
                        $resultadoFuncion = mysqli_query($conexion, $queryFuncion);
                    
                        // Verifica si la consulta fue exitosa
                        if ($resultadoFuncion) {
                            $filaFuncion = mysqli_fetch_assoc($resultadoFuncion);
                            $totalJuegosPlataforma = $filaFuncion['totalJuegos'];
                            echo "<h3 class='letrasCantJuegos'>Juega a alguno de nuestros $totalJuegosPlataforma juegos clasicos</h3>";
                        } else
                            echo "Error al llamar a la función: " . mysqli_error($conexion);
                    }
                    // Configuración para la paginación
                    $resultadosPorPagina = 6;
                    $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                    $inicioConsulta = ($paginaActual - 1) * $resultadosPorPagina;

                    // Consulta SQL con limitación para la paginación
                    $consulta = "SELECT idJuego, nombre, stock, imagen, precio, plataforma,trailer FROM juegos WHERE plataforma='clasicos' LIMIT $inicioConsulta, $resultadosPorPagina";
                    $resultado = mysqli_query($conexion, $consulta);

                    // Consulta SQL para obtener el número total de juegos
                    $consultaTotal = "SELECT COUNT(*) AS total FROM juegos WHERE plataforma='clasicos'";
                    $resultadoTotal = mysqli_query($conexion, $consultaTotal);

                    // Verificar si la consulta fue exitosa
                    if ($resultadoTotal) {
                        $filaTotal = mysqli_fetch_assoc($resultadoTotal);
                        $totalJuegos = $filaTotal['total'];
                        $totalPaginas = ceil($totalJuegos / $resultadosPorPagina);
                    } else
                        echo "Error al obtener el número total de juegos: " . mysqli_error($conexion);
                    // Código para mostrar los juegos obtenidos
                    $contador = 1;
                    while ($valores = mysqli_fetch_assoc($resultado)) {
                        $nombre = $valores['nombre'];
                        $stock = $valores['stock'];
                        $precio = $valores['precio'];
                        $plataforma = $valores['plataforma'];
                        $id = 'card' . $contador;
                        $imagen = $valores['imagen'];
                        $idJuego = $valores['idJuego'];
                        $trailer = $valores['trailer'];
                        echo '  <div class="card2">
                                    <a href="' . $trailer . '" class="card-link">
                                    <div class="card" id="' . htmlspecialchars($id) . '">
                                        <h2>', $nombre, '</h2>
                                        <img src="data:image/jpg; base64,', base64_encode($imagen), '" height="70%" width="50%">
                                    </div>
                                    </a>
                                </div>
                                <style>
                                    #' . htmlspecialchars($id) . ':hover:after {
                                        content: "Pulsa para jugar al juego";
                                        white-space: pre-wrap;
                                    }
                                </style>';
                        $contador++;
                    }

                    // Botones de navegación entre páginas
                    echo '<div class="pagination">';
                    for ($i = 1; $i <= $totalPaginas; $i++)
                        echo '<a href="?pagina=' . $i . '"><button id="btnPagina' . $i . '" class="paginas">' . $i . '</button></a>';
                    echo '</div>';
                ?>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>