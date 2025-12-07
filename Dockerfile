FROM php:8.3-fpm

# ARG para UID/GID
ARG UID
ARG GID

# Dependências básicas
RUN apt-get update && apt-get install -y \
    git zip unzip curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libzip-dev libicu-dev nodejs npm \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Instala Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cria usuário igual ao do host
RUN groupadd -g $GID appgroup \
    && useradd -m -u $UID -g $GID appuser

# Diretório de trabalho
WORKDIR /var/www

# Copia arquivos do projeto
COPY . .

# Muda permissões internas necessárias
RUN chown -R appuser:appgroup /var/www

USER appuser

# Instala dependências Laravel
RUN composer install && npm install && npm run build

EXPOSE 9000
CMD ["php-fpm"]
