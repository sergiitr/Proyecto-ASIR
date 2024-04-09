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
        <link rel="shortcut icon" href="./imagenes/logo.jpeg"/>
        <link rel="stylesheet" href="styles.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="item container-fluid mt-4" id="zona">
            <div class="container" id="container2">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h1 class="snos1"><b>SOBRE NOSOTROS</b></h1>
                        <h2 class="snos2"><b>JUEGOS DE PRIMERAS MARCAS</b></h2>
                        <p class="descripcionEmpresa">
                            ¡Bienvenidos a nuestra tienda de videojuegos en Úbeda, donde la pasión por los juegos cobra vida! Desde nuestra fundación en diciembre de 2023, nos hemos esforzado por ofrecer la experiencia de juego definitiva para todos los gamers de la región.
                            <br>
                            En nuestro compromiso por brindarte lo mejor, trabajamos incansablemente con los proveedores más destacados de la industria. Contamos con un equipo excepcional, apasionado y dedicado, listo para satisfacer tus necesidades y brindarte el servicio que te mereces.
                            <br>
                            Entendemos que para ti, gamer, los juegos son más que entretenimiento; son una forma de vida. Con nuestra página, hemos simplificado el acceso a tus juegos favoritos. Con solo un clic, podrás explorar y adquirir los títulos más emocionantes del momento, o incluso optar por alquilarlos para variar tu experiencia de juego.
                            <br>
                            En esta tienda, no solo encontrarás productos de alta calidad, sino también un lugar donde compartir tu amor por los videojuegos. ¡Únete a nuestra comunidad y descubre un espacio donde la diversión y la emoción nunca tienen límites!
                            <br>
                            Gracias por elegirnos. ¡Prepárate para sumergirte en un mundo lleno de aventuras y desafíos! ¡Game on! 🎮✨
                        </p>
                    </div>
                    <div class="col-12 col-md-6 divSobreNos">
                        <img class="fotoSobreNos img-fluid" src="./imagenes/logo.jpeg">
                    </div>
                </div>
            </div>
        </div>
        <div class="item container-fluid mt-1">
            <div class="container" id="container2">
                <div class="row">
                    <h1><b>¿Donde nos situamos?</b></h1>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25146.335439614882!2d-3.393184692212728!3d38.01697321355801!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6ef37e5ccd3a0d%3A0x1b0aa11ffc43dc15!2sInstituto%20de%20Educaci%C3%B3n%20Secundaria%20Los%20Cerros!5e0!3m2!1ses!2ses!4v1705063565445!5m2!1ses!2ses" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>