# SmartFollow - API

[![Creative Commons Attribution - NonCommercial - NoDerivatives 4.0 International license](https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png)](https://creativecommons.org/licenses/by-nc-nd/4.0/)

This software is distributed under the Creative Commons Attribution - Non Commercial - No Derivatives 4.0 International license

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

## Documentation

The documentation for the routes is available at http://path.to.smartfollow.api/docs

To generate it you have to install [apiDoc](http://apidocjs.com/) and run the following command:

```sh
apidoc -i app/ -o public/docs/
```

## Update after a pull

In order to make sure that the installation is up to date after the pull, it is required to execute the following commands:

```sh
composer dumpauto
php artisan config:cache
php artisan migrate
php artisan db:seed --class=UpdateAccessRulesSeeder
php artisan db:seed --class=UpdateAccessRuleGroupSeeder
```
