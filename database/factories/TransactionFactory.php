<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'sum' => rand(99, 999),
        'transaction_at' => $faker->dateTimeBetween('+1 days', '+2 days')
    ];
});
