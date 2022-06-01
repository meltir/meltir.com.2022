FROM meltir/php-fpm

COPY phpmemcachedadmin-1.3.0 /var/www/html/

#RUN docker-php-ext-disable xdebug

RUN echo "error_reporting = 0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

CMD	[ "php", "-S", "[::]:8082", "-t", "/var/www/html/" ]

EXPOSE 8082