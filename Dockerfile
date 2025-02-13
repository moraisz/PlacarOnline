FROM php:8.3-fpm

ARG user=placar_online
ARG uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install nodejs
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

COPY . /var/www

# Copy custom configurations PHP
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Copiar configurações do Nginx
COPY docker/nginx/nginx.conf /etc/nginx/conf.d/nginx.conf

# Copy shell file
COPY ./docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

RUN mkdir -p /var/lib/nginx/body && \
    chown -R www-data:www-data /var/lib/nginx && \
    chmod -R 777 /var/lib/nginx

EXPOSE 8080

USER root

# Run shell file
ENTRYPOINT ["/usr/local/bin/start.sh"]
