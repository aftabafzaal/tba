
# Hammerfit.net
Made with ❤️ Laravel 5.

# What is Hammer Fit? 
Hammer Fit is a Network of Fitness Coaches, unifying under the Hammer Fit name and principles, to offer the very best in fitness training and coaching across the US at a very fair and affordable monthly rate. Combined within our ranks, our network hosts hundreds of years of experience assembled to offer to Athletes of all ages and levels a place to seek professional advice and guidance to meet and exceed your fitness goals.


Website: https://hammerfit.net


## Installation Steps

### 1. Require the Package

After taking pull run the following command: 

```bash
composer update
```

### 2. Add the DB Credentials & APP_URL

Next make sure to create a new database and add your database credentials to your .env file:

```
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

You will also want to update your website URL inside of the `APP_URL` variable inside the .env file:

```
APP_URL=http://localhost:8000
```

> Only if you are on Laravel 5.4 will you need to [Add the Service Provider.]

### 3. Run The Migration

Lastly, Run the php artisan migration

```bash
php artisan migrate
```
