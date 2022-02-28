FROM php:apache
SHELL ["/bin/bash", "-c"]
RUN apt-get update && docker-php-ext-install pdo_mysql
# PER FireStore
RUN apt-get install zlib1g-dev
RUN pecl install protobuf && docker-php-ext-enable protobuf
RUN pecl install grpc-1.42.0 && docker-php-ext-enable grpc

# RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/fqdn.conf && \ a2enconf fqdn
RUN ln -s ../mods-available/{expires,headers,rewrite}.load /etc/apache2/mods-enabled/
RUN sed -e '/<Directory \/var\/www\/>/,/<\/Directory>/s/AllowOverride None/AllowOverride All/' -i /etc/apache2/apache2.conf
# COPY php.ini /usr/local/etc/php/
EXPOSE 80
