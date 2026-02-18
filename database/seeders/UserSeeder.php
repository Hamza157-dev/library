<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admin = [ 'email' => 'a@a.com' , 'password' => '123' , 'type' => 'admin'];
        $customerUser = [ 'email' => 'c@c.com' , 'password' => '123'];
        $customerProfile = ['gender' => 'F','DOB' => '2001-01-31','phone' => '0932555666' , 'name' => 'test customer' ];


        User::create($admin);
        User::create($customerUser)->customer()->create($customerProfile);
    }
}
