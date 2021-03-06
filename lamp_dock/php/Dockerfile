# apacheとphp7.2がインストールされたwebサーバ
FROM php:7.2-apache 

# 2/26
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 設定ファイルをコンテナにコピー
COPY ./php.ini /usr/local/etc/php/

# vim 及び 各種PHPモジュールのインストール、キャッシュ消去
RUN apt-get update && apt-get install -y \
  vim \
  && docker-php-ext-install pdo_mysql mysqli mbstring exif \
  && apt-get clean