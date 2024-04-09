<?php
    session_start();
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
        <style>
            body.dark-mode {
                background-color: #333;
                color: #fff;
            }
        </style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div id="carouselExampleDark" class="carousel carousel-dark slide h-10" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3" aria-label="Slide 4"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="10000">
                    <img src="./imagenes/ps5.png" class="d-block w-100" class="imagenesConsolas">
                    <div class="carousel-caption d-block">
                        <h5 class="catalogos"><a class="catalogos" href="./ps5.php">Catalogo PS5</a></h5>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="./imagenes/xbox.png" class="d-block w-100" class="imagenesConsolas">
                    <div class="carousel-caption d-block">
                        <h5 class="catalogos"><a class="catalogos" href="./xbox.php">Catalogo XBOX One</a></h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./imagenes/switch.png" class="d-block w-100" class="imagenesConsolas">
                    <div class="carousel-caption d-block">
                        <h5 class="catalogos"><a class="catalogos" href="./switch.php">Catalogo Nintendo Switch</a></h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./imagenes/pc.png" class="d-block w-100" class="imagenesConsolas">
                    <div class="carousel-caption d-block">
                        <h5 class="catalogos"><a class="catalogos" href="./pc.php">Catalogo PC</a></h5>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
        
        <button onclick="chat()" id="chat-button">.</button>
        <iframe src="./chat.php" id="chat" frameborder="1" width="100%" hidden></iframe>

        <script>
            function chat() {
                var chatFrame = document.getElementById("chat");
                var chatButton = document.getElementById("chat-button");

                if (chatFrame.hidden)
                    chatFrame.hidden = false;  
                else
                    chatFrame.hidden = true;
            }
        </script>

        <?php include 'footer.php'; ?>
    </body>
</html>