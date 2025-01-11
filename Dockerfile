# Menggunakan base image PHP dengan Apache
FROM php:8.2-apache

# Set direktori kerja di dalam container
WORKDIR /var/www/html

# Salin semua file PHP dari direktori lokal ke container
COPY index.php .
COPY success.php .
COPY cancel.php .
COPY functions.php .
COPY config.php .
COPY autoload.php .
COPY endroid-qr-code.php .

# Update sistem, instal dependensi, dan instal ekstensi curl
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    && docker-php-ext-install curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Set port yang akan dibuka di container
EXPOSE 80

# Menjalankan server Apache
CMD ["apache2-foreground"]
