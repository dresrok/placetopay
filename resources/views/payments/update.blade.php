<!-- Stored in resources/views/payments/update.blade.php -->
<form id="update_payment_form" method="POST" action="{{ route('payments.update', ['id' => $payment->id]) }}">
  @csrf
  @method('PUT')
  <input type="hidden" name="payment_id" id="payment_id" value="{{ $payment->id }}">
  <button type="submit" class="btn btn-primary loading">Reintentar</button>
</form>
