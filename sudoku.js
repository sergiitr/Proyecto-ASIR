// Tamaño del tablero de Sudoku
const BOARD_SIZE = 9;
let board = [];

// Función para generar un tablero de Sudoku con algunos números aleatorios en cada fila y columna
function generarSudoku() {
    board = [];
    for (let i = 0; i < BOARD_SIZE; i++) {
        let row = [];
        for (let j = 0; j < BOARD_SIZE; j++) {
            row.push(0); // Inicialmente, todas las celdas están vacías
        }
        board.push(row);
    }

    // Generar números aleatorios en cada fila y columna
    for (let i = 0; i < BOARD_SIZE; i++) {
        for (let j = 0; j < 2; j++) { // Colocamos 2 números en cada fila y columna
            let num, row, col;
            do {
                num = Math.floor(Math.random() * 9) + 1;
                row = Math.floor(Math.random() * BOARD_SIZE);
                col = Math.floor(Math.random() * BOARD_SIZE);
            } while (!esPosicionValida(board, row, col, num)); // Verificamos si el número es válido

            board[row][col] = num;
        }
    }

    // Actualiza el DOM con el nuevo tablero generado
    actualizarTablero(board);
}

// Función para manejar el clic en una celda del tablero
function manejarClicCelda(event) {
    let fila = event.target.dataset.row;
    let columna = event.target.dataset.columna;
    let valor = prompt("Introduce un número (1-9):");
    // Verifica si el valor ingresado es válido y actualiza el tablero si es así
    if (valor !== null && !isNaN(valor) && valor >= 1 && valor <= 9) {
        // Verifica si el valor generado genera un duplicado en la fila, columna o subgrid
        if (esPosicionValida(board, fila, columna, parseInt(valor))) {
            // Actualiza el valor de la celda en el tablero y en el DOM
            board[fila][columna] = parseInt(valor);
            event.target.textContent = valor;
        } else {
            alert("Este número genera un duplicado en la fila, columna o subgrid.");
        }
    }
}

// Función para verificar si un número en una posición específica genera un duplicado en la fila, columna o subgrid
function esPosicionValida(board, fila, columna, num) {
    return esValidoFila(board, fila, num) &&
           esValidoColumna(board, columna, num) &&
           esValidoSubgrid(board, fila, columna, num);
}

// Función para validar si un número es válido en una fila específica
function esValidoFila(board, fila, num) {
    for (let j = 0; j < BOARD_SIZE; j++) {
        if (board[fila][j] === num) {
            return false;
        }
    }
    return true;
}

// Función para validar si un número es válido en una columna específica
function esValidoColumna(board, columna, num) {
    for (let i = 0; i < BOARD_SIZE; i++) {
        if (board[i][columna] === num) {
            return false;
        }
    }
    return true;
}

// Función para validar si un número es válido en un subgrid específico
function esValidoSubgrid(board, fila, columna, num) {
    const subgridSize = Math.sqrt(BOARD_SIZE);
    const startRow = Math.floor(fila / subgridSize) * subgridSize;
    const startCol = Math.floor(columna / subgridSize) * subgridSize;

    for (let i = startRow; i < startRow + subgridSize; i++) {
        for (let j = startCol; j < startCol + subgridSize; j++) {
            if (board[i][j] === num) {
                return false;
            }
        }
    }
    return true;
}

// Función para reiniciar el juego
function resetearJuego() {
    generarSudoku();
}

// Función para actualizar el tablero en el DOM
function actualizarTablero(board) {
    let sudokuContainer = document.getElementById('sudoku-container');
    sudokuContainer.innerHTML = '';

    for (let i = 0; i < BOARD_SIZE; i++) {
        let row = document.createElement('div');
        row.className = 'row';
        for (let j = 0; j < BOARD_SIZE; j++) {
            let cell = document.createElement('div');
            cell.className = 'cell';
            cell.textContent = board[i][j];
            cell.dataset.row = i; // Almacena la fila y la columna como atributos de datos
            cell.dataset.columna = j;
            cell.addEventListener('click', manejarClicCelda); // Agrega el evento de clic a la celda
            row.appendChild(cell);
        }
        sudokuContainer.appendChild(row);
    }
}

// Event listener para el botón de reseteo
document.getElementById('reset-button').addEventListener('click', resetearJuego);

// Llama a la función para generar el Sudoku al cargar la página
window.onload = generarSudoku;