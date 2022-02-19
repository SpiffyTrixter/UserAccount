FROM php:8.1-apache AS base
LABEL maintainer="rcimma04@gmail.com"

RUN php -m

RUN apt-get update && apt-get install -y \
        libicu-dev \
        libpq-dev \
        libbz2-dev \
        git \
        libzip-dev \
        unzip \
        mc \
        vim \
        wget \
        libevent-dev \
        librabbitmq-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libxslt-dev \
        libgd-dev \
        libjpeg-dev \
        libxml2-dev \
        msmtp \
        netcat \
    && pecl install -o -f redis \
    && pecl install -o -f apcu \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install iconv gd xsl zip bz2 intl pgsql pdo_pgsql pdo_mysql bcmath opcache mysqli pcntl soap \
    && apt-get clean

RUN php -m

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
RUN ls -l /root/.composer

COPY build/php/init.sh /init.sh

WORKDIR /var/www
RUN chown -R www-data:www-data /var/www
USER www-data


USER root
RUN a2enmod rewrite

COPY build/php/apache.conf /etc/apache2/sites-enabled/000-default.conf
COPY build/php/php.ini /usr/local/etc/php/conf.d/z-custom.ini

FROM base AS php

RUN pecl install xdebug-3.1.3 \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/php.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/php.ini \
    && echo "xdebug.mode=coverage" >> /usr/local/etc/php/php.ini \
    && echo "xdebug.mode=profile" >> /usr/local/etc/php/php.ini \
    && echo "xdebug.mode=develop" >> /usr/local/etc/php/php.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/php.ini \
    && echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/php.ini

USER root
WORKDIR /var/www

CMD ["sh", "/init.sh"]

# Debug image
FROM php AS debug

USER root

RUN docker-php-ext-enable xdebug

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV PATH /root/.composer/vendor/bin:$PATH

USER root
WORKDIR /var/www

CMD ["sh", "/init.sh"]