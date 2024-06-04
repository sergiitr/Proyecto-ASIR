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
        <script src="script.js"></script>
    </head>
    <body>
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
        <div class="container mt-4" id="texto-faq">
            <h2>Preguntas Frecuentes (FAQ)</h2>
            <ul>
                <li><strong>1. ¿Las compras y alquileres tienen validez?</strong><br>
                No, las compras y alquileres realizados en nuestra plataforma no tienen validez alguna. Tampoco se realizará ningún cargo, por lo que no es necesario ingresar información de tarjeta de crédito personal. Nuestra plataforma se utiliza exclusivamente con fines educativos y de práctica.  </li>
                
                <li><strong>2. ¿Qué tipo de videojuegos ofrece su plataforma?</strong><br>
                En nuestra plataforma, ofrecemos una amplia variedad de videojuegos para todas las plataformas populares, incluyendo PC y consolas de videojuegos (como PlayStation, Xbox, Nintendo Switch). Nuestro catálogo incluye juegos de acción, aventura, estrategia, deportes, simulación y muchos más.</li>
        
                <li><strong>3. ¿Cómo funciona el proceso de alquiler de videojuegos?</strong><br>
                El proceso de alquiler de videojuegos es muy sencillo. Una vez que encuentres el juego que deseas alquilar, simplemente selecciona la opción de alquiler y tienes una duración de 15 dias para usar tu videojuego. Realiza el pago correspondiente y podrás disfrutar del juego durante el período seleccionado. Una vez que expire el alquiler, el acceso al juego será automáticamente desactivado.</li>
        
                <li><strong>4. ¿Cómo funciona el proceso de compra de videojuegos?</strong><br>
                Para comprar un videojuego, simplemente selecciona el juego que deseas comprar y añádelo a tu carrito de compras. Luego, procede al proceso de pago, donde podrás ingresar tus datos de pago y completar la transacción. Una vez completada la compra, en su seccion personal tendra sus juegos comprados</li>
        
                <li><strong>5. ¿Cómo puedo contactar al servicio de atención al cliente?</strong><br>
                Para contactar a nuestro servicio de atención al cliente, puedes enviarnos un correo electrónico a <a href="mailto:contacto@sergiitrgames.com.es">contacto@sergiitrgames.com.es</a> o utilizar el formulario de contacto disponible en nuestra página web. Estamos disponibles para ayudarte de lunes a viernes.</li>
        
                <li><strong>7. ¿Qué medidas de seguridad tienen implementadas para proteger la información de los usuarios?</strong><br>
                En nuestra plataforma, tomamos muy en serio la seguridad y privacidad de nuestros usuarios. Utilizamos medidas de seguridad avanzadas para proteger la información personal y financiera de nuestros usuarios, incluyendo la encriptación de datos y el cumplimiento de las normativas de privacidad vigentes.</li>
        
                <li><strong>8. ¿Puedo jugar a los videojuegos en múltiples dispositivos?</strong><br>
                Sí, muchos de los videojuegos disponibles en nuestra plataforma son compatibles con múltiples dispositivos. Sin embargo, ten en cuenta que algunos juegos pueden requerir una suscripción adicional o la descarga de software adicional para jugar en diferentes dispositivos. Consulta la información del juego para conocer sus requisitos específicos.</li>
        
                <li><strong>9. ¿Ofrecen algún tipo de membresía o programa de fidelización?</strong><br>
                Actualmente, no ofrecemos un programa de membresía o fidelización tradicional. Sin embargo, contamos con dos formas de ofrecer beneficios adicionales a nuestros usuarios:
                    <ol>
                        <b><u><li>Códigos promocionales:</b></u> De vez en cuando, ofrecemos códigos promocionales que pueden ser canjeados por descuentos. Mantente atento a nuesto boletín de noticias para obtener estos códigos.</li>
                        <b><u><li>Minijuegos con beneficios:</b></u> Al realizar compras mínimas, nuestros usuarios pueden acceder a minijuegos exclusivos con oportunidades de ganar premios adicionales. ¡Diviértete y aprovecha estos beneficios adicionales!</li>
                    </ol>
                </li>
            </ul>
        </div>
        <script>
        // Función para cambiar el idioma del texto de privacidad
        function cambiarIdioma(idioma) {
            var textoFAQ = document.getElementById("texto-faq").innerHTML.trim();
            // Realizar una solicitud AJAX para traducir el texto
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Actualizar el texto de privacidad con la traducción
                        document.getElementById("texto-faq").innerHTML = xhr.responseText;
                    } else {
                        console.error('Error al realizar la solicitud.');
                    }
                }
            };
            xhr.open('POST', 'traducir_texto.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('texto=' + encodeURIComponent(textoFAQ) + '&idioma=' + idioma);
        }
    </script>
        <?php include 'footer.php'; ?>
    </body>
</html>