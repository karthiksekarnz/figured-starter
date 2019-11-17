<?php

use Illuminate\Database\Seeder;
use LaraBlog\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $user = factory(User::class)->create([
            'name' => 'Admin Manager',
            'email' => 'admin@figured.com'
        ]);

        User::find($user->id)->assignRole('Admin');
    }
}
