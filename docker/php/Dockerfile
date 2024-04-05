FROM php:8.2-fpm-alpine

ARG UID
ARG GID

ENV UID=${UID} \
  GID=${GID} \
  OCTANE_SERVER=swoole

RUN mkdir -p /var/www/html
RUN mkdir -p /var/log/supervisor

WORKDIR /var/www/html

COPY ./90-xdebug.ini "${PHP_INI_DIR}/conf.d/"
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN delgroup dialout

RUN addgroup -g ${GID} --system laravel
RUN adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel

RUN sed -i "s/user = www-data/user = laravel/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = laravel/g" /usr/local/etc/php-fpm.d/www.conf

RUN docker-php-ext-install pdo pdo_mysql pcntl

RUN apk add --update linux-headers supervisor

RUN mkdir -p /usr/src/php/ext/swoole  \
    && curl -fsSL https://pecl.php.net/get/swoole | tar xvz -C "/usr/src/php/ext/swoole" --strip 1 \
    && docker-php-ext-install swoole

RUN mkdir -p /usr/src/php/ext/redis  \
    && curl -fsSL https://pecl.php.net/get/redis | tar xvz -C "/usr/src/php/ext/redis" --strip 1 \
    && docker-php-ext-install redis

RUN mkdir -p /usr/src/php/ext/xdebug  \
    && curl -fsSL https://pecl.php.net/get/xdebug | tar xvz -C "/usr/src/php/ext/xdebug" --strip 1 \
    && docker-php-ext-install xdebug

RUN docker-php-ext-enable redis swoole xdebug

RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

RUN chown -R laravel:laravel /var/www/html /var/log /var/run \
  && chmod -R a+rw /var/log /var/run

USER laravel

COPY --chown=laravel:laravel ./start-container /usr/local/bin/start-container
COPY --chown=laravel:laravel --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN chmod +x /usr/local/bin/start-container

EXPOSE 9000

ENTRYPOINT ["start-container"]