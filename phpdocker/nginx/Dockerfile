FROM nginx:alpine
WORKDIR "/application"

COPY ./public /application/public
COPY ./phpdocker/nginx/nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80