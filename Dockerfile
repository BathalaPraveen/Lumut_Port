FROM php:5.6-apache

# Legacy Debian Stretch archive; package signatures are expired
RUN sed -i \
    -e 's|http://deb.debian.org/debian|http://archive.debian.org/debian|g' \
    -e 's|http://security.debian.org/debian-security|http://archive.debian.org/debian-security|g' \
    -e '/stretch-updates/d' \
    /etc/apt/sources.list \
    && apt-get -o Acquire::Check-Valid-Until=false \
       -o Acquire::AllowInsecureRepositories=true update \
    && apt-get install -y --no-install-recommends \
       --allow-unauthenticated libmcrypt-dev \
    && docker-php-ext-install mcrypt mysqli pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

WORKDIR /var/www/html
