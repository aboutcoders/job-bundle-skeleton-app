# job-bundle-skeleton-app


A Symfony project to demonstrate how to configure and use [abc/job-bundle](https://github.com/aboutcoders/job-bundle) Bundle for asynchronous job processing.

### Usage
If you want to use predefined Docker environment you need to install Docker and docker-compose. 

#### Run docker containers
In order to run docker dev environment run `docker-compose up -d`
There will be several containers created:

* php - contains your php-fpm and code 
* nginx - contains your web server and vhost config 
* db - contains your database server 
* myadmin - contains phpmyadmin to access database 

#### Run composer
Run composer install to get dependencies 
`docker-compose exec php composer install`

#### Update database schema
To update database schema simply run: 
`docker-compose exec php bin/console doctrine:schema:update --force`
After successful run you should see new tables in database.

#### Run job processing
* Default job processing
`docker-compose exec php bin/console abc:job:consume default`

* Stop processing on empty queue
`docker-compose exec php bin/console abc:job:consume default --stop-when-empty`

### Test scenario
There is one [Demo job defined](./src/AppBundle/Job/DemoJob.php). To test is you need to perform following steps:
1. Run job processing `docker-compose exec php bin/console abc:job:consume default`
2. Add job to the queue using controller

#### Check job info
You can check job info using REST API
[http://localhost:12380/app_dev.php/api/doc#get--api-jobs](http://localhost:12380/app_dev.php/api/doc#get--api-jobs)

#### Additional info

##### Perform operations on php machine
In order to perform any operations on php machine run `docker-compose exec php bash`
You can find application code at `/var/www/jobdemo`

##### Database
There is MariaDB available and configured for this project

* You can find [PhpMyAdmin](http://localhost:12381/) at `http://localhost:12381/`

##### RestAPI
There is MariaDB available and configured for this project

* You can find [PhpMyAdmin](http://localhost:12380/api/doc) at `http://localhost:12380/api/doc`

#####  Background AbcJobBundle jobs
For background job processing we use [AbcJobBundle](https://github.com/aboutcoders/job-bundle)
* You can start job processing by running: `bin/console abc:job:consume default`. 
* In order to get more details about the command run `bin/console abc:job:consume --help` 
 