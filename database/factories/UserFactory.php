<?php

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'nama' => $faker->name,
        'parent' => null,
        'id_role' => 1,
        'username' => $faker->numerify('################'),
        'password' => '$2y$10$D5ykTMSjN89Zqom/9csATuYYRbEDfXEePmQYg3UNUH/bRwrT2Lx0S', // passwordnya: password
        'email' => $faker->unique()->safeEmail,
        'telp' => $faker->numerify('###########'),
        'kelas' => $faker->numberBetween(1,12),
        'tahun_ajaran' => '2021-2022',
        'remember_token' => str_random(10),
    ];
});
