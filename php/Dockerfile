FROM php:5.4-fpm
RUN apt-get update && apt-get install -y \
      git \
      wget \
      libzip-dev \
      curl \
      libcurl4-openssl-dev \
      libevent-dev \
      libssl-dev \
      libmcrypt-dev\
      libffi-dev \
      re2c\
      unzip \
      libfreetype6-dev \
      libjpeg62-turbo-dev \
      libmcrypt-dev \
      libpng12-dev

RUN docker-php-ext-install curl
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mcrypt iconv mbstring
RUN docker-php-ext-install iconv mbstring
RUN docker-php-ext-install mbstring

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && docker-php-ext-install  gd
#RUN docker-php-ext-enable curl
#RUN docker-php-ext-enable zip
#RUN docker-php-ext-enable sockets
#RUN docker-php-ext-enable pdo_mysql
#RUN docker-php-ext-enable mcrypt

#RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY composer_install.sh composer_install.sh
RUN sh composer_install.sh && rm composer_install.sh
RUN mv /usr/bin/composer.phar /usr/bin/composer
COPY config/conf.d/* /usr/local/etc/php/conf.d
COPY config/php.ini /usr/local/etc/php.ini
ARG githubToken
RUN composer config -g github-oauth.github.com $githubToken
RUN composer global require "fxp/composer-asset-plugin:^1.2.0"
WORKDIR /app
