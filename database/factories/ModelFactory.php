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

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'name'=> $faker->username,
        'email'=> 'hieubui1195@gmail.com',
        'level' => 2,
        'address'=> $faker->address,
        'phone'=> $faker->phoneNumber,
        'password' => bcrypt('123456'),
        'created_at' => new Datetime(),
        'point'=> $faker->randomDigitNotNull,
    ];
});


$factory->define(App\Models\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->randomElement($array = array('Linh Kiện Máy Tính', 'Máy Tính Xách Tay', 'Máy Tính Để Bàn', 'Thiết Bị Lưu Trữ')),
        'created_at' => new Datetime(),
    ];
});

$factory->define(App\Models\Product::class, function (Faker $faker) {
     return [
        'category_id'=> $faker->numberBetween($min = 4, $max = 12),
        'name' => $faker->unique()->name,
        'description'=> $faker->text($maxNbChars = 100),
        'price'=> $faker->randomNumber(8),
        'amount'=> $faker->randomNumber(2),
        'created_at' => new Datetime(),
    ];
});

