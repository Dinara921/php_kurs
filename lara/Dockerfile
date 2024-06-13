FROM php:8.0-fpm

# Устанавливаем системные зависимости
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копируем локальные файлы
WORKDIR /var/www
COPY . .

# Настройка прав доступа
RUN chown -R www-data:www-data /var/www

# Установка зависимостей проекта
RUN composer install

# Очистка кэша
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

EXPOSE 9000
CMD ["php-fpm"]
