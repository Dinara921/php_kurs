# Стадия для PHP
FROM php:8.3-fpm

# Копируем конфигурационные файлы
COPY docker.conf /usr/local/etc/php-fpm.d/
COPY .bashrc /root/

# Устанавливаем необходимые зависимости
RUN apt-get update \
    && apt-get install -y build-essential zlib1g-dev default-mysql-client curl gnupg procps vim git unzip libzip-dev libpq-dev \
    && docker-php-ext-install zip pdo_mysql pdo_pgsql pgsql

# Устанавливаем и конфигурируем intl
RUN apt-get install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

# Устанавливаем и конфигурируем gd
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd

# Устанавливаем pcov и включаем его
RUN pecl install pcov && docker-php-ext-enable pcov

# Устанавливаем Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

# Настройки Composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin
RUN composer config --global process-timeout 3600 \
    && composer global require "laravel/installer"

# Устанавливаем рабочую директорию
WORKDIR /var/www/html
