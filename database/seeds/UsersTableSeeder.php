<?php

use Illuminate\Database\Seeder;

use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $users = [
            [
                'name' => 'Vikash Pathak',
                'email' => 'admin@site.com',
                'password' => \Hash::make('123456')
            ]
        ];
        User::insert($users);

        factory(\App\User::class, 10)->create();

    }
}
