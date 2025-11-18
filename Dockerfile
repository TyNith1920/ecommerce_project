FROM php:8.2-cli

# Install system dependencies
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

# Copy composer files first (optional but faster for cache)
COPY composer.json composer.lock* ./

# Install PHP dependencies
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php \
    && composer install --no-interaction --prefer-dist --optimize-autoloader

# Copy rest of the app
COPY . .

# Permissions for Laravel
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 80

# Run Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
