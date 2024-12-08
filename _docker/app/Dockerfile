FROM php:8.3-fpm

# Установка зависимостей для PHP и Node.js
RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      git \
      curl \
      libicu-dev \
      gnupg \
      supervisor && \
      docker-php-ext-install pdo_mysql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      docker-php-ext-install intl && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
      # Установка Node.js (LTS версия)
      curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - && \
      apt-get install -y nodejs && \
      npm install -g npm

# Установка расширения Redis
RUN pecl install redis && docker-php-ext-enable redis

# Копирование пользовательского php.ini
COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Копирование конфигурации Supervisor
COPY ./_docker/supervisor/supervisord.conf /etc/supervisor/supervisord.conf


# Установка Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

WORKDIR /var/www

# Установка точки входа
CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]
