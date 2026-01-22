FROM php:8.3-fpm-alpine

# Instala libs necessárias
RUN apk update && apk add --no-cache \
    libzip-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    imagemagick-dev \
    libtool \
    autoconf \
    g++ \
    make \
    git \
    bash \
    unzip \
    icu-dev \
    zlib-dev \
    oniguruma-dev \
    curl-dev

# Instala extensões do PHP
RUN docker-php-ext-install \
    mysqli \
    pdo \
    pdo_mysql \
    xml \
    zip \
    intl \
    opcache \
    gd

# Imagick via source
RUN git clone https://github.com/Imagick/imagick.git && \
    cd imagick && \
    phpize && \
    ./configure && \
    make && \
    make install && \
    docker-php-ext-enable imagick && \
    cd .. && \
    rm -rf imagick

# MongoDB via pecl
RUN pecl install mongodb && docker-php-ext-enable mongodb
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Define diretório do Laravel como root
WORKDIR /usr/share/nginx/html
