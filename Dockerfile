FROM composer
COPY . /app/
RUN composer install --ignore-platform-reqs
EXPOSE 8000