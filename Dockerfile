# ------------------------------
# Dockerfile profesional para Laravel + Render
# ------------------------------

# Imagen base
FROM php:8.2-apache

# Instalar librerías necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    libbz2-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        gd \
        bz2 \
        curl \
        fileinfo \
        gettext \
        mbstring \
        exif \
        mysqli \
        pdo_mysql \
        pdo_pgsql \
        pdo_sqlite \
        zip \
        opcache

# Habilitar mod_rewrite para Laravel
RUN a2enmod rewrite

# Copiar tu php.ini personalizado
COPY php.ini /usr/local/etc/php/

# Copiar proyecto Laravel
COPY . /var/www/html

# Dar permisos correctos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configurar Apache para apuntar al directorio public de Laravel
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Definir directorio de trabajo
WORKDIR /var/www/html
