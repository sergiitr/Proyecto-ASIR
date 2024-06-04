<?php
    // Función para verificar si el nombre de usuario sigue patrones sospechosos
    function esNombreUsuarioSospechoso($nombreUsuario) {
        // Patrones sospechosos
        $patronSospechoso1 = '/([a-zA-Z0-9])\1{2,}/'; // Detecta 3 o más repeticiones del mismo caracter
        $patronSospechoso2 = '/^[a-zA-Z0-9]{5,}$/'; // Detecta nombres de usuario de menos de 5 caracteres
        $patronSospechoso3 = '/[^a-zA-Z0-9]/'; // Detecta caracteres no alfanuméricos
        $patronSospechoso4 = '/[0-9]{4,}/'; // Detecta 4 o más dígitos consecutivos
    
        // Lista de palabras comunes sospechosas
        $palabrasSospechosas = array('admin', 'root', 'password', '123456', 'qwerty');
    
        // Verificar si el nombre de usuario sigue algún patrón sospechoso
        if (preg_match($patronSospechoso1, $nombreUsuario) ||  preg_match($patronSospechoso2, $nombreUsuario) ||  preg_match($patronSospechoso3, $nombreUsuario) ||  preg_match($patronSospechoso4, $nombreUsuario) ||  in_array(strtolower($nombreUsuario), $palabrasSospechosas))
            return true; // El nombre de usuario es sospechoso
        else
            return false; // El nombre de usuario es válido
    }
?>
