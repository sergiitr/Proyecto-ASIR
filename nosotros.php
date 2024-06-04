<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Proyecto</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="shortcut icon" href="./imagenes/logo.jpeg"/>
        <link rel="stylesheet" href="styles.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <script src="script.js"></script>
        <?php include 'header.php'; ?>
        <div class="container botonesIdiomas">
            <!-- Botones para cambiar de idioma -->
            <button type="button" onclick="cambiarIdioma('es')">
                <img src="./imagenes/espana.png" alt="Español" style="width: 30px; height: auto;">
            </button>
            <button type="button" onclick="cambiarIdioma('en')">
                <img src="./imagenes/inglaterra.png" alt="Inglés" style="width: 30px; height: auto;">
            </button>
        </div>
        
        <div class="item container-fluid mt-4" id="texto-nosotros">
            <div class="container" id="container2">
                <div class="item container mt-4">
                    <h1 class="snos1">SOBRE NOSOTROS</h1>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h2 class="snos2">TUS VIDEOJUEGOS EN UBEDA</h2>
                        <p class="descripcionEmpresa">
                            ¡Bienvenidos a nuestra tienda de videojuegos en Úbeda, donde la pasión por los juegos cobra vida! Desde nuestra fundación en diciembre de 2023, nos hemos esforzado por ofrecer la experiencia de juego definitiva para todos los gamers de la región.
                            <br><br>
                            En nuestro compromiso por brindarte lo mejor, trabajamos incansablemente con los proveedores más destacados de la industria. Contamos con un equipo excepcional, apasionado y dedicado, listo para satisfacer tus necesidades y brindarte el servicio que te mereces.
                            <br><br>
                            Entendemos que para ti, gamer, los juegos son más que entretenimiento; son una forma de vida. Con nuestra página, hemos simplificado el acceso a tus juegos favoritos. Con solo un clic, podrás explorar y adquirir los títulos más emocionantes del momento, o incluso optar por alquilarlos para variar tu experiencia de juego.
                            <br><br>
                            En esta tienda, no solo encontrarás productos de alta calidad, sino también un lugar donde compartir tu amor por los videojuegos. ¡Únete a nuestra comunidad y descubre un espacio donde la diversión y la emoción nunca tienen límites!
                            <br><br>
                            Gracias por elegirnos. ¡Prepárate para sumergirte en un mundo lleno de aventuras y desafíos! ¡Game on! 🎮✨
                        </p>
                    </div>
                    <div class="col-12 col-md-6 divSobreNos">
                        <img class="fotoSobreNos img-fluid" src="./imagenes/logo.jpeg">
                    </div>
                </div>
            </div>
        </div>
        <div class="item container-fluid mt-4" >
            <div class="container" id="texto-nosotros2">
                <div class="row">
                    <h2 class="snos2"><b>¿Cuál es la finalidad de esta página?</b></h2>
                    <p class="descripcionEmpresa">
                        La empresa representada en esta página web es ficticia y ha sido creada con el propósito de servir como proyecto para mi Trabajo de Fin de Grado (TFG). No tiene fines lucrativos ni constituye una entidad comercial real. Esta página ha sido diseñada con propósitos educativos y de demostración. Cualquier similitud con empresas o marcas reales es puramente coincidencial.
                        <br><br>
                        A través de este proyecto, he puesto en práctica habilidades en diseño web, programación y gestión de proyectos, creando una plataforma interactiva que ofrece una experiencia inmersiva en el mundo de los videojuegos. Si bien la empresa y sus servicios son ficticios, el proceso de desarrollo y las decisiones tomadas están fundamentados en un enfoque riguroso y académico.
                        <br><br>
                        Es importante destacar que esta página no tiene fines comerciales ni busca competir en el mercado real. Más bien, sirve como un ejercicio educativo y de demostración, permitiéndome aplicar los conceptos teóricos aprendidos en un entorno práctico.

                    </p>
                </div>
            </div>
        </div>
        <div class="item container mt-1" >
            <h2 class="snos2" id="texto-nosotros3">¿Dónde nos situamos?</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25146.335439614882!2d-3.393184692212728!3d38.01697321355801!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6ef37e5ccd3a0d%3A0x1b0aa11ffc43dc15!2sInstituto%20de%20Educaci%C3%B3n%20Secundaria%20Los%20Cerros!5e0!3m2!1ses!2ses!4v1705063565445!5m2!1ses!2ses" width="100%" height="450px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        
        <script>
            /**
             * Función para cambiar el idioma de las secciones de texto
             */
            function cambiarIdioma(idioma) {
                // Obtener el texto de las secciones
                var nosotros1 = document.getElementById("texto-nosotros").innerHTML;
                var nosotros2 = document.getElementById("texto-nosotros2").innerHTML;
                var nosotros3 = document.getElementById("texto-nosotros3").innerHTML;
        
                // Realizar una solicitud AJAX para traducir el texto de la primera sección
                var xhr1 = new XMLHttpRequest();
                xhr1.onreadystatechange = function() {
                    if (xhr1.readyState === XMLHttpRequest.DONE) {
                        if (xhr1.status === 200)
                            document.getElementById("texto-nosotros").innerHTML = xhr1.responseText;    // Actualizar el texto de la primera sección con la traducción
                        else
                            console.error('Error al realizar la solicitud para la primera sección.');
                    }
                };
                xhr1.open('POST', 'traducir_texto.php', true);
                xhr1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr1.send('texto=' + encodeURIComponent(nosotros1) + '&idioma=' + idioma);
        
                // Realizar una solicitud AJAX para traducir el texto de la segunda sección
                var xhr2 = new XMLHttpRequest();
                xhr2.onreadystatechange = function() {
                    if (xhr2.readyState === XMLHttpRequest.DONE) {
                        if (xhr2.status === 200) 
                            document.getElementById("texto-nosotros2").innerHTML = xhr2.responseText;   // Actualizar el texto de la segunda sección con la traducción
                        else
                            console.error('Error al realizar la solicitud para la segunda sección.');
                    }
                };
                xhr2.open('POST', 'traducir_texto.php', true);
                xhr2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr2.send('texto=' + encodeURIComponent(nosotros2) + '&idioma=' + idioma);
        
                // Realizar una solicitud AJAX para traducir el texto de la tercera sección
                var xhr3 = new XMLHttpRequest();
                xhr3.onreadystatechange = function() {
                    if (xhr3.readyState === XMLHttpRequest.DONE) {
                        if (xhr3.status === 200)
                            document.getElementById("texto-nosotros3").innerHTML = xhr3.responseText;   // Actualizar el texto de la tercera sección con la traducción
                        else
                            console.error('Error al realizar la solicitud para la tercera sección.');
                    }
                };
                xhr3.open('POST', 'traducir_texto.php', true);
                xhr3.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr3.send('texto=' + encodeURIComponent(nosotros3) + '&idioma=' + idioma);
            }
        </script>
        <?php include 'footer.php'; ?>
    </body>
</html>