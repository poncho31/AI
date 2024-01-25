REM https://github.com/AbdBarho/stable-diffusion-webui-docker
if not "%1" == "" (
    set "rootPath=%1"
) else (
    set "rootPath=%~dp0"
)
set "appPath=!rootPath!\stable-diffusion-webui-docker\"

set "stableDiffusionWebuiDockerRepo=https://github.com/AbdBarho/stable-diffusion-webui-docker.git"
cd !rootPath!
git clone "%stableDiffusionWebuiDockerRepo%"
cd !appPath!
REM git pull !stableDiffusionWebuiDockerRepo!


docker compose --profile download up --build

REM Run comfy ui server + webserver
docker compose --profile comfy up --build
    REM Other possible profile
    REM docker compose --profile invoke up --build
    REM docker compose --profile auto up --build