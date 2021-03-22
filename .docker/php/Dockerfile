FROM php:7.4-fpm-alpine

RUN apk add --no-cache \
    bash \
    sudo

COPY .docker/php/tideways_xhprof-7.4.so /usr/local/lib/php/extensions/no-debug-non-zts-20190902/
COPY .docker/php/tideways-xhprof.ini /usr/local/etc/php/conf.d/40-tideways-xhprof-7.4.ini