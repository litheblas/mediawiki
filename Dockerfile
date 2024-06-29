FROM mediawiki:1.42 AS upstream

FROM alpine:3.20 AS runtime
ENV LC_ALL=en_US.UTF-8
ENV WWW_ROOT=/app
ENV APP_ROOT=/app/w
COPY --from=upstream --chown=root:root /var/www/html ${APP_ROOT}
WORKDIR ${APP_ROOT}

RUN apk add --no-cache \
    composer \
    diffutils \
    git \
    imagemagick \
    jpeg \
    nginx \
    php82 \
    php82-calendar \
    php82-ctype \
    php82-curl \
    php82-dom \
    php82-fileinfo \
    php82-fpm \
    php82-iconv \
    php82-mbstring \
    php82-mysqli \
    php82-intl \
    php82-opcache \
    php82-pecl-apcu \
    php82-session \
    php82-simplexml \
    php82-tokenizer \
    php82-xml \
    php82-xmlreader \
    php82-xmlwriter \
    supervisor \
  && git clone --branch REL1_41 --depth=1 https://github.com/wikimedia/mediawiki-extensions-PluggableAuth.git ${APP_ROOT}/extensions/PluggableAuth \
  && git clone --branch REL1_41 --depth=1 https://github.com/wikimedia/mediawiki-extensions-OpenIDConnect.git ${APP_ROOT}/extensions/OpenIDConnect \
  && git clone --branch REL1_41 --depth=1 https://github.com/wikimedia/mediawiki-extensions-MobileFrontend.git ${APP_ROOT}/extensions/MobileFrontend \
  && git clone --branch REL1_41 --depth=1 https://github.com/wikimedia/mediawiki-extensions-RandomInCategory.git ${APP_ROOT}/extensions/RandomInCategory \
  && mkdir -p /run/nginx /tmp/mediawiki_cache \
  && chown nginx:nginx /tmp/mediawiki_cache \
  && ln -sf /dev/stdout /var/log/nginx/access.log \
  && ln -sf /dev/stderr /var/log/nginx/error.log \
  && ln -sf /dev/stderr /var/log/php82/error.log

COPY app/composer.local.json ${APP_ROOT}/
RUN composer update --no-interaction --no-dev --ignore-platform-reqs

COPY app/LocalSettings.php ${APP_ROOT}/
COPY app/logo.svg ${APP_ROOT}/resources/assets/
COPY etc/php.ini /etc/php82/conf.d/99_custom.ini
COPY etc/php-fpm-www.conf /etc/php82/php-fpm.d/www.conf
COPY etc/nginx.conf /etc/nginx/http.d/default.conf
COPY etc/supervisord.conf /etc/supervisord.conf

EXPOSE 80
CMD ["supervisord"]