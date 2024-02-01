<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(50, 20px);
            grid-gap: 1px;
        }

        .grid-item {
            width: 20px;
            height: 20px;
            border: 1px solid #ddd;
            background-color: white;
        }
    </style>
    <title>Jeu de la Vie</title>
</head>
<body>
<div class="grid-container" id="gridContainer"></div>

<script>
    const rows = 30;
    const cols = 50;
    let grid = createEmptyGrid();
    let intervalId;

    function createEmptyGrid() {
        return Array.from({ length: rows }, () => Array(cols).fill(false));
    }

    function initializeGrid() {
        const gridContainer = document.getElementById('gridContainer');

        for (let row = 0; row < rows; row++) {
            for (let col = 0; col < cols; col++) {
                const cell = document.createElement('div');
                cell.className = 'grid-item';
                cell.dataset.row = row;
                cell.dataset.col = col;
                cell.addEventListener('click', toggleCell);
                gridContainer.appendChild(cell);
            }
        }
    }

    function toggleCell() {
        const row = parseInt(this.dataset.row);
        const col = parseInt(this.dataset.col);
        grid[row][col] = !grid[row][col];
        updateGrid();
    }

    function updateGrid() {
        const gridContainer = document.getElementById('gridContainer');

        for (let row = 0; row < rows; row++) {
            for (let col = 0; col < cols; col++) {
                const cell = gridContainer.children[row * cols + col];
                cell.style.backgroundColor = grid[row][col] ? 'black' : 'white';
            }
        }
    }

    function evolve() {
        const newGrid = createEmptyGrid();

        for (let row = 0; row < rows; row++) {
            for (let col = 0; col < cols; col++) {
                const neighbors = countNeighbors(row, col);

                if (grid[row][col]) {
                    newGrid[row][col] = neighbors === 2 || neighbors === 3;
                } else {
                    newGrid[row][col] = neighbors === 3;
                }
            }
        }

        grid = newGrid;
        updateGrid();
    }

    function countNeighbors(row, col) {
        const neighborsOffsets = [
            [-1, -1], [-1, 0], [-1, 1],
            [0, -1],           [0, 1],
            [1, -1], [1, 0], [1, 1],
        ];

        return neighborsOffsets.reduce((acc, [offsetRow, offsetCol]) => {
            const neighborRow = row + offsetRow;
            const neighborCol = col + offsetCol;

            if (neighborRow >= 0 && neighborRow < rows && neighborCol >= 0 && neighborCol < cols) {
                acc += grid[neighborRow][neighborCol] ? 1 : 0;
            }

            return acc;
        }, 0);
    }

    initializeGrid();

    // Fonction pour démarrer l'évolution
    function startEvolution() {
        if (!intervalId) {
            intervalId = setInterval(evolve, 100);
        }
    }

    // Fonction pour arrêter l'évolution
    function stopEvolution() {
        clearInterval(intervalId);
        intervalId = null;
    }

    // Utilisez ces fonctions pour démarrer/arrêter l'évolution
    // Démarrez manuellement ou décommentez la ligne suivante pour démarrer automatiquement
    startEvolution();
</script>

</body>
</html>
