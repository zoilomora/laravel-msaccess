# Laravel ORM for Microsoft Access DB
[![Latest Stable Version](https://poser.pugx.org/zoilomora/laravel-msaccess/v/stable)](https://packagist.org/packages/zoilomora/laravel-msaccess)
[![Total Downloads](https://poser.pugx.org/zoilomora/laravel-msaccess/downloads)](https://packagist.org/packages/zoilomora/laravel-msaccess)
[![Latest Unstable Version](https://poser.pugx.org/zoilomora/laravel-msaccess/v/unstable)](https://packagist.org/packages/zoilomora/laravel-msaccess)
[![License](https://poser.pugx.org/zoilomora/laravel-msaccess/license)](https://packagist.org/packages/zoilomora/laravel-msaccess)
[![composer.lock](https://poser.pugx.org/zoilomora/laravel-msaccess/composerlock)](https://packagist.org/packages/zoilomora/laravel-msaccess)

This package helps you to manage **Microsoft Access DB** by **ODBC Connection**
with the integrated [Laravel](https://github.com/laravel/laravel) ORM.

## Installation
1) Install via composer
```
composer require zoilomora/laravel-msaccess
```

2) Add Service Provider to `config/app.php` in `providers` section:
```php
\ZoiloMora\AccessServiceProvider::class,
```

3) Create a **DSN** with the connection to the database.

4) Add connection to `config/database.php` in `connections` section:
```php 
'access' => [
    'driver' => 'pdo_access',
    'connection_string' => 'dsn={namedsn}',
    'username' => '',
    'password' => '',
    'table_prefix' => '',
]
```

5) Replace `{namedsn}` with the **name of DSN**.

## Connect model with the connection
1) In the model class add the `$connection` variable like this:
```php 
protected $connection = 'access';
```

## License
Licensed under the [MIT license](http://opensource.org/licenses/MIT)

Read [LICENSE](LICENSE) for more information