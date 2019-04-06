<?php

namespace Tests\Feature\Http\Controllers;

use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

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

    /**
     * @test
     */
    public function will_fail_with_a_404_if_payment_is_not_found()
    {
        $response = $this->get('/payments/-1');
        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function can_return_a_payment()
    {
        // Given
        $payment = $this->createPayment('Payment');
        // When
        $response = $this->get("/payments/$payment->id");
        // Then
        $response->assertStatus(200)
        ->assertViewHas('payment', $payment);
    }
}
