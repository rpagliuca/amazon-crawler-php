FROM php:7
RUN apt-get update
RUN apt-get install -y iproute2
RUN apt-get install -y tor
RUN docker-php-ext-install pdo && docker-php-ext-enable pdo
RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql
WORKDIR /app/bin
ENTRYPOINT ["/bin/sh", "-c", "cat /etc/issue; bash start-crawlers.sh"]
