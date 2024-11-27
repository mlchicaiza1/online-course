# Usamos la imagen oficial de PHP 8.2 con Apache
FROM php:8.2-apache

# Establecemos el directorio de trabajo en /var/www/html/public
WORKDIR /var/www/html

# Instalamos dependencias necesarias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    gnupg

# Instalamos Node.js y npm desde NodeSource
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Verificamos las versiones instaladas
RUN node -v && npm -v

# Instalamos extensiones de PHP necesarias para Laravel
RUN docker-php-ext-install pdo pdo_mysql gd mbstring exif pcntl bcmath xml

# Habilitamos el módulo de reescritura de Apache
RUN a2enmod rewrite

# Instalamos Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiamos el contenido del proyecto en el contenedor
COPY . /var/www/html

# Configuramos Apache para que apunte a la carpeta public de Laravel
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Ajustamos permisos para el directorio de Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Exponemos el puerto 80 para el contenedor
EXPOSE 80

# Comando por defecto para iniciar Apache
CMD ["apache2-foreground"]
