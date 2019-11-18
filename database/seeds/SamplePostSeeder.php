<?php

use Illuminate\Database\Seeder;
use App\Models\Post;

class SamplePostSeeder extends Seeder
{
    public function run()
    {
        factory(Post::class)->create();
    }
}
