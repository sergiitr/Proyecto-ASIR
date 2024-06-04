document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('container');
    const rows = 10;
    const cols = 10;
    const totalMines = 10;
    let gameOver = false;

    /**
     * Inicialización del tablero
     */
    function initializeBoard() {
        // Limpiar el contenedor
        container.innerHTML = '';
        // Crear el tablero
        for (let i = 0; i < rows; i++) {
            const row = document.createElement('div');
            row.classList.add('row', 'justify-content-center');
            for (let j = 0; j < cols; j++) {
                const cell = document.createElement('div');
                cell.classList.add('cell', 'col-auto');
                cell.dataset.row = i;
                cell.dataset.col = j;
                row.appendChild(cell);
            }
            container.appendChild(row);
        }
        // Colocar minas aleatoriamente
        const mines = generateMines();
        for (const mine of mines) {
            const cell = document.querySelector(`.cell[data-row='${mine.row}'][data-col='${mine.col}']`);
            cell.classList.add('mine');
        }
        // Añadir evento clic a cada celda
        container.addEventListener('click', cellClick);
    }

    /**
     * Generar minas aleatoriamente
     * @returns posicion de las minas
     */
    function generateMines() {
        const mines = [];
        while (mines.length < totalMines) {
            const row = Math.floor(Math.random() * rows);
            const col = Math.floor(Math.random() * cols);
            if (!mines.some(mine => mine.row === row && mine.col === col))
                mines.push({ row, col });
        }
        return mines;
    }
    

    /**
     * Función para manejar clics en las celdas
     * @param {Event} event El evento de clic del mouse.
     */
    function cellClick(event) {
        if (gameOver) 
            return false;
            
        const target = event.target;
        if (!target.classList.contains('cell') || target.classList.contains('revealed'))
            return false;

        const row = parseInt(target.dataset.row);
        const col = parseInt(target.dataset.col);

        if (target.classList.contains('mine')) {
            revealBoard();
            target.classList.add('revealed', 'exploded');
            gameOver = true;
            alert('¡Has perdido!');
        } else {
            const minesAround = countMinesAround(row, col);
            if (minesAround === 0)
                revealEmptyCells(row, col);
            else
                target.textContent = minesAround;
            target.classList.add('revealed');
        }

        if (document.querySelectorAll('.cell:not(.revealed)').length === totalMines) {
            gameOver = true;
            alert('¡Has ganado!');
        }
    }

    /**
     * Función para contar el número de minas alrededor de una celda específica en el tablero.
     * @param {number} row El índice de fila de la celda.
     * @param {number} col El índice de columna de la celda.
     * @returns {number} El número de minas alrededor de la celda.
     */
    function countMinesAround(row, col) {
        let count = 0;
        for (let i = row - 1; i <= row + 1; i++) {
            for (let j = col - 1; j <= col + 1; j++) {
                if (i >= 0 && i < rows && j >= 0 && j < cols) {
                    if (document.querySelector(`.cell[data-row='${i}'][data-col='${j}']`).classList.contains('mine')) {
                        count++;
                    }
                }
            }
        }
        return count;
    }

    /**
     * Función para revelar las celdas vacías adyacentes a una celda vacía en el tablero.
     * @param {number} row El índice de fila de la celda vacía.
     * @param {number} col El índice de columna de la celda vacía.
     */
    function revealEmptyCells(row, col) {
        const visited = new Set();
        const queue = [{ row, col }];

        while (queue.length > 0) {
            const { row, col } = queue.shift();
            const cell = document.querySelector(`.cell[data-row='${row}'][data-col='${col}']`);
            if (!visited.has(`${row},${col}`)) {
                visited.add(`${row},${col}`);
                const minesAround = countMinesAround(row, col);
                if (minesAround === 0) {
                    cell.classList.add('revealed');
                    for (let i = row - 1; i <= row + 1; i++) {
                        for (let j = col - 1; j <= col + 1; j++) {
                            if (i >= 0 && i < rows && j >= 0 && j < cols && !(i === row && j === col)) {
                                queue.push({ row: i, col: j });
                            }
                        }
                    }
                } else {
                    cell.textContent = minesAround;
                    cell.classList.add('revealed');
                }
            }
        }
    }

    /**
     * Función para revelar todas las celdas del tablero cuando se pierde el juego.
     */
    function revealBoard() {
        const cells = document.querySelectorAll('.cell');
        cells.forEach(cell => {
            if (!cell.classList.contains('revealed')) {
                cell.classList.add('revealed');
                if (cell.classList.contains('mine')) {
                    cell.textContent = '💣';
                } else {
                    const row = parseInt(cell.dataset.row);
                    const col = parseInt(cell.dataset.col);
                    const minesAround = countMinesAround(row, col);
                    cell.textContent = minesAround > 0 ? minesAround : '';
                }
            }
        });
    }
    
    /**
     * Función para reiniciar el juego.
     */
    function restartGame() {
        gameOver = false;
        initializeBoard();
    }

    // Asociar evento clic al botón de reinicio
    restartButton.addEventListener('click', restartGame);

    // Inicializar el tablero al cargar la página
    initializeBoard();
});

