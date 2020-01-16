<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name'=>'admin',
            'email'=>'admin@admin.com',
            'bio'=>'bio',
            'type'=>'admin',
            'password'=> Hash::make('123456789')
        ]);
    }
}
