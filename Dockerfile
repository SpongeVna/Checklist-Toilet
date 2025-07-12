# Menggunakan image PHP + Apache
FROM php:8.1-apache

# Install ekstensi mysqli (dan dependency)
RUN apt-get update && docker-php-ext-install mysqli

# Aktifkan mod_rewrite di Apache
RUN a2enmod rewrite

# Salin semua file ke dalam container
COPY . /var/www/html/

# Atur hak akses file
RUN chown -R www-data:www-data /var/www/html

# Buka port 80
EXPOSE 80
