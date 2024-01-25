REM https://github.com/AbdBarho/stable-diffusion-webui-docker
if not "%1" == "" (
    set "rootPath=%1"
) else (
    set "rootPath=%~dp0"
)
echo %rootPath%

set "appPath=!rootPath!\stable-diffusion-webui-docker\"
set "stableDiffusionWebuiDockerRepo=https://github.com/AbdBarho/stable-diffusion-webui-docker.git"
REM Install or update git package
git pull !stableDiffusionWebuiDockerRepo!

REM Run docker compose download / update file
cd !appPath!
docker compose --profile download up --build

REM Run comfy ui server + webserver
docker compose --profile comfy up --build
    REM Other possible profile
    REM docker compose --profile invoke up --build
    REM docker compose --profile auto up --build