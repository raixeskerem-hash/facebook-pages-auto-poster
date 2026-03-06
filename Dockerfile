# Dockerfile for PHP 8.1 FPM

FROM php:8.1-fpm

# Install system dependencies 
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip

# Set working directory
WORKDIR /var/www/html

# Copy application source code
COPY . .

# Expose the port
EXPOSE 9000

# Start php-fpm
CMD ["php-fpm"]