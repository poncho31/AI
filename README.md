### AI INTEGRATOR :
    GENERATEUR TEXTE / GENERATEUR IMAGE / GENERATEUR VIDEO / LOCAL / API

### 1. Libraries
- #### Docker-desktop
  - windows : https://www.docker.com/products/docker-desktop/

- #### Ollama
  - Intégrateur d'IA multiple : mistral, mixtral, llama2, llava
  - installation automatique via les commandes docker

- #### stabel-diffusion-webui-docker
        https://github.com/AbdBarho/stable-diffusion-webui-docker
  - IA generatrice d'image / video / text to image
  - A installer dans ./packages/stable_diffusion
  - Vue ***confyui*** pour stable-diffusion-webui:
    - https://github.com/comfyanonymous/ComfyUI 
    - sera installé via le package stabel-diffusion et la commande : docker compose --profile comfy up --build

- #### PHP : php-8.3.2-nts
  - https://windows.php.net/downloads/releases/php-8.3.2-nts-Win32-vs16-x64.zip
  - A installer et extraire dans ./packages/php/php-8.3.2-nts

- #### ***Exemples de commandes***
    #### Lancer l'IA mistral
      ./AI.bat docker ollama-mistral ollamaContainer 11434

    - Accès via le terminal directement
    #### Lancer l'IA stable diffusion comfy ui
      - ./AI.bat docker stable-diffusion
    http://localhost:7860/
    - Images stockées : ./packages/stable_diffusion/stable-diffusion-webui-docker/output/comfy

### 3) APIs
   - Mis en place de l'API pour "comfy ui" : voir ***comfyui_api.php***  
   - Mis en place de l'API pour "Ollama" : voir ***ollama_api.php***  

### 4) Web Server (en cours)
   - Installation de php dans ./packages/php
   - Modification du WebServer.bat afin de correspondre à la version de php installée
   - Lancer WebServer.bat pour lancer le serveur. Pointe vers ./public/index.php

### 5) Automatisation des tâches avec l'ia (en cours)
   - ex : Ouvrir netflix et se connecter