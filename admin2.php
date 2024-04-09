<?php
    session_start();
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tienda_videojuegos";
    $conexion = mysqli_connect($host, $username, $password, $dbname);

    if (!$conexion)
        die("Conexión fallida: " . mysqli_connect_error());

    // Crear el procedimiento almacenado para actualizar el stock
    $sqlCrearProcedimiento = "
        DROP PROCEDURE IF EXISTS ActualizarStock;
        CREATE PROCEDURE ActualizarStock(IN p_idJuego INT, IN p_nuevoStock INT)
        BEGIN
            UPDATE juegos SET stock = p_nuevoStock WHERE idJuego = p_idJuego;
        END;
    ";


    function obtenerJuegos($conexion, $plataforma) {
        $sql = "SELECT idJuego, nombre, stock FROM juegos WHERE plataforma = ?";
        $llamadaProcedimiento = mysqli_prepare($conexion, $sql);
        if ($llamadaProcedimiento) {
            mysqli_stmt_bind_param($llamadaProcedimiento, "s", $plataforma);
            mysqli_stmt_execute($llamadaProcedimiento);
            $result = mysqli_stmt_get_result($llamadaProcedimiento);
            $juegos = [];
            while ($row = mysqli_fetch_assoc($result))
                $juegos[] = $row;
            mysqli_stmt_close($llamadaProcedimiento);
            return $juegos;
        } else {
            echo "Error al preparar la consulta: " . mysqli_error($conexion);
            return [];
        }
    }

    function actualizarStock($conexion, $id, $nuevoStock) {
        $llamadaProcedimiento = mysqli_prepare($conexion, "CALL ActualizarStock(?, ?)");
        if ($llamadaProcedimiento) {
            mysqli_stmt_bind_param($llamadaProcedimiento, "ii", $id, $nuevoStock);
            mysqli_stmt_execute($llamadaProcedimiento);
            mysqli_stmt_close($llamadaProcedimiento);
        } else
            echo "Error al actualizar el stock: " . mysqli_error($conexion);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar'])) {
        $id = $_POST['idJuego'];
        $nuevoStock = $_POST['nuevoStock'];
        actualizarStock($conexion, $id, $nuevoStock);
        header('Location: admin2.php');
        exit();
    }

    if (isset($_SESSION['usuario']) && $_SESSION["administrador"] == 1) {
        $plataformas = array('xbox', 'ps5', 'pc', 'switch');
        $juegosPorPlataforma = array();
        foreach ($plataformas as $plataforma) {
            $juegosPorPlataforma[$plataforma] = obtenerJuegos($conexion, $plataforma);
        }
    } else {
        header('Location: index.php');
        exit();
    }
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
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script>
            // Función para validar que el nuevo stock sea mayor al stock actual
            function validarStockActual(idFormulario, stockActual) {
                const formulario = document.getElementById(idFormulario);
                const nuevoStock = formulario.querySelector('[name="nuevoStock"]').value;
                if (nuevoStock <= stockActual)
                    return false; // Prevenir el envío del formulario
                return true; // Permitir el envío del formulario
            }
        </script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="container">
            <h1>Administración de Stock de Videojuegos</h1>
            <?php foreach (array_keys($juegosPorPlataforma) as $plataforma): ?>
            <h2><?php echo ucfirst($plataforma); ?></h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($juegosPorPlataforma[$plataforma] as $juego): ?>
                    <tr>
                        <td><?php echo $juego['idJuego']; ?></td>
                        <td><?php echo $juego['nombre']; ?></td>
                        <td><?php echo $juego['stock']; ?></td>
                        <td>
                            <form method="post" id="form-<?php echo $juego['idJuego']; ?>" onsubmit="return validarStockActual('form-<?php echo $juego['idJuego']; ?>', <?php echo $juego['stock']; ?>);">
                                <input type="hidden" name="idJuego" value="<?php echo $juego['idJuego']; ?>">
                                <input type="number" name="nuevoStock" min="<?php echo $juego['stock'] + 1; ?>" value="<?php echo $juego['stock'] + 1; ?>" required>
                                <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endforeach; ?>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>