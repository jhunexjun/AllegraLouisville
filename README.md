# AllegraLouisville

Not requirements but currently installed on my dev.
1. node v7.9.0
2. npm n4.2.0
3. Laravel 5.4

### With some basic issues, run any of the following

1. Sometimes /showUsers table isn't dispalying. To fix remove config/javascript.php then run
```
php artisan config:clear
php artisan config:cache
php artisan clear-compiled
```
2. npm run dev (or production) if view isn't updating.


#### For production env. run the following

1. sudo composer dumpautoload -o
2. php artisan config:cach