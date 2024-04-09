// Función para verificar si el usuario está en un dispositivo móvil
function isMobileDevice() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

// Obtener los enlaces de las aplicaciones móviles
var instagramLink = document.getElementById('mobileAppLink1');
var githubLink = document.getElementById('mobileAppLink2');
var linkedinLink = document.getElementById('mobileAppLink3');

// Verificar si el usuario está en un dispositivo móvil
if (isMobileDevice()) {
    // Verificar si la aplicación de Instagram está instalada y abrir la aplicación correspondiente
    if (instagramLink) {
        instagramLink.addEventListener('click', function(event) {
            event.preventDefault(); // Evitar la redirección por defecto
            window.location.href = "instagram://user?username=sergiitr11"; // Intentar abrir la aplicación de Instagram
            setTimeout(function() {
                window.location.href = "https://play.google.com/store/apps/details?id=com.instagram.android"; // Redirigir a la Play Store si no está instalada
            }, 1000); // Ajustar el tiempo de espera
        });
    }

    if (githubLink) {
        githubLink.addEventListener('click', function(event) {
            event.preventDefault();
            window.location.href = "github://user?username=sergiitr"; // Intentar abrir la aplicación de GitHub
            setTimeout(function() {
                window.location.href = "https://play.google.com/store/apps/details?id=com.github.android"; // Redirigir a la Play Store si no está instalada
            }, 1000);
        });
    }

    if (linkedinLink) {
        linkedinLink.addEventListener('click', function(event) {
            event.preventDefault();
            window.location.href = "linkedin://profile/sergiitr11"; // Intentar abrir la aplicación de LinkedIn
            setTimeout(function() {
                window.location.href = "https://play.google.com/store/apps/details?id=com.linkedin.android"; // Redirigir a la Play Store si no está instalada
            }, 1000);
        });
    }
}