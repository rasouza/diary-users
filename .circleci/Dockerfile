FROM circleci/php:7.2-cli

RUN sudo apt update \
    && sudo apt install libbson-dev libmongoc-dev \
    && sudo pecl install mongodb-1.5.5 \
    && sudo docker-php-ext-enable mongodb
