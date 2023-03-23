# Define os argumentos
ARG PHP_VERSION=${PHP_VERSION}

# Define a imagem
FROM php:${PHP_VERSION}-apache

# Define as variáveis de ambiente
ENV TZ=${TZ}

# Define a pasta de trabalho
WORKDIR /var/www/html

# Define o timezone do servidor
RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime && echo ${TZ} > /etc/timezone

# Atualiza os pacotes do container
RUN apt-get update -y

# Instala a aplicação unzip
RUN apt-get install -y unzip

# Instala as extensões do PHP
RUN docker-php-ext-install pdo pdo_mysql

# Instala o módulo rewrite no apache
RUN a2enmod rewrite

# Instala o composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer