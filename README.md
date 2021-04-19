
# DrinklyAPI

## Build Setup

```
# Clone project
git clone https://github.com/appoline33/code_sprint_api.git api

# go to api folder
cd /api

# start docker
./vendor/bin/sail up -d

# install dependencies
composer install

# generate secret key
php artisan key:generate

# instantiate the database
php artisan migrate

# seed the dataabse
php artisan db:seed
```

