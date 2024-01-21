### AI INTEGRATOR :
    GENERATEUR TEXTE / GENERATEUR IMAGE / GENERATEUR VIDEO / LOCAL / API

- ***Docker-desktop*** windows : https://www.docker.com/products/docker-desktop/


- ***Ollama***, intégrateur d'IA multiple : mistral, mixtral, llama2, llava (installation automatique via docker)


- ***stabel-diffusion-webui-docker***, IA generatrice d'image / video / text to image: https://github.com/AbdBarho/stable-diffusion-webui-docker
  - A installer dans ./packages/stable_diffusion
  - Vue ***confyui*** pour stable-diffusion-webui: https://github.com/comfyanonymous/ComfyUI 
    - sera installé via le package stabel-diffusion et la commande : docker compose --profile comfy up --build


- ***PHP : php-8.3.2-nts***
  - https://windows.php.net/downloads/releases/php-8.3.2-nts-Win32-vs16-x64.zip
  - A installer et extraire dans ./packages/php/php-8.3.2-nts

### EXEMPLES DE COMMANDES

1. **Lancer l'IA mistral**

    - ./AI.bat docker-ai ollama-mistral ollamaContainer 11434
   
    - Accès via le terminal directement


2. **Lancer l'IA stable duffusion comfy ui**

   - ./AI.bat docker-ai stable-diffusion

   - http://localhost:7860/
   
   - Images stockées : ./packages/stable_diffusion/stable-diffusion-webui-docker/output/comfy

3. **APIs**

   - En cours ...