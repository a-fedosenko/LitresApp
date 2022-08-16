# PHP dependency manager
FROM composer:1.9.3 AS composer

FROM php:7.4-apache

RUN apt-get update \
	&& apt-get install -y libzip-dev \
	&& docker-php-ext-install zip  pdo pdo_mysql mysqli

# Copies dependency manager into PHP image
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

#install packages
RUN apt-get -qq update && apt-get -qq -y install mc \
    git \
    libzip-dev \
    unzip \
    && docker-php-ext-install \
       sockets \
       zip 

RUN composer require predis/predis
RUN composer require ethanhann/redisearch-php

RUN a2enmod rewrite

