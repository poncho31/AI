    @echo off
REM INIT
    REM Lorsque @echo off est utilisé, seules les sorties des commandes seront affichées, et non les commandes elles-mêmes
    REM activer l'expansion différée des variables. Lorsque l'expansion différée est activée, les variables entourées de ! (points d'exclamation) sont évaluées au moment de l'exécution plutôt qu'au moment de l'interprétation du script Cela permet de résoudre certains problèmes liés à la manipulation de variables dans des boucles ou des blocs de code. Par exemple, dans une boucle for, l'expansion différée peut aider à obtenir la valeur mise à jour de la variable à chaque itération
    setlocal enabledelayedexpansion
    REM SET OUTPUT TO UTF-8
    chcp 65001 > nul
    REM SET ROOTPATH
    set "rootPath=%~dp0"

REM INIT USERS PARAMETERS
    set "application=%1"
    set "AI_model=%2"
    REM container
    if not "%3" == "" (
        set "container=%3"
    ) else (
        set "container=THE_CONTAINER"
    )
    REM port
    if not "%4" == "" (
        set "port=%4"
    ) else (
        set "port=11434"
    )
REM INIT APP PARAMETERS


REM RUN
    REM DOCKER SECTION
    if "%application%"=="docker-ai" (
        call :printMessage "Traitement pour %application% %AI_model%" "title"
        REM Vérifier si Docker est installé en utilisant docker -v
        call :CheckApplication "docker"

        if "%AI_model%"=="ollama-mistral" (
            REM Lancement du container "ollama", de l'image "ollama/ollama" sur le port "11434:11434"
            call :runDockerContainer "%container%" "ollama/ollama" "%port%"
            REM Lancement de la commande "ollama run mistral" dans le container "ollama"
            call :executeDockerContainerApp "%container%" "ollama run mistral"

        ) else if "%AI_model%"=="ollama-llava" (

            call :runDockerContainer "%container%" "ollama/ollama" "11435"
            call :executeDockerContainerApp "%container%" "ollama run llava"

        ) else if "%AI_model%"=="ollama-mixtral" (

                call :runDockerContainer "%container%" "ollama/ollama" "11437"
                call :executeDockerContainerApp "%container%" "ollama run mixtral"

        ) else if "%AI_model%" == "stable-diffusion" (
            REM https://github.com/AbdBarho/stable-diffusion-webui-docker
            set "appPath=!rootPath!packages\stable_diffusion\stable-diffusion-webui-docker\"
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

        ) else if "%AI_model%" == "docker-simple-example" (
            REM Ollama mistral via docker
            docker run -d -v ollama:/root/.ollama -p 11434:11434 --name ollama ollama/ollama
            docker exec -it ollama ollama run mistral

            REM Docker container
            docker container stop ollamaContainer
            docker container rm ollamaContainer

            REM GPU all
            nvidi-smi
            docker run --gpus all nvidia/cuda:12.3.1-devel-ubi8
        )

    REM WSL SECTION
    ) else if ("%application%" == "wsl")(

        if "%AI_model%"=="ollama-mistral" (
            wsl ollama run mistral

        ) else if "%AI_model%"=="ollama-llava" (
            wsl ollama run llava

        ) else if "%AI_models%"=="shutdown" (
            wsl --shutdown

        ) else if "%AI_models%"=="export-docker-desktop-data" (
            wsl --export docker-desktop-data k:\docker-data\dockerstktop.tar
            wsl --unregister docker-desktop-data
            wsl --import docker-desktop-data k:\docker-data\desktop k:\docker-data\dockerstktop.tar
        )

    ) else (
        call :printMessage "Unrecognized application : %application%"
    )

goto :eof


REM FUNCTIONS

:CheckApplication
    REM PARAMETERS
    set "appName=%~1"
    set "message="

    REM RUN CHECK
    for /f %%i in ('where !appName! 2^>nul') do set "appPath=%%i"
    if not defined appPath (
        set "message=!appName! n'est pas installé. Veuillez le télécharger et l'installer."
    ) else (
        set "message=!appName! est installé."
    )
    call :printMessage "!message!"

goto :eof

:runDockerContainer
    REM PARAMETERS
    set "container=%~1"
    set "image=%~2"
    set "port=%~3"

    REM CMD -rm ???
    set "dockerCmd=docker run -it --gpus all -d -v !container!:/root/.!container! -p !port!:!port! --name !container! !image!"
    call :printMessage "!dockerCmd!"

    REM STOP AND RESTART CONTAINER
    docker container stop %container%
    docker container start %container%

    REM RUN CONTAINER
    !dockerCmd!
goto :eof

:removeDockerContainer
    REM PARAMETERS
    set "container=%~1"
    REM CMD
    docker container rm %container%
goto :eof


:executeDockerContainerApp
    REM PARAMETERS
    set "container=%~1"
    set "containerAppExec=%~2"
    set "stopContainer=%~3"

    REM CMD
    set "dockerCmd=docker exec -it !container! !containerAppExec!"
    call :printMessage "!dockerCmd!"

    REM EXECUTE CONTAINER APPLICATION
    !dockerCmd!

    REM END OF CONTAINER APPLICATION
    docker container stop %container%

goto :eof

:printMessage
    REM PARAMETERS
    set "message=%~1"
    set "type=%~2"
    set "color=45"
    set "indent=      "

    REM COLOR STYLE
    if "%type%" == "title" (
        set "color=42"
        set "indent="
    )

    echo %indent%[1;%color%m %message% [0m
goto :eof


:installOllamaAILocally
    set "ai_name=%~1"

    call :printMessage "Installing !ai_name! using Chocolaty..."
    for /f %%i in ('choco install !ai_name! --yes') do set "output=%%i"
    if not errorlevel 1 (
        call :printMessage "!ai_name! installed successfully."
    ) else (
        call :printMessage "Error installing !ai_name! using Chocolaty. Please check the output:"
        echo %output%
    )
goto :eof
