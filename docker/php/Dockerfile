# Use uma imagem base do PHP
FROM php:8.1-fpm

# Defina o diretório de trabalho no contêiner
WORKDIR /var/www

# Remova o diretório HTML padrão do Apache
RUN rm -rf /var/www/html

# Instale dependências necessárias
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    apt-utils \
    libonig-dev \
    gnupg

# Instale extensões do PHP
RUN docker-php-ext-install zip pdo_mysql mbstring exif
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install gd

# Instale a extensão Redis
RUN mkdir -p /usr/src/php/ext/redis; \
    curl -fsSL https://pecl.php.net/get/redis --ipv4 | tar xvz -C "/usr/src/php/ext/redis" --strip 1; \
    docker-php-ext-install redis;

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Adicione um grupo e usuário para o Laravel
RUN groupadd -g 1000 laravel
RUN useradd -u 1000 -ms /bin/bash -g laravel user

# Instale Node.js e npm
RUN curl -fsSL https://deb.nodesource.com/setup_14.x | bash - && \
    apt-get install -y nodejs

# Copie o código da aplicação para o contêiner
COPY --chown=user:laravel . /var/www

# Mude para o usuário criado
USER user

# Exponha a porta 9000 para o PHP-FPM
EXPOSE 9000

# Comando para rodar PHP-FPM
CMD ["php-fpm"]
