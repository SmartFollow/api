# SmartFollow - API

## Git workflow

1. Do not push on `master`
2. "main" branch is `dev`
3. Create a new `feature` branch for each new feature development
4. Do not merge `feature` branches with `dev`, create a pull request from `feature` branch to `dev`

## Installation

### Cloning the repository

```sh
git clone git@gitlab.com:smartfollow/api.git
cd api
```

### Configuring and installing Laravel setup

```sh
composer install
cp .env.example .env
php artisan key:generate
nano .env
```

Update the database informations and other relevant credentials.

```sh
php artisan migrate
php artisan db:seed
php artisan passport:install
```
