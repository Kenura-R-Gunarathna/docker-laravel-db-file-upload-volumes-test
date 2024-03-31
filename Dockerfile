# Use the official PHP image as base
FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql mbstring zip exif pcntl bcmath opcache

# Set working directory
WORKDIR /var/www

# Copy composer.lock and composer.json
COPY composer.lock composer.json ./

# Install dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-scripts --no-autoloader

# Copy existing application directory contents
COPY . .

# Generate autoload files
RUN composer dump-autoload --optimize

# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# Install frontend dependencies and build assets
RUN npm install

# Set permissions for Laravel storage directories
RUN chown -R www-data:www-data /var/www/storage
RUN chmod -R 775 /var/www/storage

# Set permissions for Laravel bootstrap directories
RUN chown -R www-data:www-data /var/www/bootstrap
RUN chmod -R 775 /var/www/bootstrap