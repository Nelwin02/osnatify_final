FROM php:8.0-apache

# Install PostgreSQL PDO and pgsql extensions
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set permissions for Apache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Copy your PHP files to the container
COPY . /var/www/html
WORKDIR /var/www/html

# Enable error logging to stdout/stderr
RUN echo "ErrorLog /dev/stderr" >> /etc/apache2/apache2.conf \
    && echo "CustomLog /dev/stdout combined" >> /etc/apache2/apache2.conf

# Expose port 80 to be able to access the app
EXPOSE 80

# Restart Apache
CMD ["apache2-foreground"]
