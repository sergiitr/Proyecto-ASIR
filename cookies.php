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
        <div class="container mt-4" id="texto-cookies">
            <p>
                Esta página web utiliza cookies para mejorar la experiencia del usuario. A continuación, explicamos qué son las cookies, cómo las utilizamos en este sitio y cómo puedes controlarlas.
                <br><br>
                ¿Qué son las Cookies?
                <br>
                Las cookies son pequeños archivos de texto que se almacenan en tu dispositivo cuando visitas un sitio web. Estos archivos contienen información que puede ser utilizada por el sitio para mejorar la experiencia del usuario, recordar preferencias o realizar un seguimiento del comportamiento de navegación.
                <br><br>
                ¿Cómo Utilizamos las Cookies?
                <br>
                En este sitio web, utilizamos cookies para:
                <br>
                Análisis: Utilizamos cookies de análisis para comprender cómo los visitantes interactúan con el sitio, qué páginas son más populares y cómo podemos mejorar nuestra oferta de contenido.
                <br>
                Personalización: Algunas cookies se utilizan para recordar tus preferencias, como el idioma o la región, para proporcionar una experiencia más personalizada.
                <br>
                Publicidad: Podemos utilizar cookies para mostrar anuncios relevantes basados en tu interacción con nuestro sitio.
                <br><br>
                Control de Cookies
                <br>
                Puedes controlar y gestionar las cookies de varias maneras. La mayoría de los navegadores web te permiten aceptar, rechazar o eliminar cookies a través de la configuración. Ten en cuenta que la eliminación de ciertas cookies puede afectar la funcionalidad y experiencia de navegación en este sitio.
                <br><br>
                Consentimiento
                <br>
                Al utilizar este sitio web, aceptas el uso de cookies de acuerdo con esta política. Si no estás de acuerdo con el uso de cookies, te recomendamos ajustar la configuración de tu navegador o abstenerse de utilizar este sitio.
                <br><br>
                Cambios en la Política de Cookies
                <br>
                Esta política de cookies puede ser actualizada ocasionalmente para reflejar cambios en las cookies que utilizamos o por exigencias legales. Te recomendamos revisar periódicamente esta página para estar al tanto de cualquier actualización.
                <br><br>
                Contacto
                <br>
                Si tienes preguntas o inquietudes sobre nuestra política de cookies, no dudes en contactarnos a través de la información de contacto proporcionada en la página de contacto.
            </p>
        </div>
        <?php include 'footer.php'; ?>
        <script>
            // Función para cambiar el idioma del texto de cookies
            function cambiarIdioma(idioma) {
                var textoCookies = document.getElementById("texto-cookies").innerHTML.trim();
                // Realizar una solicitud AJAX para traducir el texto
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            document.getElementById("texto-cookies").innerHTML = xhr.responseText;  // Actualizar el texto de cookies con la traducción
                        } else
                            console.error('Error al realizar la solicitud.');
                    }
                };
                xhr.open('POST', 'traducir_texto.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('texto=' + encodeURIComponent(textoCookies) + '&idioma=' + idioma);
            }
        </script>
    </body>
</html>
