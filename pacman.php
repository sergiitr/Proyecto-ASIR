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
            /* Reglas de estilo para hacer que el SVG sea receptivo */
            #svg {
                max-width: 100%;
                height: auto;
                display: flex;
                margin: 0 auto; /* Para centrar el SVG horizontalmente */
            }
    
            /* Estilo para dispositivos m贸viles en posici贸n vertical */
            @media only screen and (max-width: 600px) {
                /* Ocultar el contenedor del juego y mostrar el mensaje */
                .juegoContainer {
                    display: none;
                }
                #mensajeGirar {
                    display: block;
                    text-align: center;
                }
            }
            @media only screen and (min-width: 600px) {
                #mensajeGirar {
                    display: none;
                }
            }
        </style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <?php
            require_once "login.php";
            $conexion=mysqli_connect($host,$user,$pass,$database);
            mysqli_select_db($conexion,$database);

            if (!$conexion) {
                die("La conexión a la base de datos falló: " . mysqli_connect_error());
            }

            $idUsuario = $_SESSION['usuario'];

            $consulta = "SELECT COUNT(*) AS total_pedidos FROM compran WHERE idUsuario = '$idUsuario'";
            $resultado = mysqli_query($conexion, $consulta);
            $fila = mysqli_fetch_assoc($resultado);
            $total_pedidos = $fila['total_pedidos'];

            mysqli_close($conexion);
        ?>
        <div id="mensajeGirar">
            Por favor, gira tu dispositivo para jugar en posición horizontal.
        </div>
        <div class="item-fluid container mt-4">
            <?php if($total_pedidos >= 3 || $_SESSION['administrador']==1): ?>
                <h1>Pac-Man</h1>
                <div id="game-container" class="juegoContainer">
                    <?php
                        for ($i = 0; $i < 20; $i++) {
                            echo "<div id='row'>";
                            for ($j = 0; $j < 20; $j++) {
                                if ($i == 0 || $i == 19 || $j == 0 || $j == 19) {
                                    echo "<div class='wall'></div>";
                                } else {
                                    echo "<div class='empty'></div>";
                                }
                            }
                            echo "</div>";
                        }
                    ?>
                    <div id="pacman"></div>
                    <div class="monster" id="monster1"></div>
                    <div id="cheese"></div>
                    <div id="game-over" style="display: none;">
                        <h2>Game Over</h2>
                        <button onclick="restartGame()">Restart</button>
                    </div>
                </div>
                <script src="pacman.js"></script>
                <script>
                    function restartGame() {
                        location.reload(); // Recargar la página para reiniciar el juego
                    }
                </script>
            <?php else: ?>
                <p>No has realizado suficientes compras para acceder al juego.</p>
            <?php endif; ?>
        </div>
        
        <?php if(isset($_SESSION['usuario'])): ?>
            <div class="footer-container">
                <?php include 'footer.php'; ?>
            </div>
        <?php else: ?>
            <div class="abajo">
                <?php include 'footer.php'; ?>
            </div>
        <?php endif; ?>
        
        <script>
            // Almacena el ancho de la pantalla en la variable de sesión 'resolution'
            <?php $_SESSION['resolution'] = '<script>document.write(window.innerWidth);</script>'; ?>
        </script>
    </body>
</html>
