# Menggunakan image PHP + Apache
FROM php:8.1-apache

# Copy semua file ke folder web server
COPY . /var/www/html/

# Aktifkan modul Apache
RUN a2enmod rewrite

# Atur hak akses
RUN chown -R www-data:www-data /var/www/html

# Expose port
EXPOSE 80

# Install mysqli extension
RUN docker-php-ext-install mysqli
