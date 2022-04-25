## How to use:

Link shortener - a web application URL shortener to create perfect URLs for your needs.

- Copy context from .env.example to .env
- Run docker-compose up -d
- Navigate to php-fpm container by command  - docker-compose exec php-fpm sh
- Inside container run - php artisan migrate and then php artisan key:generate
- Exit from container and navigate to http://localhost

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
