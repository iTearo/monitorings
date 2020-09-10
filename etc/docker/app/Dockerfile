# STAGE: Build php-fpm image
FROM php:7.4-fpm-alpine3.11

ARG NPROC=1

# Ext toggle
ARG WITH_XDEBUG=0
ARG WITH_COMPOSER=1
ARG WITH_SUPERVISORD=0

# Ext versions
ARG APCU_VERSION=5.1.18
ARG ZIP_VERSION=1.19.0
ARG XDEBUG_VERSION=2.9.6
ARG COMPOSER_VERSION=1.10.13

# Composer
ENV COMPOSER_ALLOW_SUPERUSER 0
ENV COMPOSER_HOME /composer

# FPM
ENV FPM_PM dynamic
ENV FPM_PM_MAX_CHILDREN 5
ENV FPM_PM_START_SERVERS 2
ENV FPM_PM_MIN_SPARE_SERVERS 1
ENV FPM_PM_MAX_SPARE_SERVERS 3
ENV FPM_PM_PROCESS_IDLE_TIMEOUT 10s
ENV FPM_PM_MAX_REQUESTS 0
ENV FPM_PM_STATUS_PATH /fpm-status
ENV FPM_REQUEST_TERMINATE_TIMEOUT 0
ENV FPM_CATCH_WORKERS_OUTPUT ''

# Supervisor
ENV WORKER_NUMPROCS 1

RUN set -x; echo "https://mirror.yandex.ru/mirrors/alpine/v3.11/main/" >> /etc/apk/repositories \
    && apk update \
    && apk upgrade --update \
    #
    # Install PHP build dependencies as a single virtual package to remove it after all
    #
    && apk add --progress --virtual .phpize-deps $PHPIZE_DEPS libtool \
    #
    # Intl
    #
    && apk add --progress icu-dev \
    && docker-php-ext-install -j${NPROC} intl \
    #
    # Zip
    #
    && apk add --progress libzip-dev \
    && pecl install zip-${ZIP_VERSION} \
    && docker-php-ext-enable --ini-name 20-zip.ini zip \
    #
    # PDO & PostgreSQL & MySQL (Sphinx)
    #
    && apk add --progress postgresql-dev \
    && docker-php-ext-install -j${NPROC} pdo pdo_mysql \
    #
    # Opcache
    #
    && docker-php-ext-install -j${NPROC} opcache \
    #
    # APCU
    #
    && pecl install apcu-${APCU_VERSION} \
    && docker-php-ext-enable --ini-name 20-apcu.ini apcu \
    #
    # pcntl
    #
    && docker-php-ext-install pcntl \
    #
    # IMAP
    #
    && apk add --progress imap-dev openssl-dev krb5-dev \
    && PHP_OPENSSL=yes docker-php-ext-configure imap --with-imap-ssl --with-kerberos \
    && docker-php-ext-install imap \
    #
    # Xdebug
    #
    && if [[ "${WITH_XDEBUG}" = "1" ]]; then \
        pecl install xdebug-${XDEBUG_VERSION} \
        && docker-php-ext-enable xdebug; \
    fi \
    #
    # supervisor
    #
    && if [[ "${WITH_SUPERVISORD}" = "1" ]]; then \
        apk add -u python3 py3-pip \
        && pip3 install supervisor; \
    fi \
    #
    # Yarn & npm
    #
    && apk add --progress yarn npm \
    #
    # Cleanup
    #
    && apk del --progress .phpize-deps \
    && rm /var/cache/apk/*

# Composer installation
RUN if [[ "${WITH_COMPOSER}" = 1 ]]; then \
        EXPECTED_SIGNATURE="$(wget -q -O - https://composer.github.io/installer.sig)" \
        && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
        && ACTUAL_SIGNATURE="$(php -r "echo hash_file('sha384', 'composer-setup.php');")" \
        && [[ "$EXPECTED_SIGNATURE" = "$ACTUAL_SIGNATURE" ]] \
        && php composer-setup.php --quiet --install-dir=/usr/local/bin --filename=composer --version=${COMPOSER_VERSION} \
        && rm composer-setup.php \
        && chmod 755 /usr/local/bin/composer; \
    fi

# FPM config via ENV
COPY ./fpm-override.conf /usr/local/etc/php-fpm.d/

EXPOSE 9000

WORKDIR /app
