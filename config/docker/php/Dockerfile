FROM php:7.4-fpm

MAINTAINER Leo Li <leo.li.dev@outlook.com>

RUN sed -i 's/9000/9001/' /usr/local/etc/php-fpm.d/zz-docker.conf

RUN apt-get update

RUN apt-get install -y \
        git \
        wget \
        nano \
        libicu-dev \
        libzip-dev \
        zlib1g-dev \
        libmcrypt-dev \
        sudo \
        unzip

RUN docker-php-ext-install \
        opcache \
        intl \
        mysqli \
        pdo \
        pdo_mysql \
        zip \
        pcntl \
        bcmath

# Xdebug
RUN pecl install xdebug-2.9.0 && \
    docker-php-ext-enable xdebug

# Composer
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer                               \
    && chmod +x /usr/local/bin/composer

# Install newsest Nodejs, gulp and yarn
RUN apt-get -y install curl dirmngr apt-transport-https lsb-release ca-certificates     \
    && curl -sL https://deb.nodesource.com/setup_12.x | sudo -E bash -                  \
    && apt-get -y install nodejs                                                        \
    && apt-get -y  install gcc g++ make                                                 \
    && node --version                                                                   \
    && npm --version                                                                    \
    && npm install --g gulp-cli                                                         \
    && gulp --version                                                                   \
    && npm install -g yarn                                                              \
    && yarn -v
