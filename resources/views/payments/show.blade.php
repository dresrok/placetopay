<!--Stored in resources/views/payments/show.blade.php -->
@extends('layouts.app')
@section('title', 'Pagos')
@section('content')
<a href="{{ route('payments.index') }}" class="btn btn-info my-2">Regresar</a>
<div class="row">
  @if($payment->buyer)
    <div class="col-6">
      @include('buyers.show', ['buyer' => $payment->buyer])
    </div>
  @else
    <div class="col-6">
      @include('buyers.create', ['documentTypes' => $documentTypes])
    </div>
  @endif
  <div class="col-6">
    <form>
      <div class="form-group row">
        <label for="staticReference" class="col-sm-4 col-form-label font-weight-bold">Referencia de pago</label>
        <div class="col-sm-8">
          <input type="text" readonly class="form-control-plaintext" id="staticReference" value="{{ $payment->reference }}">
        </div>
      </div>
      <div class="form-group row">
        <label for="staticExpireDate" class="col-sm-4 col-form-label font-weight-bold">Fecha expiración</label>
        <div class="col-sm-8">
          <input type="text" readonly class="form-control-plaintext" id="staticExpireDate" value="{{ $payment->expirationDates->first()->expires_at }}">
        </div>
      </div>
      <div class="form-group row">
        <label for="staticDescription" class="col-sm-4 col-form-label font-weight-bold">Descripción</label>
        <div class="col-sm-8">
          <textarea type="text" readonly class="form-control-plaintext" id="staticDescription">{{ $payment->description }}</textarea>
        </div>
      </div>
      <div class="form-group row">
        <label for="staticCurrency" class="col-sm-4 col-form-label font-weight-bold">Moneda</label>
        <div class="col-sm-8">
          <input type="text" readonly class="form-control-plaintext" id="staticCurrency" value="{{ $payment->currency }}">
        </div>
      </div>
      <div class="form-group row">
        <label for="staticTotal" class="col-sm-4 col-form-label font-weight-bold">Total</label>
        <div class="col-sm-8">
          <input type="text" readonly class="form-control-plaintext" id="staticTotal" value="{{ $payment->total }}">
        </div>
      </div>
    </form>
  </div>
</div>
<hr>
@endsection
@push('scripts')
<script>
  $( document ).ready(function() {
  });
</script>
@endpush