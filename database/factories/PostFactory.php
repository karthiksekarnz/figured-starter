<?php

use App\Models\Post;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => 'Sample post',
        'slug' => Str::slug('Sample post'),
        'content' => '<p><span>Sint ullam officiis tempora voluptas rem.</span><ul><li>Nemo reiciendis.</li>'.
        '<li>Molestias earum voluptas at.</li><li>Ea dolorem adipisci non aut.</li><li>Tempore recusandae.</li>'.
        '<li>Vel magni rerum.</li><li>Amet consequatur doloribus praesentium exercitationem.</li><li>Possimus.</li>'.
        '<li>Excepturi sit eum tempore.</li></ul></p><p><i>Ut possimus.</i><a href="example.net">Ratione corporis'.
        ' minima odio harum.</a>Totam mollitia voluptas quia animi.<a href="example.org">Qui et quisquam.</a></p>'
    ];
});
