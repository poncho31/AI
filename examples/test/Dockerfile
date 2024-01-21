RUN a2enmod rewrite && \
    apk update --no-cache && \
    apk add --no-cache curl && \
    docker-php-ext-install xml soap json pdo_mysql && \
    rm -rf /var/lib/apt/lists/*

COPY index.html /var/www/html/index.html
COPY chat.js /var/www/html/chat.js
COPY ollama-chat.php /var/www/html/ollama-chat.php

RUN chmod 755 /var/www/html/ -R && \
    chown -R www-data:www-data /var/www/html/