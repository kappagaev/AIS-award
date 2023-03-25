FROM ubuntu:22.04

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python2 dnsutils \
    && curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x14aa40ec0831756756d7f66c4f4ea0aae5267a6c' | gpg --dearmor | tee /usr/share/keyrings/ppa_ondrej_php.gpg > /dev/null \
    && echo "deb [signed-by=/usr/share/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu jammy main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y php8.1-cli php8.1-dev \
       php8.1-pgsql php8.1-sqlite3 php8.1-gd php8.1-imagick \
       php8.1-curl \
       php8.1-imap php8.1-mysql php8.1-mbstring \
       php8.1-xml php8.1-zip php8.1-bcmath php8.1-soap \
       php8.1-intl php8.1-readline \
       php8.1-ldap \
       php8.1-msgpack php8.1-igbinary php8.1-redis php8.1-swoole \
       php8.1-memcached php8.1-pcov php8.1-xdebug

RUN curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

RUN curl -sLS https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs
RUN npm install -g npm
RUN apt-get update
RUN apt-get install -y yarn
RUN apt-get install -y mysql-client
RUN apt-get -y autoremove
RUN apt-get clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.1

COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php.ini /etc/php/8.1/cli/conf.d/99-sail.ini
RUN chmod +x /usr/local/bin/start-container

COPY . /var/www/html
COPY .env.example /var/www/html/.env

RUN composer install --no-interaction --no-suggest --no-scripts --prefer-dist
RUN php artisan key:generate
RUN php artisan storage:link
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 777 /var/www/html/storage
RUN chmod +x /var/www/html/artisan
RUN chmod +x /var/www/html/start-container

EXPOSE 8000

CMD ["/bin/bash", "-c", "./artisan migrate;./artisan serve --host=0.0.0.0 --port=$PORT"]

