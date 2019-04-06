<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Http\Resources\Payment as PaymentResource;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createPayment(string $model, array $attributes = [])
    {
        $payment = factory("App\\Models\\$model")->create($attributes);
        return $payment;
    }

    public function createBuyer(string $model, array $attributes = [])
    {
        $buyer = factory("App\\Models\\$model")->create($attributes);
        return $buyer;
    }
}
