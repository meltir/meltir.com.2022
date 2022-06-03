# php-fpm-composer-memcache-xdebug:alpine
# php-fpm-symfony:alpine

FROM php:8.1-fpm-alpine as symfony_base

VOLUME /var/www/

#memcached support

RUN set -x \
	&& apk update \
	&& apk add --no-cache --virtual .phpize-deps autoconf dpkg-dev dpkg file g++ gcc libc-dev make pkgconf re2c \
	&& apk add --no-cache --virtual .build-deps zlib-dev libmemcached-dev \
	&& apk add --no-cache zlib libmemcached \
	&& printf "\n" | pecl install memcached \
	&& docker-php-ext-enable memcached \
	&& apk del .phpize-deps \
	&& apk del .build-deps

	

RUN set -x \
	&& apk add --no-cache libzip icu libxslt libxml2 libpng \
	&& apk add --no-cache --virtual .ext-deps libzip-dev icu-dev libxslt-dev libxml2-dev libpng-dev \
	&& docker-php-ext-install pdo pdo_mysql zip intl xsl soap gd \
	&& apk del .ext-deps

RUN docker-php-ext-enable opcache

RUN set -x \
    && apk add --no-cache git
#
COPY ./www/* .

#RUN set -x \
#    && rm -rf /var/www/var/cache/* \
#    && rm -rf /var/www/public/bundles/* \
#    && chmod -R 777 /var/www/var/* \
#    && chmod 777 /var/www/public/bundles
#

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN set -x \
    && cd /var/www/ \
    && composer install --prefer-dist --no-dev --no-interaction

COPY ./php/composer_bin_path.sh /etc/profile.d/

ENV ENV=/etc/profile

WORKDIR /var/www

EXPOSE 9001

FROM symfony_base as symfony_dev

RUN set -x \
	&& apk add --no-cache --virtual .phpize-deps autoconf dpkg-dev dpkg file g++ gcc libc-dev make pkgconf re2c \
	&& pecl install xdebug \
	&& docker-php-ext-enable xdebug \
	&& apk del .phpize-deps

#COPY docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/


RUN wget https://www.phpdoc.org/phpDocumentor.phar -O /usr/local/bin/phpDocumentor.phar \
    && chmod 755 /usr/local/bin/phpDocumentor.phar

RUN wget https://github.com/phpstan/phpstan/releases/download/0.11.13/phpstan.phar -O /usr/local/bin/phpstan.phar \
    && chmod 755 /usr/local/bin/phpstan.phar

RUN composer global require infection/infection friendsofphp/php-cs-fixer

