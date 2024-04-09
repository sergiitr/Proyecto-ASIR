<?php 
    session_start();
    if (!isset($_SESSION["usuario"]) || $_SESSION["administrador"] !== 1) {
        header('Location: index.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>Proyecto</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="shortcut icon" href="./imagenes/logo.jpeg"/>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <?php
            require_once "login.php";
            $conexion = mysqli_connect($host, $user, $pass, $database);
            if (!$conexion)
                die("Error de conexión: " . mysqli_connect_error());
            // Verificar si se envió el formulario de baja
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["usuarios_baja"])) {
                foreach ($_POST["usuarios_baja"] as $idUsuario) {
                    // Consulta para verificar si el usuario es administrador
                    $consultaAdmin = "SELECT Administrador FROM usuarios WHERE idUsuario = '$idUsuario'";
                    $resultadoAdmin = mysqli_query($conexion, $consultaAdmin);
                    $filaAdmin = mysqli_fetch_assoc($resultadoAdmin);

                    // Asegúrate de no eliminar usuarios administradores por accidente
                    if ($filaAdmin['Administrador'] == 1)
                        continue; // No eliminar el usuario si es administrador
                    
                    // Eliminar el usuario y sus registros relacionados
                    $queries = [
                        "DELETE FROM detalle_pedido WHERE idPed IN (SELECT idPed FROM compran WHERE idUsuario = '$idUsuario')",
                        "DELETE FROM compran WHERE idUsuario = '$idUsuario'",
                        "DELETE FROM usuarios WHERE idUsuario = '$idUsuario'"
                    ];
                    
                    foreach ($queries as $query) {
                        if (mysqli_query($conexion, $query)) 
                            echo "Registros eliminados correctamente. <br>";
                        else
                            echo "Error al eliminar registros: " . mysqli_error($conexion);
                    }
                }
                // Refrescar la página para mostrar el estado actualizado
                header("Refresh:0");
            }
            $query = "SELECT idUsuario, nombre, Administrador FROM usuarios";
            $resultado = mysqli_query($conexion, $query);
        ?>
        <div class="container mt-4">
            <h2>Administración de Usuarios</h2>
            <form method="POST" action="">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Seleccionar</th>
                            <th>ID Usuario</th>
                            <th>Nombre</th>
                            <th>Administrador</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while ($fila = mysqli_fetch_assoc($resultado)):
                                $esAdmin = $fila["Administrador"] == 1; // Usa el campo 'Administrador' para determinar si el usuario es administrador
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="usuarios_baja[]" value="<?php echo $fila["idUsuario"]; ?>" <?php if ($esAdmin) echo 'disabled'; ?>>
                            </td>
                            <td><?php echo $fila["idUsuario"]; ?></td>
                            <td><?php echo $fila["nombre"]; ?></td>
                            <td><?php echo $esAdmin ? 'Sí' : 'No'; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-danger">Dar de baja a seleccionados</button>
            </form>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>