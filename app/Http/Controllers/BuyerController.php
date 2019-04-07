<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Buyer;
use App\Models\Payment;
use App\Http\Resources\Buyer as BuyerResource;
use App\Facades\PlaceToPay;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $buyer = Buyer::where('document', $request->document)
                        ->orWhere('email', $request->email)
                        ->first();
        if (empty($buyer)) {
            $buyer = Buyer::create([
                'document' => $request->document,
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'street' => $request->street,
                'city' => $request->city,
                'mobile' => $request->mobile,
                'document_type_id' => $request->document_type_id
            ]);
        } else {
            $buyer->name = $request->name;
            $buyer->surname = $request->surname;
            $buyer->email = $request->email;
            $buyer->street = $request->street;
            $buyer->city = $request->city;
            $buyer->mobile = $request->mobile;
            $buyer->document_type_id = $request->document_type_id;
            $buyer->save();
        }
        $payment = Payment::find($request->payment_id);
        $payment->buyer()->associate($buyer);
        $payment->save();
        return response()->json(new BuyerResource($buyer), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
