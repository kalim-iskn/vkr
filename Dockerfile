FROM php:8.1.5-fpm-alpine3.14

USER root

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql;

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/bin --filename=composer && \
    composer -V

RUN echo https://dl-2.alpinelinux.org/alpine/edge/community/ >> /etc/apk/repositories
RUN apk --no-cache add shadow

RUN usermod -u 1000 www-data && \
    groupmod -g 1000 www-data

USER www-data

WORKDIR /opt/app

CMD composer install && \
    php artisan migrate && \
    php artisan key:generate && \
    php artisan db:seed && \
    php artisan queue:work && \
    php-fpm
