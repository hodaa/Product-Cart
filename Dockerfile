FROM php:7.4-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update && apt-get install -y  nano
RUN docker-php-ext-install -j$(nproc) pdo_mysql
RUN mkdir /db

RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip

RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

RUN apt-get -y update \
&& apt-get install -y libicu-dev \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl

ADD . /var/www/html
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod 777 /var/www/html/storage

