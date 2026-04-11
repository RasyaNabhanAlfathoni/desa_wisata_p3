FROM php:8.2-cli

# Install dependency
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev zip unzip git curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql

# Set working dir
WORKDIR /app

# Copy project
COPY . .

# Install composer
RUN curl -sS https://getcomposer.org/installer | php \
    && php composer.phar install --no-dev --optimize-autoloader

# Permission
RUN chmod -R 775 storage bootstrap/cache

# Optional (biar aman)
RUN php artisan key:generate || true

# Railway port (WAJIB)
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-80}
