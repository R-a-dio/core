# r/a/dio - core

## Installing

You'll need PHP 7.0+, [Vagrant (latest)](https://vagrantup.com) and [Virtualbox 5.0+](https://virtualbox.org) installed.

1. Add `192.168.10.10 radio.app` to your hosts file.
2. `cp .env.example .env` (change values as needed)
3. `composer install` in the repo root
4. `php vendor/bin/homestead make` to correct paths in Homestead.yaml
5. `vagrant up` and go play games for a bit
6. `vagrant ssh` to get into the VM.

If you want to develop locally you'll need redis, php7, elasticsearch, postgres (or mysql, postgres is preferred) and a webserver.

## Creating + Migrating the database

`php artisan migrate --seed`

To drop and re-seed the database, `php artisan migrate:refresh --seed`

## Building Assets

Literally just run `gulp` from the repo root.
All files in `resources/assets/js` are browserified, so ECMAScript 2015 + ES7 are both available. There's also NPM modules available, too.

## Index management

You can explore all of the r/a/dio search index under the `index` namespace:

    php artisan list --name=index

    index:build
    index:search
    index:drop
    index:update
    index:add

### License

R/a/dio core is licensed under the [MIT license](http://opensource.org/licenses/MIT)