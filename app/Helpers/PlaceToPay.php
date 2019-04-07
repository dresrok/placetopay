<?php

namespace App\Helpers;

use GuzzleHttp\Exception\ClientException;
use Carbon\Carbon;
use GuzzleHttp\Client;

use App\Models\Payment;
use App\Models\PaymentReference;
use App\Models\Attempt;

class PlaceToPay
{
    private $login;
    private $secretKey;
    protected $endpoint;
    protected $locale;

    protected $seed;
    protected $nonce;
    private $nonceBase64;
    private $tranKey;

    private function generateCredentials()
    {
        $this->login = config('placetopay.login');
        $this->secretKey = config('placetopay.secret');
        $this->endpoint = config('placetopay.endpoint');
        $this->locale = config('placetopay.locale');

        $this->seed = Carbon::now()->toIso8601String();
        $this->nonceBase64 = $this->generateNonceBase64();
        $this->tranKey = base64_encode(sha1($this->nonce . $this->seed . $this->secretKey, true));
    }

    private function generateNonceBase64() {
        if (function_exists('random_bytes')) {
            $this->nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $this->nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $this->nonce = mt_rand();
        }
        return base64_encode($this->nonce);
    }

    public function postMakePaymentRequest(Payment $payment)
    {
        $this->generateCredentials();

        $client = new Client([
            'base_uri' => $this->endpoint,
            'timeout'  => 2.0,
            'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/json'
            ],
            "http_errors" => false,
        ]);

        $request = $this->generatePaymentRequest($payment);

        $response = $client->request('POST', 'api/session', $request);

        $params = json_decode($response->getBody()->getContents());

        $attempt = $this->createAttempt($payment, $params);

        $placeToPay = $this->manageResponse($payment, $attempt, $params);

        return $placeToPay;
    }

    private function createAttempt($payment, $params)
    {
        $exists = Attempt::where('status', $params->status->status)
                            ->where('reason', $params->status->reason)
                            ->where('payment_id', $payment->id)
                            ->exists();
        if ($exists) {
            $attempt = Attempt::where('status', $params->status->status)
                            ->where('payment_id', $payment->id)
                            ->first();
        } else {
            $attempt = Attempt::create([
                'status' => $params->status->status,
                'reason' => $params->status->reason,
                'message' => $params->status->message,
                'date' => Carbon::parse($params->status->date),
                'payment_id' => $payment->id
            ]);
        }
        return $attempt;
    }

    private function manageResponse($payment, $attempt, $params)
    {
        $placeToPay = new \stdClass();
        $placeToPay->id = $attempt->id;
        $placeToPay->status = $attempt->status;
        $placeToPay->reason = $attempt->reason;
        $placeToPay->message = $attempt->message;
        $placeToPay->date = (string)$attempt->date;
        $placeToPay->payment_id = $payment->id;

        if ($params->status->status === 'OK' && $params->status->reason === 'PC') {

            $paymentReference = PaymentReference::create([
                'process_url' => $params->processUrl,
                'request_id' => $params->requestId,
                'payment_id' => $payment->id
            ]);

            $this->postMakePaymentInfoRequest($payment);

            $placeToPay->process_url = $paymentReference->process_url;
            $placeToPay->request_id = $paymentReference->request_id;

        }

        return $placeToPay;
    }

    private function generatePaymentRequest($payment)
    {
        return [
            'form_params' => [
                'auth' => [
                    'login' => $this->login,
                    'seed' => $this->seed,
                    'nonce' => $this->nonceBase64,
                    'tranKey' => $this->tranKey
                ],
                'locale' => $this->locale,
                'payer' => [
                    'name' => $payment->buyer->name,
                    'surname' => $payment->buyer->surname,
                    'email' => $payment->buyer->email,
                    'documentType' => $payment->buyer->documentType->code,
                    'document' => $payment->buyer->document,
                    'mobile' => $payment->buyer->mobile,
                    'address' => [
                        'street' => $payment->buyer->street,
                        'city' => $payment->buyer->city
                    ]
                ],
                'payment' => [
                    'reference' => $payment->reference,
                    'description' => $payment->description,
                    'amount' => [
                        'currency' => $payment->currency,
                        'total' => $payment->total
                    ],
                    'allowPartial' => (bool)$payment->allow_partial
                ],
                'expiration' => $payment->expirationDates->last()->expires_at->toIso8601String(),
                'ipAddress' => $payment->detail->ip_address,
                'userAgent' => $payment->detail->user_agent,
                'returnUrl' => $payment->detail->return_url
            ]
            
        ];
    }

    public function postMakePaymentInfoRequest(Payment $payment)
    {
        $this->generateCredentials();

        $client = new Client([
            'base_uri' => $this->endpoint,
            'timeout'  => 2.0,
            'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/json'
            ],
            "http_errors" => false,
        ]);

        $request = $this->generatePaymentInfoRequest();

        $requestId = $payment->paymentReference->request_id;

        $response = $client->request('POST', "api/session/$requestId", $request);

        $params = json_decode($response->getBody()->getContents());

        $attempt = $this->createAttempt($payment, $params);

        $placeToPay = $this->manageResponse($payment, $attempt, $params);

        return $placeToPay;
    }

    private function generatePaymentInfoRequest()
    {
        return [
            'form_params' => [
                'auth' => [
                    'login' => $this->login,
                    'seed' => $this->seed,
                    'nonce' => $this->nonceBase64,
                    'tranKey' => $this->tranKey
                ]
            ]
        ];
    }
}
