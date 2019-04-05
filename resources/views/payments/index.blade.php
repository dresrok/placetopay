<!-- Stored in resources/views/payments/index.blade.php -->
@extends('layouts.app')
@section('title', 'Pagos')
@section('content')
  <div class="row my-2">
    <div class="col">
      @include('payments.create')
    </div>
  </div>
  <div class="row">
    <div class="col">
      @include('payments.items')
    </div>
  </div>
@endsection