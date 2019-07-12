FROM ubuntu:bionic-20190307
RUN apt-get -y upgrade
RUN apt-get -y update

RUN apt-get -y install sudo vim git nano wget 
RUN apt-get -y install apache2
RUN ln -fs /usr/share/zoneinfo/Asia/Seoul /etc/localtime

RUN mkdir -p /run/systemd && echo 'docker' > /run/systemd/container
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV HOSTNAME = "localhost"
ENV DEBIAN_FRONTEND=noninteractive

RUN a2enmod rewrite expires

RUN apt-get -y update  
RUN apt-get install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get install -y php7.3 php-mysql 
RUN apt-get install -y openssh-server
RUN apt-get install -y curl libpcre3-dev gcc make

RUN sed -i 's/Options Indexes FollowSymLinks/Options FollowSymLinks/g' /etc/apache2/apache2.conf
RUN apt-get clean && \
     rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

EXPOSE 80 443 3306
WORKDIR /var/www/html
CMD ["apache2ctl", "-D", "FOREGROUND"]