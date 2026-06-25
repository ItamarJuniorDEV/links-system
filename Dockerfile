FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
        git curl unzip libzip-dev \
    && docker-php-ext-install zip pdo pdo_sqlite \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && npm ci \
    && npm run build \
    && cp .env.example .env \
    && php artisan key:generate \
    && touch database/database.sqlite

EXPOSE 8000

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
