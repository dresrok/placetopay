<!-- Stored in resources/views/payments/show.blade.php -->
@extends('layouts.app')
@section('title', 'Pagos')
@section('content')
<div class="row py-2">
  <div class="col">
    <a href="{{ route('payments.index') }}" class="btn btn-info">Refresar</a>
    <h4>Referencia de Pago: {{ $payment->reference }}</h4>
    <form>
        <input type="hidden" id="id" value="{{ $payment->id }}">
      <div class="form-group row">
        <label for="staticExpireDate" class="col-sm-2 col-form-label">Fecha expiración</label>
        <div class="col-sm-10">
          <input type="text" readonly class="form-control-plaintext" id="staticCurrency" value="{{ $payment->expirationDates->first()->expires_at }}">
        </div>
      </div>
      <div class="form-group row">
        <label for="staticDescription" class="col-sm-2 col-form-label">Descripción</label>
        <div class="col-sm-10">
          <textarea type="text" readonly class="form-control-plaintext" id="staticDescription">{{ $payment->description }}</textarea>
        </div>
      </div>
      <div class="form-group row">
        <label for="staticCurrency" class="col-sm-2 col-form-label">Moneda</label>
        <div class="col-sm-10">
          <input type="text" readonly class="form-control-plaintext" id="staticCurrency" value="{{ $payment->currency }}">
        </div>
      </div>
      <div class="form-group row">
        <label for="staticTotal" class="col-sm-2 col-form-label">Total</label>
        <div class="col-sm-10">
          <input type="text" readonly class="form-control-plaintext" id="staticTotal" value="{{ $payment->total }}">
        </div>
      </div>
    </form>
  </div>
</div>
<hr>
@if($payment->buyer)
  <div class="row">
    <div class="col"></div>
  </div>
@else
  <div class="row">
    <div class="col">
      no hay
    </div>
  </div>
@endif
@endsection