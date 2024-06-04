document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');

    const gridSize = 40;
    const tileSize = canvas.width / gridSize;
    let playerSnake = [{ x: 10, y: 10 }];
    let aiSnake = [{ x: 30, y: 30 }];
    let playerDirection = { x: 0, y: 0 };
    let aiDirection = { x: 0, y: 0 };
    let food = { x: 20, y: 20 };
    let playerScore = 0;
    let aiScore = 0;

    /**
     * Dibuja un cuadrado (tile) en el canvas.
     * @param {number} x - La coordenada x del tile en la cuadrícula.
     * @param {number} y - La coordenada y del tile en la cuadrícula.
     * @param {string} color - El color del tile.
     */
    function drawTile(x, y, color) {
        ctx.fillStyle = color;
        ctx.fillRect(x * tileSize, y * tileSize, tileSize, tileSize);
    }

    /**
     * Dibuja el estado actual del juego en el canvas.
     * Limpia el canvas y luego dibuja las serpientes del jugador y de la IA, así como la comida en sus posiciones actuales.
     */
    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        playerSnake.forEach(segment => drawTile(segment.x, segment.y, 'green'));
        aiSnake.forEach(segment => drawTile(segment.x, segment.y, 'blue'));
        drawTile(food.x, food.y, 'red');
    }

    /**
     * Mueve la serpiente en la dirección especificada.
     * Agrega una nueva cabeza a la serpiente en la dirección del movimiento.
     * Si la serpiente alcanza la comida, se coloca nueva comida en el tablero.
     * Si no, se elimina el último segmento de la serpiente para mantener su longitud constante.
     * @param {Array} snake - La serpiente a mover, representada como una lista de segmentos.
     * @param {Object} direction - La dirección en la que se mueve la serpiente, con propiedades x e y.
     */
    function moveSnake(snake, direction) {
        const head = { x: snake[0].x + direction.x, y: snake[0].y + direction.y };
        snake.unshift(head);
        if (head.x === food.x && head.y === food.y)
            placeFood();
        else
            snake.pop(); 
    }

    /**
     * Coloca la comida en una posición aleatoria en el tablero.
     * Genera una nueva posición para la comida que no coincida con ninguna de las posiciones actuales de las serpientes del jugador o de la IA.
     * Se asegura de que la nueva posición de la comida esté dentro de los límites del tablero.
     */
    function placeFood() {
        let newFood;
        do {
            newFood = { x: Math.floor(Math.random() * gridSize), y: Math.floor(Math.random() * gridSize) };
        } while (playerSnake.some(segment => segment.x === newFood.x && segment.y === newFood.y) || aiSnake.some(segment => segment.x === newFood.x && segment.y === newFood.y));
        food = newFood;
    }

    /**
     * Verifica si la serpiente ha colisionado consigo misma o con los bordes del tablero.
     * 
     * @param {Array} snake - La serpiente a verificar, representada como una lista de segmentos.
     * @returns {boolean} - Verdadero si hay una colisión, falso en caso contrario.
     */
    function checkCollision(snake) {
        const head = snake[0];
        if (head.x < 0 || head.x >= gridSize || head.y < 0 || head.y >= gridSize)
            return true;
        
        for (let i = 1; i < snake.length; i++) {
            if (snake[i].x === head.x && snake[i].y === head.y)
                return true;
        }
        return false;
    }

    /**
     * Calcula la heurística entre dos puntos en el tablero.
     * La heurística es la suma de las diferencias absolutas entre las coordenadas x e y de los dos puntos.
     * @param {Object} a - El primer punto, con propiedades x e y.
     * @param {Object} b - El segundo punto, con propiedades x e y.
     * @returns {number} - El valor de la heurística entre los dos puntos.
     */
    function heuristic(a, b) {
        return Math.abs(a.x - b.x) + Math.abs(a.y - b.y);
    }

    /**
     * Implementa el algoritmo de poda alfa-beta para evaluar la mejor ruta entre dos puntos en el tablero.
     * Este algoritmo optimiza la búsqueda minimax al podar las ramas del árbol de decisiones que no afectarán
     * al resultado final, reduciendo así el número de nodos evaluados.
     * @param {Object} start - El punto de inicio de la búsqueda.
     * @param {Object} end - El punto de destino de la búsqueda.
     * @param {number} depth - La profundidad máxima de la búsqueda.
     * @param {number} alpha - El valor de alfa para la poda.
     * @param {number} beta - El valor de beta para la poda.
     * @param {boolean} maximizingPlayer - Indica si el jugador en el nodo actual es el jugador Max.
     * @param {Array} snake - La serpiente en el tablero, representada como una lista de segmentos.
     * @returns {number} - El valor de la evaluación de la mejor ruta entre los puntos de inicio y fin.
     */
    function alphaBetaPruning(start, end, depth, alpha, beta, maximizingPlayer, snake) {
        if (depth === 0 || (start.x === end.x && start.y === end.y))
            return heuristic(start, end);
        const neighbors = [
            { x: start.x + 1, y: start.y },
            { x: start.x - 1, y: start.y },
            { x: start.x, y: start.y + 1 },
            { x: start.x, y: start.y - 1 }
        ].filter(neighbor => {
            return neighbor.x >= 0 && neighbor.y >= 0 && neighbor.x < gridSize && neighbor.y < gridSize && !snake.some(segment => segment.x === neighbor.x && segment.y === neighbor.y);
        });
        if (maximizingPlayer) {
            let maxEval = -Infinity;
            for (const neighbor of neighbors) {
                const eval = alphaBetaPruning(neighbor, end, depth - 1, alpha, beta, false, snake);
                maxEval = Math.max(maxEval, eval);
                alpha = Math.max(alpha, eval);
                if (beta <= alpha)
                    break;
            }
            return maxEval;
        } else {
            let minEval = Infinity;
            for (const neighbor of neighbors) {
                const eval = alphaBetaPruning(neighbor, end, depth - 1, alpha, beta, true, snake);
                minEval = Math.min(minEval, eval);
                beta = Math.min(beta, eval);
                if (beta <= alpha)
                    break;
            }
            return minEval;
        }
    }

    /**
     * Encuentra la mejor ruta para la serpiente hacia la comida utilizando el algoritmo de poda alfa-beta.
     * @param {Array} snake - La serpiente en el tablero, representada como una lista de segmentos.
     * @returns {Object} - El movimiento recomendado para la serpiente, con propiedades x e y.
     */
    function findPathToFood(snake) {
        const start = snake[0];
        const end = food;
        let bestMove = null;
        let bestValue = Infinity;
        const neighbors = [
            { x: start.x + 1, y: start.y },
            { x: start.x - 1, y: start.y },
            { x: start.x, y: start.y + 1 },
            { x: start.x, y: start.y - 1 }
        ].filter(neighbor => {
            return neighbor.x >= 0 && neighbor.y >= 0 && neighbor.x < gridSize && neighbor.y < gridSize && !snake.some(segment => segment.x === neighbor.x && segment.y === neighbor.y);
        });
        for (const neighbor of neighbors) {
            const value = alphaBetaPruning(neighbor, end, 3, -Infinity, Infinity, false, snake);
            if (value < bestValue) {
                bestValue = value;
                bestMove = neighbor;
            }
        }
        if (bestMove)
            return { x: bestMove.x - start.x, y: bestMove.y - start.y };
        else
            return { x: 0, y: 0 };
    }

    /**
     * Ejecuta el bucle principal del juego.
     * Mueve las serpientes del jugador y de la IA, actualiza las puntuaciones si es necesario,
     * dibuja el estado actual del juego en el canvas y calcula el siguiente movimiento para la IA.
     */
    function gameLoop() {
        moveSnake(playerSnake, playerDirection);
        moveSnake(aiSnake, aiDirection);
        if (playerSnake[0].x === food.x && playerSnake[0].y === food.y) 
            playerScore++;

        if (aiSnake[0].x === food.x && aiSnake[0].y === food.y) 
            aiScore++;
        
        draw();
        aiDirection = findPathToFood(aiSnake);
    }

    /**
     * Maneja los eventos del teclado para controlar la dirección del jugador.
     * @param {Event} event - El evento de teclado.
     */
    document.addEventListener('keydown', event => {
        switch(event.key) {
            case 'ArrowUp':
                playerDirection = { x: 0, y: -1 };
                break;
            case 'ArrowDown':
                playerDirection = { x: 0, y: 1 };
                break;
            case 'ArrowLeft':
                playerDirection = { x: -1, y: 0 };
                break;
            case 'ArrowRight':
                playerDirection = { x: 1, y: 0 };
                break;
        }
    });

    setInterval(gameLoop, 200);
});
