FROM php:7
RUN apt-get update
RUN apt-get install -y iproute2
RUN apt-get install -y tor
RUN docker-php-ext-install pdo && docker-php-ext-enable pdo
RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql
RUN apt-get install -y mysql-client
RUN apt-get install -y wget
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
RUN mv composer.phar /usr/local/bin/composer; chmod a+x /usr/local/bin/composer
RUN apt-get update && apt-get install -y zlib1g-dev libzip-dev
RUN docker-php-ext-install zip && docker-php-ext-enable zip
WORKDIR /app/
ENTRYPOINT ["/bin/sh", "-c", "composer install && cd bin && bash setup.sh && bash start-crawlers.sh"]
