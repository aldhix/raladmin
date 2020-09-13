# Raladmin
Rest Api Laravel Admin Resource dan Login
## Use
- Laravel 7

## Install
### Download
Pada terimnal :

    composer require laravel/ui:^2.4
    composer require aldhix/raladmin

### Config App
Pada file `\config\app.php` :

    'providers' => [
	    .....
	    Aldhix\Raladmin\ServiceProvider::class,
    ]
    
    'aliases' => [
	    .....
	    'Raladmin'=>Aldhix\Raladmin\Raladmin::class,
    ]

### Publish
Pada terminal :

`php artisan vendor:publish --provider=Aldhix\Raladmin\ServiceProvider`

### Seeder
Pastikan sudah setting database dilaravel, pada file `\database\seeds\DatabaseSeeder.php`: 

    public function run()
    {
	    $this->call( AdminSeeder::class );
    }

### Config Auth
Pada file `\config\auth.php` :

    'guards' => [
	    .....
	    'admin' => [
	    'driver' => 'session',
	    'provider' => 'admins',
	    ],
	    'apiadmin' => [
		    'driver' => 'token',
		    'provider' => 'admins',
		    'hash' => false,
	    ],
    ],
    
    'providers' => [
	    .....
	    'admins' => [
		    'driver' => 'eloquent',
		    'model' => App\Admin::class,
	    ],
    ],

### Migration
Pada terminal :

    composer dump-autoload
    php artisan migrate
    php artisan db:seed


### Header
Middeware `auth:apiadmin` menggunakan athorization header bearer :

    Authorization : Bearer $token 
    X-Requested-With : XMLHttpRequest

## Fitur

Pada `Class Raladmin` terdapat route  :

    Raladmin::login();
    Raladmin::logout();
    Raladmin::resouce();
    Raladmin::profile();

Route Api 

| Method    | URI                     | Name                     |
|-----------|-------------------------|--------------------------|
| GET|HEAD  | api/admin/admin         | api.admin.index          |
| POST      | api/admin/admin         | api.admin.store          |
| GET|HEAD  | api/admin/admin/profile | api.admin.profile        |
| POST      | api/admin/admin/profile | api.admin.profile.update |
| GET|HEAD  | api/admin/admin/{admin} | api.admin.show           |
| PUT|PATCH | api/admin/admin/{admin} | api.admin.update         |
| DELETE    | api/admin/admin/{admin} | api.admin.destroy        |
| POST      | api/admin/login         | api.admin.login          |
| POST      | api/admin/logout        | api.admin.logout         |
