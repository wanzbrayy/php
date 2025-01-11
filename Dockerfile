# Menggunakan base image PHP dengan Apache
FROM php:8.2-apache

# Menentukan direktori kerja di dalam container
WORKDIR /var/www/html

# Salin semua file PHP dari direktori lokal ke container
COPY index.php .
COPY success.php .
COPY cancel.php .
COPY functions.php .
COPY config.php .
COPY autoload.php .
COPY endroid-qr-code.php .

# Install dependensi sistem yang diperlukan dan ekstensi PHP untuk curl
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    git \
    unzip \
    && docker-php-ext-install curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Bootstrap dan dependensi frontend
RUN apt-get update && apt-get install -y \
    npm \
    && npm install -g bootstrap \
    && apt-get clean

# Enable Apache mod_rewrite untuk URL rewriting
RUN a2enmod rewrite

# Set the server name to suppress the warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Set port yang akan dibuka di container
EXPOSE 80

# Menjalankan server Apache
CMD ["apache2-foreground"]
