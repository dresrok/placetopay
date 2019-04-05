<!-- Stored in resources/views/payments/items.blade.php -->
<h4>Referencias de Pago</h4>
<table class="table" id="references-table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Referencia</th>
      <th scope="col">Descripción</th>
      <th scope="col">Moneda</th>
      <th scope="col">Total</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
      @forelse ($payments as $payment)
        <tr>
          <td>{{$payment->id}}</td>
          <td>{{$payment->reference}}</td>
          <td>{{$payment->description}}</td>
          <td>{{$payment->currency}}</td>
          <td>{{$payment->total}}</td>
          <td>
            <a href="{{ route('payments.show', ['id' => $payment->id]) }}" class="btn btn-info btn-sm" role="button" aria-pressed="true">Ver</a>
          </td>
        </tr>
      @empty
        <tr class="empty">
          <td colspan="6">No existen referencias de pago!!!</td>
        </tr>
      @endforelse
  </tbody>
</table>