<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PlaceToPay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'placetopay';
    }
}
