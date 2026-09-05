# syntax=docker/dockerfile:1.7
# Production image for the Hostel Management System.
# Three stages: PHP dependencies, front end assets, then the runtime on serversideup/php
# (nginx + php-fpm, unprivileged www-data, health check and Laravel automations built in).
# The two dependency stages build on the builder's own platform: their output is
# architecture independent, so composer and node never run under emulation.

ARG PHP_VERSION=8.4

FROM --platform=$BUILDPLATFORM serversideup/php:${PHP_VERSION}-cli AS vendor
# build stage only: root so copied files can be arranged; the runtime stage runs as www-data
USER root
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --no-scripts --prefer-dist --optimize-autoloader
COPY . .
# package discovery (a composer script) writes bootstrap/cache/packages.php
RUN mkdir -p bootstrap/cache storage/logs storage/framework/cache storage/framework/sessions storage/framework/views \
    && composer dump-autoload --no-dev --optimize --classmap-authoritative

FROM --platform=$BUILDPLATFORM node:22-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund
COPY resources ./resources
COPY public ./public
COPY vite.config.js ./
RUN npm run build

FROM serversideup/php:${PHP_VERSION}-fpm-nginx AS runtime
ENV AUTORUN_ENABLED=true \
    AUTORUN_LARAVEL_MIGRATION=true \
    AUTORUN_LARAVEL_STORAGE_LINK=false \
    PHP_OPCACHE_ENABLE=1 \
    SSL_MODE=off \
    LOG_CHANNEL=stderr
USER root
COPY --chown=www-data:www-data --from=vendor /app /var/www/html
COPY --chown=www-data:www-data --from=assets /app/public/build /var/www/html/public/build
RUN rm -rf /var/www/html/node_modules /var/www/html/tests /var/www/html/docs /var/www/html/screenshots \
    && mkdir -p /run/secrets \
    && chmod -R ug+rwX /var/www/html/storage /var/www/html/bootstrap/cache
USER www-data
