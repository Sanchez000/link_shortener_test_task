FROM php:8.0-fpm-alpine
ENV TZ=Europe/Kiev
WORKDIR "/application"

RUN apk --no-cache add \
   wget \
   curl \
   php8-pdo_pgsql \
   php8-pecl-redis \
  && docker-php-ext-enable /usr/lib/php8/modules/pdo_pgsql.so \
  /usr/lib/php8/modules/igbinary.so \
  /usr/lib/php8/modules/redis.so \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer