FROM php:7.2-fpm

COPY . /usr/src/myapp
WORKDIR /usr/src/myapp

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
