FROM php:7.3-fpm
RUN apt-get update && apt-get -y upgrade
RUN apt-get install gcc
RUN apt-get install g++

#zipを入れるための部分
RUN apt-get install -y zlib1g-dev && apt-get install -y libzip-dev
#pdo_mysqlとzipのインストール
RUN docker-php-ext-install pdo_mysql zip sockets

WORKDIR /var/www/html/