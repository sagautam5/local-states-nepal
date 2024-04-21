FROM php:7.1-fpm

RUN apt-get update && apt-get upgrade -y &&\
    apt-get install -y git && \
    apt-get install -y unzip && \
    apt-get install -y vim

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV PATH="${PATH}:/root/.composer/vendor/bin"