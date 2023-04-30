#!/bin/bash

npm install
npm run build

composer install --ignore-platform-reqs
cp .env.example .env
./vendor/laravel/sail/bin/sail up -d
./vendor/laravel/sail/bin/sail artisan key:generate
./vendor/laravel/sail/bin/sail artisan migrate
