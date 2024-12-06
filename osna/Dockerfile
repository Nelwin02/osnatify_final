FROM php:8.0-apache

# Install PostgreSQL PDO and pgsql extensions
RUN apt-get update && apt-get install -y libpq-dev libcurl4-openssl-dev && \
    docker-php-ext-install pdo_pgsql pgsql pdo curl

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Create the upload directory and set permissions
RUN mkdir -p /upload && chmod 755 /upload

# Set the working directory
WORKDIR /var/www/html

# Copy your application files to the container
COPY . /var/www/html/

# Install Composer (optional)
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

# Expose port 80
EXPOSE 80

# Add environment variable support
ENV API_KEY=${API_KEY}
