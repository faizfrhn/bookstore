FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    postgresql

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install fileinfo 
RUN docker-php-ext-install pdo pdo_pgsql

# Set working directory
WORKDIR /var/www

# Copy app contents into directory
ADD . /var/www

USER $user