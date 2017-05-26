# AllegraLouisville

Not requirements but currently installed on my dev.
1. node v7.9.0
2. npm n4.2.0
3. Laravel 5.4

Common Issues

1. 
```
PHP Fatal error:  Uncaught exception 'UnexpectedValueException' with message 'The stream or file "/var/www/pmorcilladev/allegra/storage/logs/laravel.log" could not be opened: failed to open stream: Permission denied' in /var/www/pmorcilladev/allegra/vendor/monolog/monolog/src/Monolog/Handler/StreamHandler.php:107\nStack trace:
```
Fixed by `$ sudo chmod -R 777 <project>/storage`.

### With some basic issues, run any of the following

1. Sometimes /showUsers table isn't dispalying. To fix remove config/javascript.php then run
```
php artisan config:clear
php artisan config:cache
php artisan clear-compiled
```
2. `npm run [dev|production]` if view isn't updating.


#### For production environment run the following

1. sudo composer dumpautoload -o
2. php artisan config:cache


#### Common issues

### Testing

1. With the current packages in composer from #2, I encountered
```
pmorcilla@ubuntu:/var/www/pmorcilladev/allegra$ php artisan dusk
PHPUnit 5.7.20 by Sebastian Bergmann and contributors.

E                                                                   1 / 1 (100%)

Time: 369 ms, Memory: 14.25MB

There was 1 error:

1) Tests\Browser\ExampleTest::testBasicExample
Facebook\WebDriver\Exception\WebDriverCurlException: Curl error thrown for http POST to /session with params: {"desiredCapabilities":{"browserName":"chrome","platform":"ANY"}}

Failed to connect to localhost port 9515: Connection refused
```
To fix,
```
$ wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | sudo apt-key add -
$ sudo sh -c 'echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google-chrome.list'
$ sudo apt-get update && sudo apt-get install -y google-chrome-stable
```
```
$ sudo apt-get install -y xvfb
```
Try to start `./vendor/laravel/dusk/bin/chromedriver-linux --port=8888`. If you have some errors about loading libraries (libnss3.so, libgconf-2.so.4), try this:
```
$ sudo apt-get install -y libnss3-dev libxi6 libgconf-2-4
```
When you see
```
$ ./vendor/laravel/dusk/bin/chromedriver-linux --port=8888
Starting ChromeDriver 2.25.426924 (649f9b868f6783ec9de71c123212b908bf3b232e) on port 8888
Only local connections are allowed.
```
this means ChromeDriver can be started (so SupportsChrome trait should be able to start it too). You can stop this process for now (Ctrl+C).
Run
```
$ Xvfb :0 -screen 0 1280x960x24 &
```
in a separate terminal window.
This is optional
```
Also you may want to add your dev domain in guest's /etc/hosts file:
127.0.0.1 domain.dev.
```
And finally run
```
$ php artisan dusk
```
```
PHPUnit 5.7.20 by Sebastian Bergmann and contributors.

.                                                                   1 / 1 (100%)

Time: 2.34 seconds, Memory: 14.50MB

OK (1 test, 1 assertion)
```

2.
```
devserver@devserver:/var/www/html/advantageConcepts$ sudo composer install
[sudo] password for devserver:
Do not run Composer as root/super user! See https://getcomposer.org/root for details
Loading composer repositories with package information
Installing dependencies (including require-dev) from lock file
Warning: The lock file is not up to date with the latest changes in composer.json. You may be getting outdated dependencies. Run update to update them.
Your requirements could not be resolved to an installable set of packages.

  Problem 1
    - Installation request for facebook/webdriver 1.4.1 -> satisfiable by facebook/webdriver[1.4.1].
    - facebook/webdriver 1.4.1 requires ext-curl * -> the requested PHP extension curl is missing from your system.
  Problem 2
    - facebook/webdriver 1.4.1 requires ext-curl * -> the requested PHP extension curl is missing from your system.
    - laravel/dusk v1.1.0 requires facebook/webdriver ~1.0 -> satisfiable by facebook/webdriver[1.4.1].
    - Installation request for laravel/dusk v1.1.0 -> satisfiable by laravel/dusk[v1.1.0].
```
To fix run `sudo apt-get install <php version>`. <php version> should be php5.6-curl or php7.0-curl.
4. `The bootstrap/cache directory must be present and writable.` To fix:
```
sudo chmod -R 775 bootstrap/cache/
php artisan cache:clear
```
You can try the second one alone.