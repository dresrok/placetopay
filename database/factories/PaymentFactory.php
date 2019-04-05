<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Payment::class, function (Faker $faker) {
    $reference = Str::random(32);
    $total = random_int(1000, 5000);
    return [
        'reference' => $reference,
        'description' => $faker->text($maxNbChars = 64),
        'currency' => $faker->currencyCode,
        'total' => $total,
        'allow_partial' => $faker->boolean
    ];
});
