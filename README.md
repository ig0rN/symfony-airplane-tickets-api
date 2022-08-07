# symfony-airplane-tickets-api

## Run Docker

```

docker network create airplane_tickets
docker-compose up -d --force-recreate

```

## Login to container

```

docker exec -it php-api bash

```

## Install dependencies

```

composer install

```



## Fresh DB

```

php bin/console doctrine:database:drop --force;
php bin/console doctrine:database:create;
php bin/console doctrine:schema:update --force;
php bin/console doc:fixtures:load --no-interaction;

```

## code cleanup

```
vendor/bin/php-cs-fixer fix src --rules=@Symfony ;
vendor/bin/php-cs-fixer fix tests --rules=@Symfony ;

```
