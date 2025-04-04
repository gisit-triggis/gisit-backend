FROM php:8.4-alpine

RUN apk update && apk add \
    bash \
    git \
    nano \
    htop \
    fish \
    libpq-dev \
    postgresql-client \
    zip \
    wget \
    ffmpeg \
    supervisor

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions

RUN install-php-extensions pdo_pgsql
RUN install-php-extensions pgsql
RUN install-php-extensions bcmath
RUN install-php-extensions pcntl
RUN install-php-extensions swoole
RUN install-php-extensions intl
RUN install-php-extensions grpc
RUN install-php-extensions rdkafka

RUN install-php-extensions @composer

RUN mkdir -p /var/www /var/log/supervisor && \
    chown -R www-data:www-data /var/www /var/log/supervisor

WORKDIR /var/www
COPY . .

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN chown -R www-data:www-data /var/www

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
