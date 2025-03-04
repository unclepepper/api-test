FROM php:8.3-fpm

RUN usermod -u 1000 www-data \
    && groupmod -g 1000 www-data \
    && chown -R www-data:www-data /var/www

WORKDIR /var/www/app

RUN apt-get update \
    && apt-get install apt-utils -y \
    && apt-get install git zip wget \
    nano \
    vim \
    libzip-dev \
    libgmp-dev \
    libffi-dev \
    libssl-dev \
    gnupg2  \
    librabbitmq-dev -y \
    && docker-php-ext-install -j$(nproc) \
    sockets \
    zip \
    gmp \
    pcntl \
    bcmath \
    ffi \
    && docker-php-source delete \
    && apt-get autoremove --purge -y && apt-get autoclean -y && apt-get clean -y

RUN apt-get install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql pgsql

#RUN docker-php-ext-configure opcache \
#    && docker-php-ext-install opcache

#ENV COMPOSER_ALLOW_SUPERUSER 1

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data


RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --version="2.8.1" --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

