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
        <style>
            h1 {
                text-align: center;
                margin-bottom: 20px;
            }

            #game-container {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            canvas {
                background-color: #000;
                border: 2px solid #333;
            }
        </style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <h1>Snake Game</h1>
        <div id="game-container">
            <canvas id="gameCanvas" width="500%" height="500%"></canvas>
        </div>
        <script src="snake.js"></script>
        
        <?php include 'footer.php'; ?>
        
    </body>
</html>
