document.addEventListener('DOMContentLoaded', function () {
    console.log('Documento cargado');
    consultarDatosTipoJuego();
});

function consultarDatosTipoJuego() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                console.log('Datos obtenidos:', data);
                crearGraficaTipoJuego(data);
            } else {
                console.error('Error en la petición AJAX');
            }
        }
    };
    var url = 'monitorTipoJuego.php';
    xhr.open('GET', url, true);
    xhr.send();
}

function crearGraficaTipoJuego(data) {
    console.log('Creando gráfica con datos:', data);

    var diasSemana = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    var datasets = [];

    // Recorrer los datos para cada tipo de juego
    for (var tipoJuego in data) {
        var cantidadPorDia = data[tipoJuego];
        var dataset = {
            label: tipoJuego,
            data: [],
            backgroundColor: getRandomColor()
        };
        // Llenar los datos para cada día de la semana
        for (var i = 0; i < diasSemana.length; i++) {
            var dia = diasSemana[i];
            dataset.data.push(cantidadPorDia[dia] || 0);
        }
        datasets.push(dataset);
    }

    var ctx = document.getElementById('barChartTipoJuego').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: diasSemana,
            datasets: datasets
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}

// Función para generar colores aleatorios
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}