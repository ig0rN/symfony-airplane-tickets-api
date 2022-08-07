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

| HTTP method | Endpoint             | Function           | Post Data                                                     |
|-------------|----------------------|--------------------|---------------------------------------------------------------|
| ---         | ---                  | ---                | ---                                                           |
| POST        | /tickets/create      | Reserve ticket     | 'flightId' - string/required, 'passport' - string/required    |
| POST        | /tickets/cancel      | Cancel reservation | 'ticketId' - string/required                                  |
| POST        | /tickets/change-seat | Change seat number | 'ticketId' - string/required, 'seatNumber' - integer/required |

## cURL

# create ticket

```

curl --location --request POST 'localhost:8080/tickets/create' \
--header 'Authorization: Bearer s3cr3tV@lu3' \
--header 'Content-Type: application/json' \
--data-raw '{
    "flightId": "899f44ee-15fe-11ed-883c-0242ac130003",
    "passport": "test"
}'

```

# cancel ticket

```

curl --location --request POST 'localhost:8080/tickets/cancel' \
--header 'Authorization: Bearer s3cr3tV@lu3' \
--header 'Content-Type: application/json' \
--data-raw '{
    "ticketId": "dde3a914-15fe-11ed-bebb-0242ac130003"
}'

```

# create ticket

```

curl --location --request POST 'localhost:8080/tickets/change-seat' \
--header 'Authorization: Bearer s3cr3tV@lu3' \
--header 'Content-Type: application/json' \
--data-raw '{
    "ticketId": "dde3a914-15fe-11ed-bebb-0242ac130003",
    "seatNumber": 34
}'

```