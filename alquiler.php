<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>Proyecto</title>
        <link rel="shortcut icon" href="./imagenes/logo.jpeg"/>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link rel="stylesheet" href="styles.css">
        <script src="script.js"></script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <?php 
            if (!isset($_SESSION["usuario"]) || $_SESSION["usuario"] == "admin") {
                header('Location: index.php');
                exit;
            }
        ?>
        <div class="item container mt-4">
            <div class="row">
                <h1>Carrito de Alquiler</h1>
                <h3>Solo se podra alquilar un juego en cada compra</h3>
                <?php
                    $hoy = date("Y-m-d");
                    $nueva_fecha = strtotime('+15 days', strtotime($hoy));
                    $nueva_fechaStr = date("Y-m-d", $nueva_fecha);
                    if (!isset($_SESSION['alquiler']))
                        $_SESSION['alquiler'] = [];
                    $id_Usuario = isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : "UsuarioDesconocido";
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['iddelJuego'], $_POST['plataforma'])) {
                        require_once "./login.php";
                        $conexion = mysqli_connect($host, $user, $pass, $database);
                        if (!$conexion)
                            die("Error de conexión a la base de datos: " . mysqli_connect_error());
                        $nombreJuego = mysqli_real_escape_string($conexion, $_POST['id']);
                        $query = "SELECT precio FROM juegos WHERE nombre = '$nombreJuego'";
                        $resultadoAlq = mysqli_query($conexion, $query);
                        if ($resultadoAlq && $filaAlq = mysqli_fetch_assoc($resultadoAlq)) {
                            $precio = $filaAlq['precio'];
                            mysqli_free_result($resultadoAlq);
                        } else
                            die("Error en la consulta: " . mysqli_error($conexion));
                        mysqli_close($conexion);
                        $_SESSION['alquiler'][] = array($_POST['iddelJuego'], $nombreJuego, $_POST['plataforma'], $precio, $hoy, $nueva_fechaStr);
                    }

                    if (count($_SESSION['alquiler']) > 0) {
                        $ultimaLinea = end($_SESSION['alquiler']);
                        $idJuegoUltimo = $ultimaLinea[0];
                        echo '  <table class="table table-dark table-striped">
                                    <tr align=center>
                                        <th>idProd</th>
                                        <th>Producto</th>
                                        <th>Plataforma</th>
                                        <th>Fecha inicio</th>
                                        <th>Fecha entrega</th>
                                    </tr>
                                    <tr align=center>
                                        <td>' . htmlspecialchars($idJuegoUltimo) . ' </td>
                                        <td>' . htmlspecialchars($ultimaLinea[1]) . '</td>
                                        <td>' . htmlspecialchars($ultimaLinea[2]) . '</td>
                                        <td>' . htmlspecialchars($hoy) . '</td>
                                        <td>' . htmlspecialchars($nueva_fechaStr) . '</td>
                                    </tr>
                                </table>
                                <form method="post" action="procesoAlquiler.php" onsubmit="return validarFecha()">
                                    <input type="hidden" name="idJuego" value="' . $idJuegoUltimo . '">
                                    <input type="hidden" name="idUsuario" value="' . $id_Usuario . '">
                                    <input type="hidden" name="f_inicio" value="' . $hoy . '">
                                    <input type="hidden" name="f_fin" value="' . $nueva_fechaStr . '">
                                    <div class="visa-card">
                                        <div class="logoContainer">
                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="23" height="23" viewBox="0 0 48 48" class="svgLogo" >
                                                <path fill="#ff9800" d="M32 10A14 14 0 1 0 32 38A14 14 0 1 0 32 10Z"></path>
                                                <path fill="#d50000" d="M16 10A14 14 0 1 0 16 38A14 14 0 1 0 16 10Z"></path>
                                                <path fill="#ff3d00" d="M18,24c0,4.755,2.376,8.95,6,11.48c3.624-2.53,6-6.725,6-11.48s-2.376-8.95-6-11.48 C20.376,15.05,18,19.245,18,24z"></path>
                                            </svg>
                                        </div>
                                        <div class="number-container">
                                            <label class="input-label" for="cardNumber">CARD NUMBER</label>
                                            <input class="inputstyle" id="cardNumber" placeholder="XXXX XXXX XXXX XXXX" name="cardNumber" type="text" required />
                                        </div>
                                    
                                        <div class="name-date-cvv-container">
                                            <div class="name-wrapper">
                                                <label class="input-label" for="holderName">CARD HOLDER</label>
                                                <input class="inputstyle" id="holderName" placeholder="NAME" type="text" required/>
                                            </div>
                                        
                                            <div class="expiry-wrapper">
                                                <label class="input-label" for="expiry">VALID THRU</label>
                                                <input class="inputstyle" id="expiry" placeholder="MM/YY" type="text" required/>
                                            </div>
                                            <div class="cvv-wrapper">
                                                <label class="input-label" for="cvv">CVV</label>
                                                <input class="inputstyle" placeholder="***" maxlength="3" id="cvv" type="password" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-primary" value="Realizar Alquiler">
                                </form>
                                <form class=vaciarcarrito method="post" action="vaciarcarritoAlquiler.php">
                                    <input type="submit" class="btn btn-danger" value="Vaciar Carrito">
                                </form>';
                    } else
                        echo '<p>El carrito de alquiler está vacío.</p>';
                ?>
                <script>
                    function validarFecha() {
                        var inputFecha = document.getElementById('expiry').value;
                        // Verificar que la entrada tenga el formato MM/YY usando una expresión regular
                        var formatoValido = /^\d{2}\/\d{2}$/;
                        if (!formatoValido.test(inputFecha)) {
                            alert('Por favor, introduce la fecha en formato MM/YY.');
                            return false;
                        }

                        // Obtener el mes y el año del input
                        var partesFecha = inputFecha.split('/');
                        var mes = parseInt(partesFecha[0], 10); // Convertir a número base 10
                        var año = parseInt(partesFecha[1], 10);
                        // Obtener el mes y el año actuales
                        var fechaActual = new Date();
                        var mesActual = fechaActual.getMonth() + 1; // getMonth() devuelve valores de 0 a 11, por lo que se agrega 1
                        var añoActual = fechaActual.getFullYear() % 100; // Solo obtener los dos últimos dígitos del año
                        // Validar que el año sea igual o mayor al actual, y que el mes esté en el rango válido
                        if (año < añoActual || (año === añoActual && mes < mesActual)){
                            alert('La fecha de la tarjeta no es válida. Debe ser igual o superior al mes y año actuales.');
                            return false;
                        }
                        return true;
                    }
                </script>
            </div>
        </div>
        <?php $footerClass = 'absolute'; ?>
            <footer class="<?php echo $footerClass; ?>">
            <?php include 'footer.php'; ?>
        </div>
        </footer>
        <script src="cambioFooter.js"></script>
    </body>
</html>