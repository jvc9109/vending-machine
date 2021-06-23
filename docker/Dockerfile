FROM composer:2.0 AS composer

FROM ubuntu:20.04

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV DEBIAN_FRONTEND noninteractive

# Install basics
RUN apt update -yqq
RUN apt upgrade -yqq
RUN apt install -y locales tzdata && rm -rf /var/lib/apt/lists/* \
    && localedef -i en_US -c -f UTF-8 -A /usr/share/locale/locale.alias en_US.UTF-8
ENV LC_ALL en_US.UTF-8
RUN apt-get update && apt-get install -y build-essential software-properties-common acl wget curl logrotate unzip

# Install PHP
RUN add-apt-repository ppa:ondrej/php && add-apt-repository ppa:ondrej/apache2 && apt update -yqq
RUN apt install -y php8.0 php8.0-common php8.0-zip php8.0-gd php8.0-mysql php8.0-mbstring php8.0-bcmath php8.0-apcu php8.0-curl php8.0-intl php8.0-dom


# Install and set-up xdebug for apache (with remote autostart) and cli (without remote autostart, use sfdebug instead)
RUN apt update && apt install -y php-xdebug

COPY etc/infrastructure/php/conf.d/xdebug.ini /etc/php/8.0/mods-available/xdebug.ini

COPY ./run.sh /home/
RUN chmod +x /home/run.sh

COPY aliases /root/.bash_aliases
# Set workdir
WORKDIR /app

# Set Timezone
ENV TZ "Europe/Madrid"
RUN ln -fs /usr/share/zoneinfo/$TZ /etc/localtime \
    && dpkg-reconfigure -f noninteractive tzdata
