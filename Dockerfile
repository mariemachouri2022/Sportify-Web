# Use the official PHP image
FROM php:8.0-apache

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable Apache modules
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy Symfony project files
COPY . .

# Install dependencies
RUN composer install --no-interaction

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
