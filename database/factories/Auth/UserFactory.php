<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
$factory->define(\Innoscripta\Domain\Auth\User::class, function (Faker $faker) {
    static $password;

    return [
        'employee_id' => null,
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'username' => $faker->unique()->userName,
        'password' => $password ?: $password = bcrypt('secret'),
        'role'  => 4,
        'remember_token' => Str::random(10),
    ];
});
