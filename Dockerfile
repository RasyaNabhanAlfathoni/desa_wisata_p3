FROM php:8.2-apache

USER root

# Install dependency
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev zip unzip git curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# FIX MPM (WAJIB)
RUN a2dismod mpm_event || true \
 && a2dismod mpm_worker || true \
 && a2enmod mpm_prefork

# Enable apache modules
RUN a2enmod rewrite headers expires deflate mime

# Set working dir
WORKDIR /var/www/html

# Copy project
COPY . .

# Install composer
RUN curl -sS https://getcomposer.org/installer | php \
    && php composer.phar install --no-dev --optimize-autoloader

# Storage link
RUN php artisan storage:link || true

# Permission
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Apache config
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]
