FROM php:8.3-apache

# 1. Instalar dependencias del sistema y extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    intl \
    pdo_mysql \
    gd \
    zip \
    opcache

# 2. Activar el módulo rewrite de Apache
RUN a2enmod rewrite

# 3. Copiar nuestra configuración personalizada de VirtualHost
COPY docker/php/vhost.conf /etc/apache2/sites-available/000-default.conf

# 4. Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# 5. Copiar todos los archivos de tu proyecto al contenedor
COPY . .

# 6. Ejecutar Composer para instalar las dependencias
RUN composer install --no-interaction --optimize-autoloader
RUN php bin/console importmap:install --no-interaction

# 7. Dar permisos correctos a Apache sobre los archivos copiados
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/var

