FROM php:8-fpm-apline3.13

RUN apk add --no-cache postgresql-dev \            
            composer
RUN docker-php-ext-install-j2 pgsql pdo_pqsql

RUN rm -rf /var/cache/apk/* && \
    docker-php-source delete && \
    rm -r /tmp/* /var/cache/* /var/www/html/*

COPY ./www.conf /etc/php8/php-fpm.d