var strengthMeter = document.getElementById("password-strength-meter");
var strengthBar = document.createElement("div");
strengthBar.className = "strength";
strengthMeter.appendChild(strengthBar);
var passwordInput = document.getElementById("contrasena");
var confirmPasswordInput = document.getElementById("confirmcontrasena");
var submitButton = document.getElementById("submitButton");
// Función para actualizar las condiciones de contraseña
function updateConditions() {
    var password = passwordInput.value;
    var hasUpperCase = /[A-Z]/.test(password);
    var hasLowerCase = /[a-z]/.test(password);
    var hasNumber = /\d/.test(password);
    var hasLength = password.length >= 7;
    // Update tick/cross for each condition
    document.getElementById("uppercase").innerHTML = hasUpperCase ? "&#x2714;" : "&#x2718;";
    document.getElementById("lowercase").innerHTML = hasLowerCase ? "&#x2714;" : "&#x2718;";
    document.getElementById("number").innerHTML = hasNumber ? "&#x2714;" : "&#x2718;";
    document.getElementById("length").innerHTML = hasLength ? "&#x2714;" : "&#x2718;";
}
// Event listener para actualizar condiciones y fortaleza de contraseña
passwordInput.addEventListener("input", function() {
    var password = passwordInput.value;
    var confirmPassword = confirmPasswordInput.value;

    var hasUpperCase = /[A-Z]/.test(password);
    var hasLowerCase = /[a-z]/.test(password);
    var hasNumber = /\d/.test(password);
    var hasLength = password.length >= 7;
    var strength = 0;
    if (hasUpperCase && hasLowerCase && hasNumber && hasLength) {
        if (password.length >= 11)
            strength = 3; // Verde
        else if (password.length >= 7)
            strength = 2; // Naranja
    } else
        strength = 1; // Rojo
    // Actualizar el ancho de la barra de fortaleza de contraseña
    strengthBar.style.width = (strength * 33.33) + "%";
    // Cambiar el color de la barra según la fortaleza de la contraseña
    if (strength === 1)
        strengthBar.style.backgroundColor = "#e74c3c"; // Rojo
    else if (strength === 2)
        strengthBar.style.backgroundColor = "#f39c12"; // Naranja
    else if (strength === 3)
        strengthBar.style.backgroundColor = "#2ecc71"; // Verde
    // Actualizar las condiciones de contraseña
    updateConditions();
    // Habilitar o deshabilitar el botón de enviar según la fortaleza de la contraseña
    if (password === confirmPassword && hasUpperCase && hasLowerCase && hasNumber && hasLength)
        submitButton.disabled = false;
    else
        submitButton.disabled = true;
});
// Después de la parte que actualiza el medidor de fuerza de la contraseña en contrasena.js
var conditionsText = document.createElement("div");
conditionsText.innerHTML = "  <div class='cond_contra'>   <p>Condiciones típicas de contraseña:</p>" +
            "<ul>" +
            "<li><span id='uppercase'></span> 1 mayúscula</li>" +
            "<li><span id='lowercase'></span> 1 minúscula</li>" +
            "<li><span id='number'></span> 1 número</li>" +
            "<li><span id='length'></span> Longitud mínima</li>" +
            "</ul></div>";
strengthMeter.appendChild(conditionsText);