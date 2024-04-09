document.addEventListener('DOMContentLoaded', function () {
    consultarDatos();
});

function consultarDatos() {
    // Realizar la petición AJAX para obtener los datos del servidor
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Parsear la respuesta JSON
            var data = JSON.parse(xhr.responseText);

            // Crear la gráfica de barras
            crearGrafica(data);
        }
    };

    xhr.open('GET', 'monitor.php', true);
    xhr.send();
}

function crearGrafica(data) {
    var diasSemana =['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    var valores = [];

    // Inicializar los valores en 0 para cada día de la semana
    for (var i = 0; i < 7; i++) {
        valores[i] = 0;
    }

    // Verificar si hay oferta y aplicar el descuento del 10%
    var diaOferta = null;
    data.forEach(function (item) {
        var indiceDia = diasSemana.indexOf(item.dia_semana);
        valores[indiceDia] = item.total_ventas;

        if (item.oferta === 1) {
            diaOferta = item.dia_semana;
        }
    });

    // Aplicar el descuento del 10% si hay oferta
    if (diaOferta !== null) {
        var indiceOferta = diasSemana.indexOf(diaOferta);
        valores[indiceOferta] *= 0.9; // Aplicar descuento del 10%
    }

    // Obtener el contexto del canvas
    var ctx = document.getElementById('barChart').getContext('2d');

    // Crear la gráfica de barras
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: diasSemana,
            datasets: [{
                label: 'Ventas diarias',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                data: valores,
            }],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
}