FROM php:8.1-cli

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    zip \
    curl \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

COPY . /app
COPY ./composer.json /app/
COPY ./composer.lock /app/
WORKDIR /app

RUN composer install --no-interaction --prefer-dist \
    && composer dump-autoload

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
