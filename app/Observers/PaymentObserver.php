<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\ExpirationDate;
use App\Models\PaymentDetail;
use Carbon\Carbon;

class PaymentObserver
{
    /**
     * Handle the payment "created" event.
     *
     * @param  \App\Payment  $payment
     * @return void
     */
    public function created(Payment $payment)
    {
        ExpirationDate::create([
            'expires_at' => Carbon::now()->addHours(1),
            'payment_id' => $payment->id
        ]);
        PaymentDetail::create([
            'return_url' => url()->full() . "/{$payment->id}/1",
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'payment_id' => $payment->id
        ]);
    }

    /**
     * Handle the payment "updated" event.
     *
     * @param  \App\Payment  $payment
     * @return void
     */
    public function updated(Payment $payment)
    {
        //
    }

    /**
     * Handle the payment "deleted" event.
     *
     * @param  \App\Payment  $payment
     * @return void
     */
    public function deleted(Payment $payment)
    {
        //
    }

    /**
     * Handle the payment "restored" event.
     *
     * @param  \App\Payment  $payment
     * @return void
     */
    public function restored(Payment $payment)
    {
        //
    }

    /**
     * Handle the payment "force deleted" event.
     *
     * @param  \App\Payment  $payment
     * @return void
     */
    public function forceDeleted(Payment $payment)
    {
        //
    }
}
