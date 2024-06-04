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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="script.js"></script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <?php 
            if (!isset($_SESSION["usuario"]) || $_SESSION["administrador"] !== 1) {
                header('Location: index.php');
                exit;
            }
        ?>
        <div class="container mt-4">
            <h1>Monitor de Ventas x Precio</h1>
            <!-- Aquí se mostrará la gráfica de barras -->
            <div class="chart-container">
                <canvas id="barChart"></canvas>
            </div>
        </div>
        <div class="container mt-4">
            <h1>Monitor de Ventas x Tipo</h1>
            <!-- Aquí se mostrará la gráfica de ventas por tipo de juego -->
            <div class="chart-container">
                <canvas id="barChartTipoJuego"></canvas>
            </div>
        </div>
        <div class="container mt-4">
            <h1>Monitor de Visitas por País</h1>
            <!-- Aquí se mostrará la gráfica de ventas por país -->
            <div class="chart-container">
                <canvas id="barChartPorPais"></canvas>
            </div>
        </div>
        <div class="container mt-4">
            <h1>Monitor de Visitas por Ciudad</h1>
            <!-- Aquí se mostrará la gráfica de ventas por ciudad -->
            <div class="chart-container">
                <canvas id="barChartPorCiudad"></canvas>
            </div>
        </div>
        <?php include 'footer.php'; ?>
        <script src="monitorizacion.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                console.log('Documento cargado');
                // Obtener los datos directamente de PHP
                fetch('monitortipojuego.php')
                    .then(response => response.json())
                    .then(data => {
                        console.log('Datos de ventas por tipo de juego:', data);
                        mostrarGraficaTipoJuego(data);
                    })
                    .catch(error => console.error('Error al obtener los datos de ventas por tipo de juego:', error));
                
                // Obtener los datos directamente de PHP
                fetch('monitorpais.php')
                    .then(response => response.json())
                    .then(data => {
                        console.log('Datos de ventas por país:', data);
                        mostrarGraficaPorPais(data);
                    })
                    .catch(error => console.error('Error al obtener los datos de ventas por país:', error));
                fetch('monitorciudad.php')
                    .then(response => response.json())
                    .then(data => {
                        console.log('Datos de ventas por ciudad:', data);
                        mostrarGraficaPorCiudad(data);
                    })
                    .catch(error => console.error('Error al obtener los datos de ventas por ciudad:', error));
            });
            
            /*
             * Esta función muestra una gráfica de ventas por tipo de juego utilizando los datos proporcionados.
             */
            function mostrarGraficaTipoJuego(data) {
                console.log('Mostrando gráfica de ventas por tipo de juego con datos:', data);
    
                // Obtener los días de la semana y los tipos de juego
                var diasSemana = [...new Set(data.map(item => item.dia_semana))];
                var tiposJuego = [...new Set(data.map(item => item.tipo_juego))];
    
                // Inicializar un objeto para almacenar la cantidad de ventas por tipo de juego y día de la semana
                var ventasPorTipo = {};
    
                // Inicializar las ventas por tipo de juego
                tiposJuego.forEach(tipo => {
                    ventasPorTipo[tipo] = new Array(diasSemana.length).fill(0);
                });
    
                // Llenar las ventas por tipo de juego
                data.forEach(item => {
                    var diaIndex = diasSemana.indexOf(item.dia_semana);
                    var tipoIndex = tiposJuego.indexOf(item.tipo_juego);
                    ventasPorTipo[item.tipo_juego][diaIndex] += parseInt(item.cantidad);
                });
    
                // Configurar los colores para los tipos de juego
                var colors = ['#FF5733', '#33FFC7', '#33B5FF', '#3373FF', '#8933FF', '#FF33E6', '#FF3333'];
    
                // Crear datasets para cada tipo de juego
                var datasets = tiposJuego.map((tipo, index) => {
                    return {
                        label: tipo,
                        data: ventasPorTipo[tipo],
                        backgroundColor: colors[index % colors.length],
                        borderColor: colors[index % colors.length],
                        borderWidth: 1
                    };
                });
    
                // Obtener el contexto del canvas
                var ctx = document.getElementById('barChartTipoJuego').getContext('2d');
                // Crear la instancia de la gráfica utilizando Chart.js
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: diasSemana,
                        datasets: datasets
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
    
            /*
             * Esta función muestra una gráfica de visitas por país utilizando los datos proporcionados.
             */
            function mostrarGraficaPorPais(data) {
                console.log('Mostrando gráfica de visitas por país con datos:', data);
                // Obtener los nombres de los países y las visitas asociadas
                var paises = data.map(item => item.pais);
                var ventasPorPais = data.map(item => item.cantidad);
    
                // Configurar los colores para los países
                var colors = ['#FF5733', '#33FFC7', '#33B5FF', '#3373FF', '#8933FF', '#FF33E6', '#FF3333'];
    
                // Crear dataset para la gráfica por país
                var dataset = {
                    labels: paises,
                    datasets: [{
                        label: 'Visitas por País',
                        data: ventasPorPais,
                        backgroundColor: colors,
                        borderColor: colors,
                        borderWidth: 1
                    }]
                };
    
                // Obtener el contexto del canvas
                var ctx = document.getElementById('barChartPorPais').getContext('2d');
                // Crear la instancia de la gráfica utilizando Chart.js
                new Chart(ctx, {
                    type: 'bar',
                    data: dataset,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
            
            /*
             * Esta función muestra una gráfica de visitas por ciudad utilizando los datos proporcionados.
             */
            function mostrarGraficaPorCiudad(data) {
                console.log('Mostrando gráfica de visitas por ciudad con datos:', data);
                // Obtener los nombres de las ciudades y las visitas asociadas
                var ciudades = data.map(item => item.ciudad);
                var ventasPorCiudad = data.map(item => item.cantidad);
        
                // Configurar los colores para las ciudades
                var colors = ['#FF5733', '#33FFC7', '#33B5FF', '#3373FF', '#8933FF', '#FF33E6', '#FF3333'];
        
                // Crear dataset para la gráfica por ciudad
                var dataset = {
                    labels: ciudades,
                    datasets: [{
                        label: 'Visitas por Ciudad',
                        data: ventasPorCiudad,
                        backgroundColor: colors,
                        borderColor: colors,
                        borderWidth: 1
                    }]
                };
        
                // Obtener el contexto del canvas
                var ctx = document.getElementById('barChartPorCiudad').getContext('2d');
                // Crear la instancia de la gráfica utilizando Chart.js
                new Chart(ctx, {
                    type: 'bar',
                    data: dataset,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        </script>
    </body>
</html>