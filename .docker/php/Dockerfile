# php-fpm-composer-memcache-xdebug:alpine
# php-fpm-symfony:alpine

FROM php:8.1-fpm-alpine as symfony_base

ENV ENV=/etc/profile

WORKDIR /var/www/
VOLUME /var/www/
EXPOSE 9001


COPY . /var/www/

COPY .docker/php/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]

#memcached support

RUN apk update \
	&& apk add --no-cache --virtual .phpize-deps autoconf dpkg-dev dpkg file g++ gcc libc-dev make pkgconf re2c \
	&& apk add --no-cache --virtual .build-deps zlib-dev libmemcached-dev \
	&& apk add --no-cache zlib libmemcached \
	&& printf "\n" | pecl install memcached \
	&& docker-php-ext-enable memcached \
	&& apk del .phpize-deps \
	&& apk del .build-deps

RUN apk add --no-cache libzip icu libxslt libxml2 libpng \
	&& apk add --no-cache --virtual .ext-deps libzip-dev icu-dev libxslt-dev libxml2-dev libpng-dev \
	&& docker-php-ext-install pdo pdo_mysql zip intl xsl soap gd \
	&& apk del .ext-deps

RUN docker-php-ext-enable opcache


RUN rm -rf /var/www/var/cache/* \
    && rm -rf /var/www/public/bundles/* \
    && chmod -R 777 /var/www/var/* \
    && chmod 777 /var/www/public/bundles

ENV APP_ENV=prod
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY ./.docker/php/composer_bin_path.sh /etc/profile.d/

RUN composer install --no-ansi --prefer-dist --no-dev --no-interaction --no-progress  --no-autoloader --no-scripts

FROM symfony_base as symfony_dev

ENV APP_ENV=dev
RUN composer install --no-ansi --prefer-dist --no-interaction --no-progress

RUN apk add --no-cache --virtual .phpize-deps autoconf dpkg-dev dpkg file g++ gcc libc-dev make pkgconf re2c \
	&& pecl install xdebug \
	&& docker-php-ext-enable xdebug \
	&& apk del .phpize-deps

COPY ./.docker/php/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/