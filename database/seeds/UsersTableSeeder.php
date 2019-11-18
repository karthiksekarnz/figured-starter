<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $user = factory(User::class)->create([
            'name' => 'Admin Manager',
            'email' => 'admin@figured.com'
        ]);

        $userModel = User::find($user->id);
        $userModel->createToken('User personal token');
        $userModel->assignRole('Admin');
    }
}
