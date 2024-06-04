document.addEventListener('DOMContentLoaded', () => {
    const boardElement = document.getElementById('board');
    let board = Array(64).fill(null);
    let currentPlayer = 'black';

    // Initial setup for Othello
    board[27] = 'white';
    board[28] = 'black';
    board[35] = 'black';
    board[36] = 'white';

    function renderBoard() {
        boardElement.innerHTML = '';
        board.forEach((cell2, index) => {
            const cellElement = document.createElement('div');
            cellElement.classList.add('cell2');
            if (cell2) 
                cellElement.classList.add(cell2);
            cellElement.dataset.index = index;
            cellElement.addEventListener('click', handleCellClick);
            boardElement.appendChild(cellElement);
        });
    }

    function handleCellClick(event) {
        const index = parseInt(event.target.dataset.index);
        if (board[index] || !isValidMove(index, currentPlayer)) return;
        makeMove(index, currentPlayer);
        renderBoard();
        if (currentPlayer === 'black') {
            currentPlayer = 'white';
            setTimeout(() => {
                const bestMove = findBestMove(board, 'white');
                if (bestMove !== null) {
                    makeMove(bestMove, 'white');
                    currentPlayer = 'black';
                    renderBoard();
                }
            }, 500);
        }
    }

    function isValidMove(index, player) {
        const directions = [-1, 1, -8, 8, -9, 9, -7, 7];
        const opponent = player === 'black' ? 'white' : 'black';
        let valid = false;

        directions.forEach(direction => {
            let i = index + direction;
            let hasOpponentPieces = false;

            while (i >= 0 && i < 64 && Math.abs(Math.floor(i / 8) - Math.floor((i - direction) / 8)) <= 1) {
                if (board[i] === opponent) 
                    hasOpponentPieces = true;
                else if (board[i] === player) {
                    if (hasOpponentPieces)
                        valid = true;
                    break;
                } else
                    break;
                
                i += direction;
            }
        });
        return valid;
    }

    function makeMove(index, player) {
        const directions = [-1, 1, -8, 8, -9, 9, -7, 7];
        const opponent = player === 'black' ? 'white' : 'black';
        board[index] = player;
        directions.forEach(direction => {
            let i = index + direction;
            const piecesToFlip = [];
            while (i >= 0 && i < 64 && Math.abs(Math.floor(i / 8) - Math.floor((i - direction) / 8)) <= 1) {
                if (board[i] === opponent)
                    piecesToFlip.push(i);
                else if (board[i] === player) {
                    piecesToFlip.forEach(pos => {
                        board[pos] = player;
                    });
                    break;
                } else
                    break;
                i += direction;
            }
        });
    }

    function findBestMove(board, player) {
        const validMoves = [];
        board.forEach((cell2, index) => {
            if (!cell2 && isValidMove(index, player)) {
                validMoves.push(index);
            }
        });
        if (validMoves.length === 0) return null;
        return validMoves.reduce((bestMove, move) => {
            const tempBoard = [...board];
            makeMove(tempBoard, move, player);
            const score = evaluateBoard(tempBoard, player);
            return score > bestMove.score ? { move, score } : bestMove;
        }, { move: null, score: -Infinity }).move;
    }

    function evaluateBoard(board, player) {
        return board.filter(cell2 => cell2 === player).length;
    }

    function getWinner(board) {
        const blackCount = board.filter(cell2 => cell2 === 'black').length;
        const whiteCount = board.filter(cell2 => cell2 === 'white').length;
        return blackCount > whiteCount ? 'black' : 'white';
    }

    renderBoard();
});
