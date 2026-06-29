FROM php:8.4-cli

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client

# Extensiones PHP
RUN docker-php-ext-install pdo pdo_mysql zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Instalar Node.js
COPY --from=node:22 /usr/local /usr/local

# Instalar dependencias JS
RUN npm install

# Permisos
RUN chmod -R 775 storage bootstrap/cache

# Puerto de Render
EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000
