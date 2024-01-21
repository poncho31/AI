<?php
$containerName = 'ollamaContainer';
$imageName = 'ollama/ollama';
$portMap = '11434:11434';
$gpuFlag = ''; // Uncomment this line if your Docker daemon supports GPUs and you have the necessary NVIDIA drivers installed

// Run the container in detached mode with port mapping and GPU flag if applicable
exec('docker run --rm -it --gpus all -d -v ollamaContainer:/root/.ollamaContainer ' .
    $portMap . ' --name ' . $containerName . ' ' . $imageName);

// Get the container ID and store it in a variable for further use
preg_match('/(\S+)/', trim(exec('docker ps -lf name="' . $containerName .'" --quiet --no-trunc')), $matches);
$containerId = $matches[0];

// Interactively attach to the container's stdin, stdout, and stderr using exec()
exec('docker exec -it ' . $containerId . ' bash');
