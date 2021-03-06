<?php

use Illuminate\Database\Seeder;
use App\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $token = Str::random(20);

        Admin::create([
        		'name'=>'Administrator',
        		'email'=>'admin@localhost.com',
        		'password'=> '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                //'role'=>'super',
        		'remember_token' => Str::random(10),
                'api_token'=>hash('sha256', 'admin@localhost.com'.$token)
        	]);
        
        $admin = factory(Admin::class, 2)->create();
    }
}
