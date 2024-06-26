<?php
    session_start();
    if (basename($_SERVER['PHP_SELF']) === 'header.php') {
        // Verificar si existe una URL anterior almacenada en la variable de sesión
        if (isset($_SESSION['previous_url'])) {
            header('Location: ' . $_SESSION['previous_url']);
            exit;
        } else {
            header('Location: /');
            exit;
        }
    }
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
        <div id="psup" class="container-fluid mt-2">
            <button id="menuBtn" class="menu-btn" onclick="toggleMenu()">☰ Menú</button>
            <script>
                function toggleMenu() {
                    var menu = document.getElementById('tablaSecciones');
                    menu.classList.toggle('show-menu');
                }
            </script>
            <table id="tablaSecciones">
                <tr class="align-middle">
                    <td class="tdDatos">
                        <p class="principal"><a class="enlacePaginaActual" href="./index.php">PAGINA PRINCIPAL</a></p>
                    </td>
                    <td class="tdDatos">
                        <p class="sobreNos"><a class="enlacePaginaActual" href="./nosotros.php">SOBRE NOSOTROS</a></p>
                    </td>
                    <td class="tdDatos">
                        <p class="foro"><a class="enlacePaginaActual" href="./foro.php">FORO</a></p>
                    </td>
                    <td class="tdDatos">
                        <p class="foro"><a class="enlacePaginaActual" href="https://g.co/kgs/fLHECPu">Dejanos una valoración</a></p>
                    </td>
                    <?php
                        if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
                            // Verificar si el usuario no es root
                            if ($_SESSION["administrador"] != "1") {
                                echo '
                                    <td class="tdDatos">
                                        <select aria-label="Default select example" onchange="redirectPage(this.value)">
                                            <option selected disabled>SELECCIONE CARRITO</option>
                                            <option value="carrito">CARRITO VENTA</option>
                                            <option value="alquiler">CARRITO ALQUILER</option>
                                        </select>
                                    </td>
                                ';
                            }
                            echo '
                                <td class="tdDatos">
                                    <div class="user-info">
                                        <p class="username">¡Hola, ',$_SESSION["usuario"],'!</p>';
                            // Verificar si el usuario es administrador
                            if ($_SESSION["administrador"] == "1") {
                                echo '
                                    <select aria-label="Default select example" onchange="redirectPage2(this.value)">
                                        <option selected disabled>Seleccione una opción</option>
                                        <option value="mis_datos">Mis Datos</option>
                                        <option value="admin">Administrar Usuarios</option>
                                        <option value="admin2">Administrar Stock</option>
                                        <option value="admin3">Añadir Videojuegos</option>
                                        <option value="admin4">Copia de seguridad</option>
                                        <option value="admin5">Monitorizacion</option>
                                        <option value="cerrarSesion">Cerrar sesión</option>
                                    </select>
                                    <a id="logoutLink" class="logout-link" style="display: none;" onclick="cerrarSesion()">Cerrar sesión</a>';
                            } else {
                                echo '
                                    <select aria-label="Default select example" onchange="redirectPage2(this.value)">
                                        <option selected disabled>Seleccione una opción</option>
                                        <option value="mis_datos">Mis Datos</option>
                                        <option value="pedidos">Mis pedidos</option>
                                        <option value="recomendacion">Mis recomendaciones</option>
                                        <option value="cerrarSesion">Cerrar sesión</option>
                                        <option value="borrarUsuario">Borrar Usuario</option>
                                    </select>
                                    <a id="logoutLink" class="logout-link" style="display: none;" onclick="cerrarSesion()">Cerrar sesión</a>';
                            } echo '
                                    </div>
                                </td>';
                        } else {
                            echo '
                                <td class="tdDatos">
                                    <p class="sobreNos"><a class="enlacePaginaActual" href="./crearUsuario.php">Crear Usuario</a></p>
                                </td>
                                <td class="tdDatos">
                                    <p class="carrito"><a class="enlacesPaginas" href="./formInicioSesion.php">Inicio Sesion</a></p>
                                </td>';
                        }
                    ?>
                </tr>
            </table>
        </div>
        <script src="opciones.js"></script>
        <script>
            <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) { ?>
                var logoutLink = document.getElementById('logoutLink');
                logoutLink.addEventListener('click', function () {
                    window.location.href = './cerrarSesion.php';
                });
            <?php } ?>
        </script>
    </body>
</html>