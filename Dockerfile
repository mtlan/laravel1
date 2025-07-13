# Set PHP base image with extensions needed
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libpq-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libmagickwand-dev \
    libicu-dev \
    nano \
    libxslt-dev

# 👉 Config GD with JPEG and Freetype support, then install extensions
RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install Laravel dependencies
RUN composer install --optimize-autoloader --no-dev

# ✅ Add PHP upload size configuration
# RUN echo "upload_max_filesize = 2M\npost_max_size = 2M" > /usr/local/etc/php/conf.d/uploads.ini

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Expose port (Railway will use this)
EXPOSE 8000

# Start Laravel using PHP built-in server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
