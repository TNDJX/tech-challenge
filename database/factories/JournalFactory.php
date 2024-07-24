<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Journal;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Journal::class, function (Faker $faker) {
    $date = Carbon::make($faker->dateTimeBetween('-1 year', '+1 year'));

    return [
        'date' => $date,
        'content' => $faker->paragraph,
        'client_id' => factory(App\Client::class)->create()->id
    ];
});
