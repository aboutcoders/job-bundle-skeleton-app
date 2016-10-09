# See https://github.com/docker-library/php/blob/4677ca134fe48d20c820a19becb99198824d78e3/7.0/fpm/Dockerfile
FROM php:7.0-fpm

RUN apt-get update && apt-get install -y \
    git \
    libmcrypt-dev \
    ant \
    unzip \
    libssl-dev \
    libxml2-dev

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Berlin /etc/localtime
RUN "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring xml bcmath

# Enable and configure xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# Enable and configure mcrypt
RUN docker-php-ext-install -j$(nproc) iconv mcrypt

RUN usermod -u 1000 www-data

WORKDIR /var/www/jobdemo