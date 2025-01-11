FROM php:8.2-apache
WORKDIR /var/www/html
COPY . .
RUN docker-php-ext-install curl
EXPOSE 80
CMD ["apache2-foreground"]
