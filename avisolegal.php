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
        <div class="container" id="texto-legal">
            <h2>Aviso Legal</h2>
            <p>
                Agradecemos su visita a nuestra página WEB https://sergiitrgames.com.es/ (en adelante "WEB"). Nuestra mayor preocupación es asegurar la exactitud y trabajamos continuamente en la actualización de las informaciones difundidas en nuestra web, reservándonos en todo momento y sin previo aviso el derecho de corregir o modificar su contenido. En consecuencia, <span style="text-transform: uppercase;">https://sergiitrgames.com.es/ </span> no responderá en ningún caso de:
                <ul>
                    <li>Cualquier daño resultante de una intrusión fraudulenta de un tercero que haya causado una modificación en las informaciones puestas a disposición en la web.</li>
                    <li>En general, de cualesquiera daños directos o indirectos, cualquiera que sea la causa, origen, naturaleza o consecuencia, provocados:
                        <ul>
                            <li>con ocasión del acceso por cualquier persona a la web</li>
                            <li>derivados de la imposibilidad de acceso</li>
                            <li>por la utilización de la web y/o por la credibilidad otorgada a cualquier información proveniente directa o indirectamente de la web</li>
                            <li>por cualquier hecho calificado de fuerza mayor o caso fortuito</li>
                        </ul>
                    </li>
                </ul>
                Las presentes condiciones de venta regulan únicamente las ventas de productos ofertados en la web. Toda persona que vaya a realizar su pedido a través de la WEB puede acceder a las presentes condiciones generales de venta.
    
                Por consiguiente, el hecho de hacer un pedido conlleva de pleno derecho la adhesión del comprador a las presentes condiciones de venta.
            </p>
            <h2>EDITOR DE LA WEB</h2>
            <p>
                <span style="text-transform: uppercase;">https://sergiitrgames.com.es/ </span> dirección :  S.L. Sede social:  
                Inscrita en el Registro Mercantil de  <span style="text-transform: uppercase;">DNI/NIF</span>: 26518076L.
            </p>
            <h2>LEY DE PROTECCIÓN DE DATOS</h2>
            <p>
                De conformidad con la Ley Orgánica de Protección de Datos y su Reglamento de Desarrollo, le informamos de que los datos personales que nos facilite serán incorporados a un fichero responsabilidad de https://sergiitrgames.com.es/, con domicilio en dirección :  S.L. Sede social: , autorizándonos Ud. su tratamiento, incluso vía telefónica, SMS o correo electrónico, con la finalidad de gestionar y mantener la relación comercial con usted, así como mantenerle informado sobre otros productos y servicios propios o de terceros, pertenecientes a los sectores del gran consumo, la belleza y la cosmética.
    
                Usted podrá ejercer sus derechos de acceso, rectificación, cancelación y oposición a través de correo ordinario, dirigido al siguiente domicilio: [dirección :  S.L. Sede social:  ], adjuntando copia de su DNI o documento equivalente, y concretando su solicitud, o bien mediante correo electrónico a la dirección siguiente: sergiotrillorodriguez123@gmail.com                    
            </p>
            <h2>PROPIEDAD INTELECTUAL E INDUSTRIAL</h2>
            <p>
                Según la legislación vigente en materia de propiedad intelectual e industrial, la presente web y cualquier elemento, marca, dibujo, modelo, logo, gráfico, etc. que se encuentran en dicha web son propiedad exclusiva de <span style="text-transform: uppercase;">https://sergiitrgames.com.es/ </span> o de sus colaboradores, que no conceden ninguna otra licencia o derecho que la de consultar la WEB. La reproducción o utilización del conjunto o de una parte de estos elementos autoriza únicamente a ser informado de manera personal y privada. Cualquier reproducción o utilización de copias realizadas con otros fines queda expresamente prohibida. Cualquier uso indebido constituye un fraude y podrá ser perseguido de conformidad con la legislación vigente, salvo en los casos de autorización previa y por escrito por parte de <span style="text-transform: uppercase;">https://sergiitrgames.com.es/ </span>.  
            </p>
        </div>
        <?php include 'footer.php'; ?>
        <script>
            // Función para cambiar el idioma del texto legal
            function cambiarIdioma(idioma) {
                var textoLegal = document.getElementById("texto-legal").innerHTML; // Usar innerHTML en lugar de textContent
                // Realizar una solicitud AJAX para traducir el texto
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Actualizar el texto legal con la traducción
                            document.getElementById("texto-legal").innerHTML = xhr.responseText; // Usar innerHTML en lugar de textContent
                        } else {
                            console.error('Error al realizar la solicitud.');
                        }
                    }
                };
                xhr.open('POST', 'traducir_texto.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('texto=' + encodeURIComponent(textoLegal) + '&idioma=' + idioma);
            }
        </script>
    </body>
</html>
