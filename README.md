# WoodenSword TestTask project.

First of all install 'Docker' & 'docker-compose' for your system!
- https://www.docker.com/get-docker
- https://docs.docker.com/compose

To start the up this app you will need to go through this steps:
1) Cd to this folder and run `docker-compose up -d` to start all containers. (You can use `docker-compose ps` to check their statuses.)
2) Then execute `docker-compose exec php bash` command to access main docker container.
3) Inside container run `composer app:build` to build application itself.

P.S. Dont forget to put this text to your hosts os file: `127.0.0.1   app.local`


