# Official PHP image suitable for Laravel
FROM php:8.2-fpm

# Install system dependencies and PHP extensions (including GD)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip gd

# Set working directory
WORKDIR /var/www/html

# Copy project files into the container
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# Install PHP dependencies for Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set correct permissions
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 80

CMD ["php-fpm"]
