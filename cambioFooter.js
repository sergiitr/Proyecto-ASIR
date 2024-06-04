function hayVideojuegos() {
    return true;
}

function cambiarPosicionFooter() {
    const footer = document.getElementById('miFooter');
    if (hayVideojuegos()) {
        footer.style.position = 'sticky';
        footer.style.bottom = '0';
    } else {
        footer.style.position = 'absolute';
        footer.style.bottom = '0';
    }
}
cambiarPosicionFooter();