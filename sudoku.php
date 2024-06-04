<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Proyecto</title>
        <link rel="shortcut icon" href="./imagenes/logo.jpeg"/>
        <link rel="stylesheet" type="text/css" href="styles.css"/>
        <script src="script.js"></script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="container mt-4">
            <h1>Sudoku</h1>
            <div id="sudoku-container">
                <!-- Aquí se generará el tablero del Sudoku dinámicamente -->
            </div>
            <button id="reset-button">Resetear</button>
        
            <script src="sudoku.js"></script>
        </div>
        <div class="abajo">
            <?php include 'footer.php'; ?>
        </div>
    </body>
</html>
