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

## API headers

| Key           | Value            | Description           |
|---------------|------------------|-----------------------|
| ---           | ---              | ---                   |
| Authorization | Bearer {token}   | Token you get from us |
| Content-Type  | application/json | JSON data             |


## API endpoints

| HTTP method | Endpoint                  | Function                              | Post Data                                                  |
|-------------|---------------------------|---------------------------------------|------------------------------------------------------------|
| ---         | ---                       | ---                                   | ---                                                        |
| POST        | /tickets                  | Reserve ticket                        | 'flightId' - string/required, 'passport' - string/required |
| GET         | /tickets/{id}/cancel      | Cancel reservation                    | /                                                          |
| PUT         | /tickets/{id}/change-seat | Change seat number                    | 'seatNumber' - integer/required                            |

## cURL

# create ticket

```

curl --location --request POST 'localhost:8080/tickets' \
--header 'Authorization: Bearer s3cr3tV@lu3' \
--header 'Content-Type: application/json' \
--data-raw '{
    "flightId": "899f44ee-15fe-11ed-883c-0242ac1300033",
    "passport": "test"
}'

```

# cancel ticket

```

curl --location --request GET 'localhost:8080/tickets/dde3a914-15fe-11ed-bebb-0242ac130003/cancel' \
--header 'Authorization: Bearer s3cr3tV@lu3' \
--header 'Content-Type: application/json' \
--data-raw ''

```

# change seat

```

curl --location --request PUT 'localhost:8080/tickets/dde3a914-15fe-11ed-bebb-0242ac130003/change-seat' \
--header 'Authorization: Bearer s3cr3tV@lu3' \
--header 'Content-Type: application/json' \
--data-raw '{
    "seatNumber": 55
}'

```