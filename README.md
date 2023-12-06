# Mirko Spino Test for MyCity
## Installation
Clone the repository
```
cd ms-mycity-test
composer install
```
Setup file `.env` with your database user credentials
```
php artisan migrate —seed
npm install
npm run dev
php artisan serve
```
There is a sample database in folder `/.db`. Just import it
At the end of `.env` file you can find standard credentials for a "Super Amdin" and an "Admin" role
