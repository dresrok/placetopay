<?php

use Faker\Generator as Faker;
use Faker\Provider\es_PE\Person;

use App\Models\DocumentType;

$factory->define(App\Models\Buyer::class, function (Faker $faker) {
    $faker->addProvider(new Person($faker));
    $documentTypeIds = DocumentType::all()->pluck('id')->toArray();
    return [
        'document' => $faker->dni,
        'name' => $faker->firstName,
        'surname' => $faker->firstName,
        'email' => $faker->email,
        'street' => $faker->address,
        'city' => $faker->city,
        'mobile' => $mobile = $faker->phoneNumber,
        'document_type_id' => $faker->randomElement($documentTypeIds),
    ];
});
