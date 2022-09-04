#!/usr/bin/env sh

php ./bin/console --no-interaction cache:warmup
php ./bin/console --no-interaction doctrine:migrations:migrate

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
        php-fpm "$@"
fi

php-fpm