FROM composer
RUN mkdir /laravel
RUN chown -R 1000:1000 /laravel
COPY ./* /laravel
RUN cd /laravel
RUN composer install
EXPOSE 8000