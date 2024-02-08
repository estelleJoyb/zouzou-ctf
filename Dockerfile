# use of alpine image with php8
FROM php:8.3.2-fpm-alpine

# define working directory
WORKDIR /var/www/html

# update packages and install bash 
RUN apk update && apk add --no-cache bash

# Install php extensions for mysql 
RUN docker-php-ext-install pdo_mysql mysqli

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash \
    && apk add symfony-cli

# copy app files into container
COPY . .

EXPOSE 8000

CMD ["symfony", "server:start", "--port=8000", "--no-tls"]