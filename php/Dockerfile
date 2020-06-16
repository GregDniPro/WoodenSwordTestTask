FROM php:7.3-fpm

RUN sed -i '/jessie-updates/d' /etc/apt/sources.list  # Now archived

# Link configs
ADD php.ini /usr/local/etc/php/conf.d/php.ini
ADD www.conf /usr/local/etc/php-fpm.d/www.conf

# Usefull utils
RUN apt-get update
RUN apt-get upgrade -y
RUN docker-php-ext-install pdo_mysql mysqli mbstring
RUN apt-get install -y apt-transport-https ca-certificates
RUN apt-get install -y zip unzip
RUN docker-php-ext-install calendar
RUN apt-get install -y exiv2

RUN apt-get update \
 && apt-get install -y \
        unzip \
        libz-dev \
        libmemcached-dev \
        git

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install -j$(nproc) pdo pdo_mysql bcmath pcntl \
    && pecl install memcached redis \
    && docker-php-ext-enable memcached redis

# Cron
RUN apt-get update && apt-get -y install cron
ADD ./cron/crontab /etc/cron.d/app-cron
RUN chmod 0644 /etc/cron.d/app-cron

# Install ZIP
RUN apt-get install libzip-dev -y
RUN apt-get update && docker-php-ext-install zip

# Install GD
RUN apt-get update -y && apt-get install -y sendmail libpng-dev
RUN docker-php-ext-install gd

# Install GMP
RUN apt-get install -y libgmp-dev re2c libmhash-dev libmcrypt-dev file
RUN ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/local/include/
RUN docker-php-ext-configure gmp
RUN docker-php-ext-install gmp

# Install Intl
RUN apt-get install -y zlib1g-dev libicu-dev g++ \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc && \
        composer

# Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get install nodejs -y

# Install yarn
RUN apt-get update && apt-get install -y gnupg2
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
  && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install yarn -y
