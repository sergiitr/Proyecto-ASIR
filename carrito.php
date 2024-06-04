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
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="script.js"></script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <?php 
            if (!isset($_SESSION["usuario"]) || $_SESSION["administrador"] == 1) {
                header('Location: index.php');
                exit;
            }
        ?>
        <div class="item container mt-4">
            <div class="row">
                <h1>Carrito de Compras</h1>
                <?php
                    // Verificar si hay un mensaje para mostrar
                    if(isset($_SESSION['mensaje'])) {
                        echo "<p>{$_SESSION['mensaje']}</p>";
                        unset($_SESSION['mensaje']); // Limpiar el mensaje de la sesión
                    }
                    $footerClass = 'absolute';
                    require_once "./login.php";
                    $conexion = mysqli_connect($host, $user, $pass, $database);
                    if (!$conexion)
                        die("Error de conexión a la base de datos: " . mysqli_connect_error());
                    // Agregar producto al carrito
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['iddelJuego']))
                        agregarProductoAlCarrito($conexion);
                    // Calcular descuento por fidelidad
                    $descuento = calcularDescuentoPorFidelidad($conexion);
                    // Mostrar carrito
                    mostrarCarrito($conexion, $descuento);
                    // Cerrar conexión
                    mysqli_close($conexion);
                    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                        $footerClass = 'sticky'; // Si hay elementos en el carrito, el footer se posiciona como 'sticky'
                    }
                    /**
                     * Función para agregar producto al carrito
                     */
                    function agregarProductoAlCarrito($conexion) {
                        if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
                            $idJuego = mysqli_real_escape_string($conexion, $_POST['iddelJuego']);
                            $cantidadSolicitada = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 0;
                            $plataforma = mysqli_real_escape_string($conexion, $_POST['plataforma']);
                    
                            $query = "SELECT idJuego, nombre, precio, stock FROM juegos WHERE idJuego = '$idJuego'";
                            $resultado = mysqli_query($conexion, $query);
                    
                            if ($fila = mysqli_fetch_assoc($resultado)) {
                                $cantidadEnCarrito = isset($_SESSION['carrito'][$idJuego]) ? $_SESSION['carrito'][$idJuego][2] : 0; // Cambiado a [1] para cantidad
                                $nuevaCantidad = $cantidadEnCarrito + $cantidadSolicitada;
                                if ($nuevaCantidad <= $fila['stock']) {
                                    // Agrega el idJuego al principio del array
                                    $producto = array($fila['idJuego'], $fila['nombre'], $nuevaCantidad, $plataforma, $fila['precio'], $nuevaCantidad * $fila['precio']);
                                    $_SESSION['carrito'][$idJuego] = $producto;
                                    echo "<p>Producto añadido al carrito correctamente.</p>";
                                } else
                                    echo "<p>No se pueden añadir más unidades de este producto debido a limitaciones de stock.</p>";
                            } else
                                echo "<p>Producto no encontrado.</p>";
                        } else 
                            echo "<p>Debe iniciar sesión para agregar productos al carrito.</p>";
                    }

                    /**
                     * Función para calcular descuento por fidelidad
                     */
                    function calcularDescuentoPorFidelidad($conexion) {
                        $descuento = 0;
                        if (isset($_SESSION['usuario'])) {
                            $id_Usuario = $_SESSION["usuario"];
                            $sqlCrearFuncion = "
                                CREATE FUNCTION IF NOT EXISTS DescuentoPorFidelidad(_idUsuario VARCHAR(50)) 
                                RETURNS DECIMAL
                                DETERMINISTIC
                                BEGIN
                                    DECLARE numPedidos INT;
                                    DECLARE descuento DECIMAL(5,2);
                                    SELECT COUNT(*) INTO numPedidos FROM compran WHERE idUsuario = _idUsuario;
                                    IF numPedidos >= 3 THEN
                                        SET descuento = 10.00; 
                                    ELSE
                                        SET descuento = 0.00; 
                                    END IF;

                                    RETURN descuento;
                                END;
                            ";
                            $resultadoCrearFuncion = mysqli_query($conexion, $sqlCrearFuncion);
                            if (!$resultadoCrearFuncion) {
                                echo "Error al crear la función: " . mysqli_error($conexion);
                                return $descuento;
                            }
                            $resultadoDescuento = mysqli_query($conexion, "SELECT DescuentoPorFidelidad('$id_Usuario') AS descuento");

                            if ($resultadoDescuento) {
                                $filaDescuento = mysqli_fetch_assoc($resultadoDescuento);
                                if ($filaDescuento && array_key_exists('descuento', $filaDescuento))
                                    $descuento = $filaDescuento['descuento'];
                                else
                                    echo "La columna 'descuento' no está definida en el resultado.";
                            }
                        }
                        return $descuento;
                    }

                    /**
                     * Función para mostrar el carrito
                     * @param $descuento parametro para hacer el descuento al total
                     */
                    function mostrarCarrito($conexion, $descuento) {
                        $totalGeneral = 0;
                        if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
                            echo "<table class='table table-dark table-striped' class='videojuegos'>";
                            echo "<tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Plataforma</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                </tr>";
                            foreach ($_SESSION['carrito'] as $item) {
                                $subtotal = $item[4] * $item[2];
                                echo "<tr>
                                        <td>{$item[1]}</td>
                                        <td>{$item[2]}</td>
                                        <td>{$item[3]}</td>
                                        <td>\${$item[4]}</td>
                                        <td>\${$subtotal}</td>
                                    </tr>";
                                $totalGeneral += $subtotal;
                            }
                            $descuentoValor = number_format(($totalGeneral * $_SESSION['descuento']) / 100, 2);
                            $totalConDescuento = number_format($totalGeneral - $descuentoValor, 2);
                            echo "<tr>
                                    <td colspan='4'>Descuento aplicado</td><td>-$descuentoValor</td>
                                </tr>
                                <tr>
                                    <td colspan='4'>Total</td><td>\$$totalConDescuento</td>
                                </tr>";
                            // Agregar fila para ingresar código de descuento
                            echo "<tr>
                                    <td colspan='5'>
                                        <form method='post' action='aplicarDescuento.php'>
                                            <label for='codigoDescuento'>Código de descuento:</label>
                                            <input type='text' id='codigoDescuento' name='codigoDescuento'>
                                            <button type='submit'>Aplicar</button>
                                        </form>
                                    </td>
                                </tr>
                                </table>";
                            echo '<form method="post" action="procesoCompra.php" onsubmit="return validarFecha()">
                                    <input type="hidden" name="idJuego" value="' . (isset($_POST['iddelJuego']) ? $_POST['iddelJuego'] : '') . '">
                                    <input type="hidden" name="idUsuario" value="' . $_SESSION["usuario"] . '">
                                    <input type="hidden" name="cantStock" value="' . (isset($item['cantidad']) ? $item['cantidad'] : '') . '">
                                    <input type="hidden" name="totalGeneral" value="' . $totalGeneral . '">
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
                                            <input class="inputstyle" id="cardNumber" placeholder="XXXX XXXX XXXX XXXX" name="cardNumber" pattern="[0-9]{12}" type="text" required />
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
                                    <input type="submit" class="btn btn-primary" value="Realizar Compra">
                                </form>
                                <form method="post" action="vaciarCarrito.php">
                                    <input type="submit" class="btn btn-danger" value="Vaciar Carrito">
                                </form>';
                        } else
                            echo "<p>Tu carrito está vacío.</p>";
                    }
                ?>
                <script>
                    /**
                     * Funcion para comprobar que la fecha introducida en la tarjeta de credito es correcta o no (para ver si está caducada) 
                     */
                    function validarFecha() {
                        var inputFecha = document.getElementById('expiry').value;
                        // Verificar que la entrada tenga el formato MM/YY usando una expresión regular
                        var formatoValido = /^\d{2}\/\d{2}$/;
                        if (!formatoValido.test(inputFecha)) {
                            alert('Por favor, introduce la fecha en formato MM/YY.');
                            return false;
                        }
                        // Obtener el mes y el anio del input
                        var partesFecha = inputFecha.split('/');
                        var mes = parseInt(partesFecha[0], 10); // Convertir a número base 10
                        var anio = parseInt(partesFecha[1], 10);
                        // Obtener el mes y el anio actuales
                        var fechaActual = new Date();
                        var mesActual = fechaActual.getMonth() + 1; // getMonth() devuelve valores de 0 a 11, por lo que se agrega 1
                        var añoActual = fechaActual.getFullYear() % 100; // Solo obtener los dos últimos dígitos del anio
                        // Validar que el anio sea igual o mayor al actual, y que el mes esté en el rango válido
                        if (anio < añoActual || (anio === añoActual && mes < mesActual)) {
                            alert('La fecha de la tarjeta no es válida. Debe ser igual o superior al mes y anio actuales.');
                            return false;
                        }
                        return true;
                        
                    }
                </script>
            </div>
        </div>
        <footer class="<?php echo $footerClass; ?>">
            <?php include 'footer.php'; ?>
        </footer>
        <script src="cambioFooter.js"></script>
    </body>
</html>
