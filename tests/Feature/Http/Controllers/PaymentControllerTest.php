<?php

namespace Tests\Feature\Http\Controllers;

use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class PaymentControllerTest extends TestCase
{
    /**
     * @test
     */
    public function can_create_a_payment()
    {
        $faker = Factory::create();
        // Given

        // When
        $response = $this->post('/payments', [
            'reference' => $reference = Str::random(32),
            'description' => $faker->text($maxNbChars = 64),
            'currency' => $currency = $faker->currencyCode,
            'total' => $total = random_int(1000, 5000),
            'allow_partial' => $faker->boolean
        ]);

        // Then
        $response->assertJsonStructure([
            'id',
            'reference',
            'description',
            'currency',
            'total',
            'allow_partial',
            'created_at'
        ])->assertJson([
            'reference' => $reference,
            'currency' => $currency,
            'total' => $total
        ])
        ->assertStatus(201);

        $this->assertDatabaseHas('payments', [
            'reference' => $reference,
            'currency' => $currency,
            'total' => $total
        ]);
    }
}
