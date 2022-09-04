#!/usr/bin/env sh

if [ $# -eq 0 ]; then
    php ./bin/console --no-interaction cache:warmup
    php ./bin/console --no-interaction doctrine:migrations:migrate
    php-fpm
fi

exec docker-php-entrypoint "$@"