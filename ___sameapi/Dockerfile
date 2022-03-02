FROM php:apache
SHELL ["/bin/bash", "-c"]
RUN apt-get update && docker-php-ext-install pdo_mysql
# RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/fqdn.conf && \ a2enconf fqdn
RUN ln -s ../mods-available/{expires,headers,rewrite}.load /etc/apache2/mods-enabled/
RUN sed -e '/<Directory \/var\/www\/>/,/<\/Directory>/s/AllowOverride None/AllowOverride All/' -i /etc/apache2/apache2.conf
# COPY php.ini /usr/local/etc/php/
EXPOSE 80
