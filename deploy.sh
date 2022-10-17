#!/bin/bash

npm install
npm run build

composer install
cp .env.example .env
./vendor/laravel/sail/bin/sail artisan key:generate
./vendor/laravel/sail/bin/sail artisan migrate
./vendor/laravel/sail/bin/sail up


