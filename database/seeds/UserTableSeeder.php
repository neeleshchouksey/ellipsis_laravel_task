<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table("users")->insert(["email"=>"admin@mailinator.com","password"=>Hash::make(12345678),"name"=>"Master Admin"]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
