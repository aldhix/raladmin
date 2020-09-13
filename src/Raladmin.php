<?php
namespace Aldhix\Raladmin;
use Route;

class Raladmin
{
	public static function login()
	{
		Route::post('login','Admin\\Auth\\ApiAdminLoginController@login')->name('api.admin.login');
	}

	public static function logout()
	{
		Route::post('logout','Admin\\Auth\\ApiAdminLoginController@logout')->name('api.admin.logout');
	}

	public static function resource()
	{
		Route::resource('admin', 'ApiAdminController',
			['except' => [
    			'create', 'edit',
			]])->names([
				'index'=>'api.admin.index',
				'create'=>'api.admin.create',
				'store'=>'api.admin.store',
				'show'=>'api.admin.show',
				'edit'=>'api.admin.edit',
				'update'=>'api.admin.update',
				'destroy'=>'api.admin.destroy'
			]);
	}

	public static function profile()
	{
		Route::get('admin/profile','ApiAdminController@profile')->name('api.admin.profile');
		Route::post('admin/profile','ApiAdminController@updateProfile')->name('api.admin.profile.update');
	}
}