#!/usr/bin/env bash
cp .env.example .env
docker-compose build
docker-compose up -d
docker-compose exec app php artisan key:generate
docker-compose exec app composer install
docker-compose exec app php artisan migrate:fresh
docker-compose exec app php artisan db:seed
docker-compose exec app npm install
docker-compose exec app php artisan test
