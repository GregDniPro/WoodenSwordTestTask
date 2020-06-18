# Docker for WoodenSword TestTask project.

First of all install 'Docker' & 'docker-compose' for your system!
- https://www.docker.com/get-docker
- https://docs.docker.com/compose/

Then cd to this folder and run to start all containers `docker-compose up -d`
Then run this commands to get into the main container: `docker-compose exec php bash`.

Next follow steps from app `Readme.md` file!

Additional notes:
- Define hosts in app as container names like: `web`, `mysql`, `redis`

- Use this style for crontab in your system: `*/1 * * * * docker exec -d web php /var/www/html/system/artisan schedule:run`

- Put this text to your hosts os file: `127.0.0.1   app.local`


