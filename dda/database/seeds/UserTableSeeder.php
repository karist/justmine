<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$roles_user = Role::where('name', 'User')->fist();
    	$roles_author = Role::where('name', 'Author')->fist();
    	$roles_admin = Role::where('name', 'Admin')->fist();

    	$user = new User();
    	$user->name = 'karist';
    	$user->email = '12.7350@gmail.com';
    	$user->password = 'karist';
    	$user->save();
    	$user->roles()->attach($roles_user);

    	$user = new User();
    	$user->name = 'risti';
    	$user->email = 'ristikanugraha@gmail.com';
    	$user->password = 'ristika';
    	$user->save();
    	$user->roles()->attach($roles_author);

    	$user = new User();
    	$user->name = 'admin';
    	$user->email = 'admin@admin.com';
    	$user->password = 'admin';
    	$user->save();
    	$user->roles()->attach($roles_admin);
    }
}
