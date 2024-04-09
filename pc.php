<?php session_start(); ?>
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
                    $sqlCrearFuncion = " DROP FUNCTION IF EXISTS ContarVideojuegosPorPlataforma; ";
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
                        $queryFuncion = "SELECT ContarVideojuegosPorPlataforma('pc') AS totalJuegos";
                        $resultadoFuncion = mysqli_query($conexion, $queryFuncion);
                    
                        // Verifica si la consulta fue exitosa
                        if ($resultadoFuncion) {
                            $filaFuncion = mysqli_fetch_assoc($resultadoFuncion);
                            $totalJuegosPlataforma = $filaFuncion['totalJuegos'];
                            echo "<h3 class='letrasCantJuegos'>Hay $totalJuegosPlataforma juegos de pc</h3>";
                        } else
                            echo "Error al llamar a la función: " . mysqli_error($conexion);
                    }
                    
                    // Configuración para la paginación
                    $resultadosPorPagina = 6;
                    $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                    $inicioConsulta = ($paginaActual - 1) * $resultadosPorPagina;

                    // Consulta SQL con limitación para la paginación
                    $consulta = "SELECT idJuego, nombre, stock, imagen, precio, plataforma FROM juegos WHERE plataforma='pc' LIMIT $inicioConsulta, $resultadosPorPagina";
                    $resultado = mysqli_query($conexion, $consulta);

                    // Consulta SQL para obtener el número total de juegos
                    $consultaTotal = "SELECT COUNT(*) AS total FROM juegos WHERE plataforma='pc'";
                    $resultadoTotal = mysqli_query($conexion, $consultaTotal);

                    // Verificar si la consulta fue exitosa
                    if ($resultadoTotal) {
                        $filaTotal = mysqli_fetch_assoc($resultadoTotal);
                        $totalJuegos = $filaTotal['total'];
                        // Calcular el número total de páginas
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
                        echo '  
                                <div class="card2">
                                    <a href="trailer.php?juego=' . urlencode($nombre) . '" class="card-link">
                                    <div class="card" id="' . htmlspecialchars($id) . '">
                                        <h2>', $nombre, '</h2>
                                        <img src="data:image/jpg; base64,', base64_encode($imagen), '" height="70%" width="50%">
                                    </div>
                                    </a>';

                        if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true  && $_SESSION["administrador"] != 1) {
                            echo '<div class="card3">
                                    <form action="carrito.php" method="post">
                                        <input type="hidden" name="iddelJuego" value="',$idJuego,'">
                                        <input type="hidden" name="plataforma" value="pc">
                                        <input type="hidden" name="precio" value="',$precio,'">
                                        Cantidad: <input name="cantidad" type="number" min="0" max="100" step="1" required/>
                                        <input name="id" type="hidden" value="', $nombre, '"/>
                                        <button class="CartBtn">
                                            <span class="IconContainer"> 
                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512" fill="rgb(17, 17, 17)" class="cart"><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path></svg>
                                            </span>
                                            <p class="text">Añadir al <br>carrito</p>
                                        </button>
                                    </form>
                                    <form action="alquiler.php" method="post">
                                        <input type="hidden" name="iddelJuego" value="',$idJuego,'">
                                        <input type="hidden" name="plataforma" value="pc">
                                        <input type="hidden" name="precio" value="',$precio,'">
                                        <input name="id" type="hidden" value="', $nombre, '"/>
                                        <button class="CartBtn">
                                            <span class="IconContainer"> 
                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512" fill="rgb(17, 17, 17)" class="cart"><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path></svg>
                                            </span>
                                            <p class="text">Alquilar</p>
                                        </button>
                                    </form>
                                </div>';
                        } elseif (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true && $_SESSION["administrador"] == 1) {
                            // Mostrar mensaje o botones inactivos para el administrador
                            echo '<div class="card3">
                                    <p>Botones inactivos para admin</p>
                                </div>';
                        }
                        echo'    </div>';
                        echo '<style>
                                #' . htmlspecialchars($id) . ':hover:after {
                                    content: "Stock: ' . $stock . ' \A Precio: ' . $precio . '";
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