<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Items;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(App\Items::class, function ($faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->paragraph,
        'image' => function(){
            return "uploads/8AFOfEDZVl.png";
        },
        'user_id' => function () {
            // Uncomment this if you want to create for each new item a brand new user
            // return factory(App\User::class)->create()->id;

            // And comment this if you won't
            return rand(0, DB::table('users')->count() - 1);
        },
]; });
