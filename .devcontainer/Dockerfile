FROM ubuntu:22.04

ARG WWWGROUP
ARG NODE_VERSION=16

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ >/etc/timezone

RUN apt update
RUN apt install -y curl gpg gnupg2 software-properties-common ca-certificates apt-transport-https lsb-release gosu zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python2
RUN mkdir -p ~/.gnupg
RUN chmod 600 ~/.gnupg
RUN echo "disable-ipv6" >>~/.gnupg/dirmngr.conf
RUN apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys E5267A6C
RUN apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys C300EE8C
RUN add-apt-repository ppa:ondrej/php
RUN apt update
RUN apt install -y php8.2
RUN apt install -y php8.2-cli
RUN apt install -y php8.2-dev
RUN apt install -y php8.2-pgsql
RUN apt install -y php8.2-sqlite3
RUN apt install -y php8.2-gd
RUN apt install -y php8.2-curl
RUN apt install -y php8.2-imap
RUN apt install -y php8.2-mysql
RUN apt install -y php8.2-mbstring
RUN apt install -y php8.2-xml
RUN apt install -y php8.2-zip
RUN apt install -y php8.2-bcmath
RUN apt install -y php8.2-intl
RUN apt install -y php8.2-readline
RUN apt install -y php8.2-ldap
RUN apt install -y php8.2-msgpack
RUN apt install -y php8.2-igbinary
RUN apt install -y php8.2-redis
RUN apt install -y php8.2-swoole
RUN apt install -y php8.2-memcached
RUN apt install -y php8.2-pcov
RUN apt install -y php8.2-xdebug
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
RUN curl -sL https://deb.nodesource.com/setup_$NODE_VERSION.x | bash -
RUN apt install -y nodejs
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" >/etc/apt/sources.list.d/yarn.list
RUN apt update
RUN apt install -y yarn
RUN apt -y autoremove
RUN apt clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.2

RUN groupadd --force -g $WWWGROUP flyhub
RUN useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 flyhub

COPY bin/start-container.sh /usr/local/bin/start-container
COPY configs/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY configs/php.ini /etc/php/8.2/cli/conf.d/99-flyhub.ini
RUN chmod +x /usr/local/bin/start-container

EXPOSE 8000

ENTRYPOINT ["start-container"]
