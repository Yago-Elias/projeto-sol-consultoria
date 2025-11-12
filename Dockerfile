FROM php:8.3-fpm

# Dependências básicas
RUN apt-get update && apt-get install -y \
    git zip unzip curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libzip-dev libicu-dev nodejs npm \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Instala Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Diretório de trabalho
WORKDIR /var/www

# Copia arquivos do projeto
COPY . .

# Instala dependências Laravel
RUN composer install && npm install && npm run build

# Permissões
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
