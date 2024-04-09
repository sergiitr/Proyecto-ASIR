var logoutLink = document.getElementById("logout-link");
function redirectPage(value) {
    if (value === "carrito")
        window.location.href = "./carrito.php";
    else if (value === "alquiler")
        window.location.href = "./alquiler.php";
    
}
function redirectPage2(value) {
    if (value === "pedidos")
        window.location.href = "./cliente.php";
    else if (value === "cerrarSesion") {
        console.log("Cerrando sesión...");
        logoutLink.style.display = "block";
        cerrarSesion();
    }  else if (value === "borrarUsuario") {
        // Confirmar antes de borrar
        var confirmar = confirm("¿Está seguro de que desea borrar su usuario? Esta acción no se puede deshacer.");
        if (confirmar) 
            window.location.href = "./borrarUsuario.php";
    } else if (value == "admin")
        window.location.href = "./admin.php";
    else if (value == "admin2")
        window.location.href = "./admin2.php";
    else if (value == "admin3")
        window.location.href = "./admin3.php";
    else if (value == "admin4")
        window.location.href = "./admin4.php";
    else if (value == "admin5")
        window.location.href = "./admin5.php";
}

function cerrarSesion() {
    window.location.href = './cerrarSesion.php';
}