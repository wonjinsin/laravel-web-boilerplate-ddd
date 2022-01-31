FROM bitnami/php-fpm:8.0.15
ARG DEBIAN_FRONTEND=noninteractive
WORKDIR /var/www/html
COPY ./ .
RUN apt-get update \
    && apt-get -y --no-install-recommends install vim tzdata wget \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
RUN composer install

RUN mkdir -p bootstrap/cache \
    && chown -R www-data:www-data bootstrap/cache \
    && mkdir -p storage/logs \
    && mkdir -p storage/framework/cache \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && chown -R www-data:www-data storage \
    && chmod -R 777 storage \
    && chown -R www-data:www-data .

COPY ./phpdocker/php-fpm/www.conf /opt/bitnami/php/etc/php-fpm.d/www.conf
COPY ./phpdocker/php-fpm/overrides.conf /opt/bitnami/php/etc/php-fpm.d/overrides.conf
COPY ./phpdocker/php-fpm/php-ini-overrides.ini /opt/bitnami/php/etc/conf.d/php-ini-overrides.ini

EXPOSE 9000
