1) Create Dockerfile for php-cli(Ubuntu+php+db_extentions)
2) Build image and tag it by command:
docker build --no-cache -f phpdocker/php-cli/Dockerfile -t "sanchez000/php-fpm:${project_name}cli" .
3) Create docker-compose file
4) Run docker-compose up -d
exec in container
composer create-project laravel/laravel  --prefer-dist application
5) add nginx service to docker compose file

FROM nginx:alpine
WORKDIR "/application"

COPY ./public /application/public
COPY ./phpdocker/nginx/nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

