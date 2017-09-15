FROM php:7.1-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y unzip
RUN docker-php-ext-install -j$(nproc) mysqli pdo pdo_mysql

RUN curl https://getcomposer.org/composer.phar > /usr/local/bin/composer && chmod +x /usr/local/bin/composer

RUN curl -O https://wordpress.org/latest.zip \
    && unzip latest.zip \
    && mv wordpress/* .

RUN curl -O https://downloads.wordpress.org/plugin/custom-post-type-ui.1.5.5.zip \
    && unzip custom-post-type-ui.1.5.5.zip -d wp-content/plugins

RUN curl -O https://downloads.wordpress.org/plugin/advanced-custom-fields.4.4.11.zip \
    && unzip advanced-custom-fields.4.4.11.zip -d wp-content/plugins

COPY wp-config.php .

COPY setup.sh .

CMD ["/bin/bash", "setup.sh"]
