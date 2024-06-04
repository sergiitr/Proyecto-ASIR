<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="styles.css"/>
        <title>Proyecto</title>
        <link rel="shortcut icon" href="./imagenes/logo.jpeg"/>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
            .result {
                margin-top: 20px;
                font-size: 24px;
            }
            .botoncitos {
                display: flex;
            }
        </style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="container mt-4">
            <h1>Piedra, Papel, Tijera</h1>
            <div class="botoncitos mt-4">
                <button class="button" onclick="play('piedra')">Piedra</button>
                <button class="button" onclick="play('papel')">Papel</button>
                <button class="button" onclick="play('tijera')">Tijera</button>
            </div>
            <div class="result" id="result"></div>
        
            <script>
                // Definimos las tres opciones posibles: piedra, papel y tijera.
                const choices = ['piedra', 'papel', 'tijera'];
                
                // Creamos un historial para almacenar las jugadas del jugador.
                const history = [];
                
                // Función de predicción de la IA que utiliza una estrategia simple.
                function negaScoutPredict() {
                    if (history.length < 2) 
                        return choices[Math.floor(Math.random() * 3)]; // Si no hay suficientes jugadas anteriores, la IA elige al azar.
                    
                    // Estrategia básica: la IA elige la opción que ganaría contra la última jugada del jugador.
                    const lastPlayerMove = history[history.length - 1];
                    switch(lastPlayerMove) {
                        case 'piedra': return 'papel'; // Papel vence a piedra
                        case 'papel': return 'tijera'; // Tijera vence a papel
                        case 'tijera': return 'piedra'; // Piedra vence a tijera
                    }
                }
                
                // Función para manejar la jugada del jugador.
                function play(playerChoice) {
                    // La IA elige su jugada basándose en la predicción.
                    const aiChoice = negaScoutPredict();
                    
                    // Guardamos la jugada del jugador en el historial.
                    history.push(playerChoice);
                    
                    // Determinamos el resultado del juego.
                    const result = getResult(playerChoice, aiChoice);
                    
                    // Mostramos el resultado en la interfaz del usuario.
                    document.getElementById('result').innerHTML = `Tú elegiste ${playerChoice}, IA eligió ${aiChoice}. ${result}`;
                }
                
                // Función para determinar el resultado del juego.
                function getResult(playerChoice, aiChoice) {
                    if (playerChoice === aiChoice) {
                        return '¡Es un empate!';
                    }
                    if ((playerChoice === 'piedra' && aiChoice === 'tijera') || 
                        (playerChoice === 'papel' && aiChoice === 'piedra') || 
                        (playerChoice === 'tijera' && aiChoice === 'papel')) {
                        return '¡Ganaste!';
                    }
                    return '¡Perdiste!';
                }
            </script>

        </div>
        <div class="abajo">
            <?php include 'footer.php'; ?>
        </div>
    </body>
</html>