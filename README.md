# AllegraLouisville

1. node v7.9.0
2. npm n4.2.0
3. Laravel 5.4

### With some basic issues, run the following

1. config:clear
	config:cache
	php artisan clear-compiled

	php artisan config:clear
2. Remove config/javascript.php then run
	php artisan config:clear && php artisan config:cache && php artisan clear-compiled && php artisan vendor:publish