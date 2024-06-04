document.addEventListener("DOMContentLoaded", function() {
    const pacman = document.getElementById("pacman");
    const gameContainer = document.getElementById("game-container");
    const step = 20;    // Tamaño de cada paso
    const monsters = document.querySelectorAll('.monster');
    const cheese = document.getElementById('cheese');
    const gameOverDiv = document.getElementById('game-over');

    let points = 0;
    let gameOver = false;

    document.addEventListener("keydown", function(event) {
        if (gameOver) 
            return; // Si ya se acabó el juego, no hacer nada

        let left = parseInt(pacman.style.left) || 200;
        let top = parseInt(pacman.style.top) || 200;

        switch(event.key) {
            case "ArrowRight":
                left = Math.min(left + step, gameContainer.offsetWidth - pacman.offsetWidth);
                break;
            case "ArrowLeft":
                left = Math.max(left - step, 0);
                break;
            case "ArrowDown":
                top = Math.min(top + step, gameContainer.offsetHeight - pacman.offsetHeight);
                break;
            case "ArrowUp":
                top = Math.max(top - step, 0);
                break;
        }

        pacman.style.left = left + "px";
        pacman.style.top = top + "px";

        // Verificar si Pac-Man ha comido el queso
        const pacmanRect = pacman.getBoundingClientRect();
        const cheeseRect = cheese.getBoundingClientRect();

        if (pacmanRect.left < cheeseRect.right && pacmanRect.right > cheeseRect.left &&
            pacmanRect.top < cheeseRect.bottom && pacmanRect.bottom > cheeseRect.top) {
            cheese.style.display = 'none';
            points++;
            console.log("Puntos:", points);
            generateCheese();
        }

        // Verificar si el monstruo ha atrapado al Pac-Man
        monsters.forEach(function(monster) {
            const monsterRect = monster.getBoundingClientRect();
            if (pacmanRect.left < monsterRect.right && pacmanRect.right > monsterRect.left && pacmanRect.top < monsterRect.bottom && pacmanRect.bottom > monsterRect.top)
                endGame();
        });
    });

    function generateCheese() {
        const maxX = gameContainer.offsetWidth - cheese.offsetWidth;
        const maxY = gameContainer.offsetHeight - cheese.offsetHeight;

        const randomX = Math.floor(Math.random() * maxX);
        const randomY = Math.floor(Math.random() * maxY);

        cheese.style.left = Math.max(randomX, 0) + "px";
        cheese.style.top = Math.max(randomY, 0) + "px";
        cheese.style.display = 'block';
    }

    function endGame() {
        gameOverDiv.style.display = 'block';
        gameOver = true;
    }

    setInterval(function() {
        if (!gameOver) {
            moveMonsters();
        }
    }, 750); // Movimiento del monstruo cada 0.75 segundo

    function moveMonsters() {
        monsters.forEach(function(monster) {
            let monsterLeft = parseInt(monster.style.left) || 100;
            let monsterTop = parseInt(monster.style.top) || 100;
    
            const pacmanRect = pacman.getBoundingClientRect();
            const monsterRect = monster.getBoundingClientRect();
    
            let moveHorizontal = pacmanRect.left - monsterRect.left;
            let moveVertical = pacmanRect.top - monsterRect.top;
    
            if (Math.abs(moveHorizontal) > Math.abs(moveVertical))
                monsterLeft += Math.sign(moveHorizontal) * step;    // Mover horizontalmente hacia el Pac-Man
            else
                monsterTop += Math.sign(moveVertical) * step;       // Mover verticalmente hacia el Pac-Man
    
            monster.style.left = monsterLeft + "px";
            monster.style.top = monsterTop + "px";
    
            // Verificar si el monstruo ha atrapado al Pac-Man
            if (pacmanRect.left < monsterRect.right && pacmanRect.right > monsterRect.left && pacmanRect.top < monsterRect.bottom && pacmanRect.bottom > monsterRect.top)
                endGame();
        });
    }
    
});
