<?php

namespace Tests\Traits;

use Laravel\Passport\ClientRepository;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Faker\Factory as Faker;
use DateTime;

trait InteractsWithPassport
{
    protected $headers = [];
    protected $scopes = [];
    protected $user;

    public function createUserWithToken()
    {
        $faker = Faker::create();

        $this->user = User::create([
            'name' => $faker->unique()->name,
            'email' => $faker->unique()->safeEmail,
            'password' => '$2y$10$0okEQhogtOs9PXdN8lYJaOE8NWhaVOpIABwpyp/lk2YepmBSIxiv2'
        ]);

        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            $this->user->getAuthIdentifier(), 'Test Personal Access Client', 'https://localhost'
        );

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
         ]);

        $token = $this->user->createToken('TestToken', $this->scopes)->accessToken;
        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer '.$token;
    }
}
