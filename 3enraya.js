document.addEventListener('DOMContentLoaded', () => {
    const boardElement = document.getElementById('board');
    const resetButton = document.getElementById('reset');
    let board = Array(9).fill(null);
    const human = 'X';
    const ai = 'O';

    function renderBoard() {
        boardElement.innerHTML = '';
        board.forEach((cell, index) => {
            const cellElement = document.createElement('div');
            cellElement.classList.add('cell');
            cellElement.textContent = cell;
            cellElement.addEventListener('click', () => makeMove(index, human), { once: true });
            boardElement.appendChild(cellElement);
        });
    }

    function makeMove(index, player) {
        if (!board[index]) {
            board[index] = player;
            renderBoard();
            if (checkWin(board, player)) {
                setTimeout(() => alert(`${player} wins!`), 100);
                reset();
            } else if (board.every(cell => cell)) {
                setTimeout(() => alert('Draw!'), 100);
                reset();
            } else {
                if (player === human) {
                    const aiMove = minimax(board, ai).index;
                    makeMove(aiMove, ai);
                }
            }
        }
    }

    function checkWin(board, player) {
        const winPatterns = [
            [0, 1, 2],
            [3, 4, 5],
            [6, 7, 8],
            [0, 3, 6],
            [1, 4, 7],
            [2, 5, 8],
            [0, 4, 8],
            [2, 4, 6],
        ];

        return winPatterns.some(pattern => pattern.every(index => board[index] === player));
    }

    function minimax(newBoard, player) {
        const availSpots = newBoard.reduce((acc, cell, index) => {
            if (!cell) acc.push(index);
            return acc;
        }, []);

        if (checkWin(newBoard, human)) 
            return { score: -10 };
        else if (checkWin(newBoard, ai)) 
            return { score: 10 };
        else if (availSpots.length === 0)
            return { score: 0 };
        
        const moves = [];
        availSpots.forEach(spot => {
            const move = {};
            move.index = spot;
            newBoard[spot] = player;

            if (player === ai)
                move.score = minimax(newBoard, human).score;
            else 
                move.score = minimax(newBoard, ai).score;
            
            newBoard[spot] = null;
            moves.push(move);
        });

        let bestMove;
        if (player === ai) {
            let bestScore = -Infinity;
            moves.forEach(move => {
                if (move.score > bestScore) {
                    bestScore = move.score;
                    bestMove = move;
                }
            });
        } else {
            let bestScore = Infinity;
            moves.forEach(move => {
                if (move.score < bestScore) {
                    bestScore = move.score;
                    bestMove = move;
                }
            });
        }
        return bestMove;
    }

    function reset() {
        board = Array(9).fill(null);
        renderBoard();
    }
    resetButton.addEventListener('click', reset);
    renderBoard();
});