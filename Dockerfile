FROM mediawiki:1.32 AS upstream

FROM alpine:latest AS runtime
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
    nginx \
    php7-ctype \
    php7-curl \
    php7-dom \
    php7-fileinfo \
    php7-fpm \
    php7-iconv \
    php7-mbstring \
    php7-mysqli \
    php7-intl \
    php7-opcache \
    php7-pecl-apcu \
    php7-session \
    php7-simplexml \
    php7-tokenizer \
    php7-xml \
    php7-xmlreader \
    php7-xmlwriter \
    supervisor \
  && git clone --branch 5.4 --depth=1 https://github.com/wikimedia/mediawiki-extensions-PluggableAuth.git ${APP_ROOT}/extensions/PluggableAuth \
  && git clone --branch 5.1 --depth=1 https://github.com/wikimedia/mediawiki-extensions-OpenIDConnect.git ${APP_ROOT}/extensions/OpenIDConnect \
  && git clone https://github.com/wikimedia/mediawiki-extensions-ParserFunctions.git ${APP_ROOT}/extensions/ParserFunctions \
  && git clone --branch REL1_32 --depth=1 https://github.com/wikimedia/mediawiki-extensions-MobileFrontend.git ${APP_ROOT}/extensions/MobileFrontend \
  && git clone --depth=1 https://github.com/SemanticMediaWiki/SemanticMediaWiki.git ${APP_ROOT}/extensions/SemanticMediaWiki \
  && git clone --depth=1 https://github.com/wikimedia/mediawiki-extensions-RandomInCategory.git ${APP_ROOT}/extensions/RandomInCategory \
  && git clone --branch REL1_32 --depth=1 https://github.com/wikimedia/mediawiki-skins-MinervaNeue.git ${APP_ROOT}/skins/MinervaNeue \
  && mkdir -p /run/nginx /tmp/mediawiki_cache \
  && chown nginx:nginx /tmp/mediawiki_cache \
  && ln -sf /dev/stdout /var/log/nginx/access.log \
  && ln -sf /dev/stderr /var/log/nginx/error.log \
  && ln -sf /dev/stderr /var/log/php7/error.log \
  # Illustrator files are often made PDF-compatible
  && sed -i "s:application/pdf pdf:application/pdf ai pdf:" includes/libs/mime/mime.types

COPY app/composer.local.json ${APP_ROOT}/
RUN composer update --no-interaction --no-dev

COPY app/LocalSettings.php ${APP_ROOT}/
COPY app/logo.svg ${APP_ROOT}/resources/assets/
COPY etc/php.ini /etc/php7/conf.d/99_custom.ini
COPY etc/php-fpm-www.conf /etc/php7/php-fpm.d/www.conf
COPY etc/nginx.conf /etc/nginx/conf.d/default.conf
COPY etc/supervisord.conf /etc/supervisord.conf

# Run semantic wiki upgrade
RUN php extensions/SemanticMediaWiki/maintenance/setupStore.php

EXPOSE 80
CMD ["supervisord"]
