# Docker for Phonexa TestTask project.

First of all install 'Docker' & 'docker-compose' for your system!
- https://www.docker.com/get-docker
- https://docs.docker.com/compose/

Then cd to this folder and run `docker-compose up -d && docker-compose exec php bash`
Then run this commands in container: `composer install`
Also dont forget to check if .env file exists after all.

Additional notes:
- Define hosts in app as container names like: `web`, `mysql`, `redis`

- Use this style for crontab in your system: `*/1 * * * * docker exec -d web php /var/www/html/system/artisan schedule:run`

- Put this text to your hosts os file: `127.0.0.1   app.local`


