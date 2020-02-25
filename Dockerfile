FROM composer
COPY . /app/
RUN composer install --ignore-platform-reqs
RUN cp .env.example .env
RUN php artisan key:generate
RUN php artisan jwt:secret
EXPOSE 8000