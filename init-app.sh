#!/usr/bin/env bash

cp .env.example .env
cp .env.example .env.testing
docker-compose exec app composer install
docker-compose exec app yarn
docker exec -it mongodb mongo admin --eval "db.createUser({ user: 'user', pwd: 'pass', roles: [ { role: 'userAdminAnyDatabase', db: 'admin' } ] });"

docker-compose exec app php artisan passport:install
docker-compose exec app php artisan passport:keys
docker-compose exec app php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
docker-compose exec app npm run dev
