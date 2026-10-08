FROM php:8.2-apache

# Install ekstensi PHP yang sering dipakai (misal: mysqli, pdo_mysql)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Mengaktifkan mod_rewrite Apache (biasanya penting untuk framework/router)
RUN a2enmod rewrite

# Menyalin kode dari folder lokal 'src' ke direktori web Apache
COPY ./src /var/www/html/