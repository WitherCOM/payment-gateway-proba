FROM php:8-fpm

RUN apk add php8-bcmath \
            php8-ctype \
            php8-fileinfo \
            php8-json \
            php8-mbstring \
            php8-openssl \
            php8-pdo \
            php8-tokenizer \
            php8-xml \
            php8-pgsql \
            composer

COPY ./www.conf /etc/php8/php-fpm.d
