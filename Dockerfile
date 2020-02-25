FROM composer
RUN mkdir /app
RUN chown -R 1000:1000 /app
COPY ./* /app
RUN cd /app
RUN composer install
EXPOSE 8000