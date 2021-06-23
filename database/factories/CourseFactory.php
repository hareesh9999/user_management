<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Course;
use Faker\Generator as Faker;

// Created the fake course factory with title and description fields
$factory->define(Course::class, function (Faker $faker) {
    return [
        'title'=>$faker->title,
        'description'=>$faker->paragraph,
    ];
});
