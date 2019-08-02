FROM php:7-fpm

RUN apt-get update \
&& apt-get install -y zlib1g-dev libzip-dev \
&& docker-php-ext-install zip \
&& docker-php-ext-enable zip \

&& apt-get install -y --no-install-recommends libpq-dev supervisor \
&& docker-php-ext-install pdo_pgsql

ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN echo "date.timezone=$TZ" > /usr/local/etc/php/conf.d/timezone.ini

COPY ./entrypoint.sh /entrypoint.sh
RUN chmod a+x /entrypoint.sh


CMD /entrypoint.sh
