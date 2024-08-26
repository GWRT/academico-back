FROM elrincondeisma/octane:latest

RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=spiralscout/roadrunner:2.4.2 /usr/bin/rr /usr/bin/rr

WORKDIR /app
COPY . .

RUN rm -rf /app/vendor
RUN rm -rf /app/composer.lock
RUN composer install
RUN composer require laravel/octane spiral/roadrunner

# Copiar el archivo .env.example como .env
COPY .env.example .env

# Reemplazar variables de entorno en el .env
RUN sed -i "s/DB_CONNECTION=.*/DB_CONNECTION=${DB_CONNECTION}/" .env && \
    sed -i "s/DB_HOST=.*/DB_HOST=${DB_HOST}/" .env && \
    sed -i "s/DB_PORT=.*/DB_PORT=${DB_PORT}/" .env && \
    sed -i "s/DB_DATABASE=.*/DB_DATABASE=${DB_DATABASE}/" .env && \
    sed -i "s/DB_USERNAME=.*/DB_USERNAME=${DB_USERNAME}/" .env && \
    sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=${DB_PASSWORD}/" .env

RUN mkdir -p /app/storage/logs
RUN php artisan cache:clear
RUN php artisan config:clear
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache
RUN php artisan migrate --force
RUN php artisan octane:install --server="swoole"
RUN php artisan octane:start --server="swoole" --host="0.0.0.0"

EXPOSE 8000
