# Choisir l'image de base
FROM php:8.1-fpm

# Installer les dépendances nécessaires
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers de l'application Laravel
COPY . .

# Exposer le port
EXPOSE 9000

CMD ["php-fpm"]
