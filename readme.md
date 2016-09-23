# SmartFollow - API

## Installation

### Cloning the repository

```sh
git clone git@gitlab.com:smartfollow/api.git
cd api
```

### Configuring Laravel setup

```sh
composer install
cp .env.example .env
php artisan key:generate
nano .env
```

Update the database informations and other relevant credentials.

### Installing Laravel

```sh
php artisan migrate
php artisan db:seed
php artisan passport:install
```
