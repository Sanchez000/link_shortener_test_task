## How to use:

Link shortener - a web application URL shortener to create perfect URLs for your needs.

Customizable parameters for generated short links:
 - Click limit - the maximum number of clicks on the link. 0 = unlimited
 - Link lifetime - set by the user, but no more than 24 hours

 When the link expires, or the clicks limit is exhausted, when you click on a short link, the service redirects to the 404 page

- Copy context from .env.example to .env
- Run docker-compose up -d
- Navigate to php-fpm container by command  - docker-compose exec php-fpm sh
- Inside container run:
    - composer install
    - php artisan migrate 
    - php artisan key:generate

- Exit from container and navigate to http://localhost

p.s. To run tests use the command - php artisan test

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
