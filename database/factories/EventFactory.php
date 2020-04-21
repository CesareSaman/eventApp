<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    $users = App\Models\User::pluck('id')->toArray();
    return [
        'user_id'           => $faker->randomElement($users),
        'event_title'       => $faker->jobTitle,
        'event_location'    => $faker->city,
        'event_description' => $faker->text,
        'event_start_date'  => $faker->dateTimeBetween('-6 months','-3 months')->format('Y-m-d'),
        'event_end_date'    => $faker->dateTimeBetween('-3 months','now')->format('Y-m-d'),
        'event_price'       => $faker->numberBetween($min = 10000, $max = 10000000),
    ];
});
