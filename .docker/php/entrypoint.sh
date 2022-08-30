#!/usr/bin/env sh

php ./bin/console cache:warmup
php ./bin/console doctrine:migrations:migrate

/usr/local/bin/docker-php-entrypoint