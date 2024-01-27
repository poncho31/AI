powershell $env:PORT=11435; docker-compose up -d
docker start ollamaContainer
docker exec -it ollamaContainer ollama run mistral