<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #maze {
            display: grid;
            grid-template-columns: repeat(10, 50px);
            grid-template-rows: repeat(10, 50px);
            gap: 1px;
        }

        .cell {
            width: 50px;
            height: 50px;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #000;
        }

        .start {
            background-color: #00f;
        }

        .end {
            background-color: #f00;
        }

        .path {
            background-color: #0f0;
        }

        .wall {
            background-color: #000;
        }
    </style>
    <title>Maze Solver</title>
</head>
<body>
<div id="maze"></div>
<button onclick="startTraining()">Start Training</button>
<button onclick="stopTraining()">Stop Training</button>

<script>
    let trainingInterval;
    let currentPosition;
    let path = [];
    let generation = 0;

    document.addEventListener("DOMContentLoaded", function() {
        renderMaze();
    });

    function startTraining() {
        currentPosition = [0, 0];
        path = generateRandomPath();
        generation = 0;

        trainingInterval = setInterval(function() {
            moveIA();
        }, 1000);
    }

    function stopTraining() {
        clearInterval(trainingInterval);
    }

    function renderMaze() {
        const mazeContainer = document.getElementById("maze");
        mazeContainer.innerHTML = "";

        for (let row = 0; row < 10; row++) {
            for (let col = 0; col < 10; col++) {
                const cell = document.createElement("div");
                cell.className = "cell";
                if (row === 0 && col === 0) {
                    cell.classList.add("start");
                } else if (row === 9 && col === 9) {
                    cell.classList.add("end");
                } else if (Math.random() < 0.3) { // Ajout de murs aléatoires
                    cell.classList.add("wall");
                }
                mazeContainer.appendChild(cell);
            }
        }
    }

    function moveIA() {
        const mazeContainer = document.getElementById("maze");
        const currentCell = mazeContainer.children[currentPosition[0] * 10 + currentPosition[1]];

        currentCell.classList.remove("start", "path");
        const nextPosition = getNextPosition(currentPosition, path);

        if (isValidPosition(nextPosition)) {
            currentPosition = nextPosition;

            const newCell = mazeContainer.children[currentPosition[0] * 10 + currentPosition[1]];
            newCell.classList.add("start", "path");

            if (currentPosition[0] === 9 && currentPosition[1] === 9) {
                stopTraining();  // Arrêter l'entraînement une fois arrivé à la fin
                console.log("Solution found in generation: " + generation);
            }

            if (path.length === 0) {
                path = generateRandomPath();
                generation++;
            }
        }
    }

    function getNextPosition(currentPosition, path) {
        const nextMove = path.shift();
        switch (nextMove) {
            case 'UP':
                return [currentPosition[0] - 1, currentPosition[1]];
            case 'DOWN':
                return [currentPosition[0] + 1, currentPosition[1]];
            case 'LEFT':
                return [currentPosition[0], currentPosition[1] - 1];
            case 'RIGHT':
                return [currentPosition[0], currentPosition[1] + 1];
            default:
                return currentPosition;
        }
    }

    function isValidPosition(position) {
        return position[0] >= 0 && position[0] < 10 && position[1] >= 0 && position[1] < 10 &&
            !document.getElementById("maze").children[position[0] * 10 + position[1]].classList.contains("wall");
    }

    function generateRandomPath() {
        const moves = ['UP', 'DOWN', 'LEFT', 'RIGHT'];
        return Array.from({ length: 10 }, () => moves[Math.floor(Math.random() * moves.length)]);
    }
</script>
</body>
</html>
