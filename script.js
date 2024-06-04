// Variables globales para el tiempo de inicio y el tiempo total
var startTime;
var totalTime = 0;

// Función para iniciar el contador
function iniciarContador() {
    startTime = new Date().getTime();
}

// Función para detener el contador y enviar el tiempo de permanencia al servidor
function detenerContador() {
    var endTime = new Date().getTime();
    var tiempoPermanencia = (endTime - startTime) / 1000; // Calcular tiempo en segundos
    totalTime += tiempoPermanencia; // Agregar el tiempo actual al tiempo total
    enviarTiempoPermanencia(totalTime);
}

// Manejar el evento de carga de la página para iniciar el contador
window.addEventListener('load', function() {
    iniciarContador();
});

// Manejar el evento de cierre de la pestaña para detener el contador
window.addEventListener('beforeunload', function() {
    detenerContador();
});

// Función para enviar el tiempo de permanencia al servidor
function enviarTiempoPermanencia(tiempoPermanencia) {
    $.ajax({
        url: 'save_data.php',
        method: 'POST',
        data: { tiempoPermanencia: tiempoPermanencia },
        success: function(response) {
            console.log(response);
        }
    });
}
