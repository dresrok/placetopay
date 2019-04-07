<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Payment;
use App\Models\Attempt;
use App\Facades\PlaceToPay;

class PlaceToPayController extends Controller
{
    public function store(Request $request)
    {
        $payment = Payment::with([
            'buyer.documentType',
            'expirationDates'
        ])->findorFail($request->id);
        $response = PlaceToPay::postMakePaymentRequest($payment);
        return response()->json($response, 201);
    }

    public function getAttempts($id)
    {
        $attempts = Attempt::where('payment_id', $id)->get();
        return response()->json($attempts, 201);
    }
}
