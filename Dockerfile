FROM circleci/php:7.2-fpm

RUN sudo apt update \
    && sudo apt install libbson-dev libmongoc-dev \
    && sudo pecl install mongodb-1.5.5 \
    && sudo docker-php-ext-enable mongodb

WORKDIR /home/circleci

COPY --chown="circleci:circleci" composer* ./
COPY --chown="circleci:circleci" database/ database/
COPY --chown="circleci:circleci" tests/ tests/
RUN composer install -n --prefer-dist
RUN ls -l
COPY --chown="circleci:circleci" . .

CMD ["php", "artisan", "serve", "--host", "0.0.0.0"]
