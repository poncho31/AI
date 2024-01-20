docker container stop ollama
docker container rm ollama
docker run --gpus all nvidia/cuda:12.3.1-devel-ubi8

docker run -d -v ollama:/root/.ollama -p 11434:11434 --name ollama ollama/ollama
docker exec -it ollama ollama run mistral

REM WSL : MOVE DOCKER DATA FILE
REM wsl --shutdown
REM wsl --export docker-desktop-data k:\docker-data\dockerstktop.tar
REM wsl --unregister docker-desktop-data
REM wsl --import docker-desktop-data k:\docker-data\desktop k:\docker-data\dockerstktop.tar

