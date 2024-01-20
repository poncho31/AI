docker run -it --rm \
  -v k:/docker-test:/project \
  -v E:/Win11_x64/VGA/Nvidia:/opt/nvidia \
  -v /usr/local/cuda:/usr/local/cuda \
  -e DISPLAY=unix@0 \
  -v DISPLAY:unix@0 \
  --gpus all \
  nvidia/cuda:10.2 \
  sh \
    -c " \
      # Install necessary libraries and tools \
      bash <(curl -fsSL https://raw.githubusercontent.com/NVIDIA-Docker/nvidia-docker/master/get-dockerfile.sh)
\
      && docker run --rm nvidia/cuda:10.2 \
        sh -c 'bash <(curl -fsSL
https://raw.githubusercontent.com/NVIDIA/nvidia-container-cl/master/install.sh)' \
        && conda activate \
        && pip install mistral \
        && export PYTHONPATH=$PYTHONPATH:/project \
        && # Your custom Mistral AI code here \
