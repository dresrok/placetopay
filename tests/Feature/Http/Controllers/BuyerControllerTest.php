<?php

namespace Tests\Feature\Http\Controllers;

use Faker\Factory;
use Faker\Provider\es_PE\Person;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\DocumentType;

class BuyerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /**
     * @test
     */
    public function can_create_a_buyer()
    {
        $faker = Factory::create();
        $faker->addProvider(new Person($faker));
        $documentTypeIds = DocumentType::all()->pluck('id')->toArray();
        // Given
        $payment = $this->createPayment('Payment');
        // When
        $responsePayment = $this->get("/payments/$payment->id");
        $responseBuyer = $this->post('/buyers', [
            'document' => $document = $faker->dni,
            'name' => $faker->firstName,
            'surname' => $faker->firstName,
            'email' => $email = $faker->email,
            'street' => $faker->address,
            'city' => $faker->city,
            'mobile' => $mobile = $faker->phoneNumber,
            'document_type_id' => $documentTypeId = $faker->randomElement($documentTypeIds),
            'payment_id' => $payment->id
        ]);

        // Then
        $responseBuyer->assertJsonStructure([
            'id',
            'document',
            'name',
            'surname',
            'email',
            'street',
            'city',
            'mobile',
            'document_type_id',
            'created_at'
        ])->assertJson([
            'document' => $document,
            'email' => $email,
            'mobile' => $mobile,
            'document_type_id' => $documentTypeId
        ])
        ->assertStatus(201);

        $this->assertDatabaseHas('buyers', [
            'document' => $document,
            'email' => $email,
            'mobile' => $mobile,
            'document_type_id' => $documentTypeId
        ]);
    }
}
