# Base image
FROM php:8.0-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Enable Apache modules
RUN a2enmod rewrite

# Set the working directory to the root of the project
WORKDIR /var/www/html

# Copy the entire project to the container
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configure Apache to allow .htaccess
COPY ./.htaccess /var/www/html/.htaccess
RUN echo "<Directory /var/www/html/>
    AllowOverride All
</Directory>" >> /etc/apache2/apache2.conf

# Expose port 80
EXPOSE 80
