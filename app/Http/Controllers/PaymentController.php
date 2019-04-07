<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\Payment;
use App\Models\DocumentType;
use App\Models\ExpirationDate;
use App\Models\Attempt;
use App\Http\Resources\Payment as PaymentResource;
use App\Facades\PlaceToPay;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reference = Payment::generateReference(32);
        $payments = Payment::all();
        return view('payments.index', compact('reference', 'payments'));
    }

    public function getReference()
    {
        $reference = Payment::generateReference(32);
        return response()->json($reference, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment = Payment::create([
            'reference' => $request->reference,
            'description' => $request->description,
            'currency' => $request->currency,
            'total' => $request->total,
            'allow_partial' => $request->allow_partial
        ]);
        return response()->json(new PaymentResource($payment), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id, int $redirected = 0)
    {
        $payment = Payment::with([
            'buyer.documentType',
            'paymentReference',
            'expirationDates',
            'attempts'
        ])->findorFail($id);
        if ($redirected) {
            $payment->redirected = 1;
            $payment->save();
        }
        $failAttempt = Attempt::where('status', 'FAILED')
                        ->where('payment_id', $payment->id)
                        ->exists();
        $okAttempt = Attempt::where('status', 'OK')
                        ->where('payment_id', $payment->id)
                        ->exists();
        $pendingAttempt = Attempt::where('status', 'PENDING')
                        ->where('payment_id', $payment->id)
                        ->exists();
        if ($pendingAttempt) {
            PlaceToPay::postMakePaymentInfoRequest($payment);
        }
        $documentTypes = DocumentType::all();
        return view('payments.show', compact('payment', 'documentTypes', 'failAttempt', 'okAttempt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::with([
            'expirationDates',
            'detail'
        ])->findorFail($id);

        $expirationDate = $payment->expirationDates->last();

        $now = Carbon::now();

        if ($now > $expirationDate->expires_at) {
            $expirationDate->delete();
            ExpirationDate::create([
                'expires_at' => Carbon::now()->addHours(1),
                'payment_id' => $payment->id
            ]);
        }

        $response = PlaceToPay::postMakePaymentRequest($payment);

        return redirect()->route('payments.show', ['id' => $payment->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
