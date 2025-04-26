FROM php:8.3-fpm-alpine

# Install system dependencies and PHP extensions
RUN apk add --no-cache --virtual .build-deps \
    git \
    unzip \
    libzip-dev \
    mariadb-connector-c-dev \
    libmemcached-dev \
    autoconf \
    g++ \
    make \
    zlib-dev \
    && apk add --no-cache \
    libmemcached \
    cyrus-sasl-dev \
    libzip \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install pdo pdo_mysql mysqli zip bcmath \
    && apk del .build-deps

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Configure PHP-FPM
RUN echo "pm.max_children = 5" >> /usr/local/etc/php-fpm.d/www.conf \
    && echo "pm.start_servers = 2" >> /usr/local/etc/php-fpm.d/www.conf \
    && echo "pm.min_spare_servers = 1" >> /usr/local/etc/php-fpm.d/www.conf \
    && echo "pm.max_spare_servers = 3" >> /usr/local/etc/php-fpm.d/www.conf

# Create container user with sudo privileges
ARG USERNAME=david
ARG USER_UID=1000
ARG USER_GID=$USER_UID
RUN apk add --no-cache \
    shadow sudo vim lynx \
    && groupadd -g $USER_GID $USERNAME \
    && useradd -u $USER_UID -g $USER_GID -m -s /bin/bash $USERNAME \
    && echo "$USERNAME ALL=(ALL) NOPASSWD:ALL" > /etc/sudoers.d/$USERNAME \
    && chmod 0440 /etc/sudoers.d/$USERNAME \
    && adduser $USERNAME www-data \
    && rm -rf /var/cache/apk/*

USER $USERNAME

EXPOSE 9000

CMD ["php-fpm"]
