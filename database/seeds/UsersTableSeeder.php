<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'                 => 1,
                'name'               => 'Admin',
                'email'              => 'admin@admin.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'approved'           => 1,
                'verified'           => 1,
                'verified_at'        => '2020-12-26 00:56:00',
                'verification_token' => '',
                'last_name'          => '',
                'phone'              => '',
                'phone_2'            => '',
                'entity'             => '',
            ],
        ];

        User::insert($users);
    }
}
