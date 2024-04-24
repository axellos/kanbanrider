FROM php:8.2-fpm

ARG UID
ARG GID
ARG ENVIRONMENT

ENV UID=${UID} \
  GID=${GID} \
  OCTANE_SERVER='swoole' \
  ENVIRONMENT=${ENVIRONMENT} \
  NODE_VERSION=20

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

COPY ./90-xdebug.ini "${PHP_INI_DIR}/conf.d/"
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN delgroup dialout

RUN groupadd --force -g ${GID} laravel \
  && useradd -ms /bin/bash --no-log-init --no-user-group -g ${GID} -u ${UID} laravel

RUN sed -i "s/user = www-data/user = laravel/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = laravel/g" /usr/local/etc/php-fpm.d/www.conf

RUN docker-php-ext-install pdo pdo_mysql pcntl

RUN apt-get update && apt-get install -y \
    vim \
    git \
    gpg \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

RUN curl curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y nodejs \
    && npm install -g npm \
    && rm -rf /var/lib/apt/lists/*


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

RUN chown -R laravel:laravel /var/www/html /var/log /var/run /etc/supervisor \
  && chmod -R a+rw /var/log /var/run

USER laravel

RUN mkdir -p /var/log/supervisor

COPY --chown=laravel:laravel ./start-container /usr/local/bin/start-container
COPY --chown=laravel:laravel --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN chmod +x /usr/local/bin/start-container

EXPOSE 9000

ENTRYPOINT ["start-container"]
