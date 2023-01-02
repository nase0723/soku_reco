FROM php:8.0-fpm

# install composer
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer

RUN apt-get update \
&& apt-get install -y \
git \
zip \
unzip \
vim

# install Node.js
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs
RUN npm install vue-loader@^15.9.8 --save-dev --legacy-peer-deps
RUN npm install vue-router@3
RUN npm install @vitejs/plugin-vue --save-dev


RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql mysqli 
RUN echo "alias ll='ls -la'" >> ~/.bashrc && . ~/.bashrc
WORKDIR /var/www/html
