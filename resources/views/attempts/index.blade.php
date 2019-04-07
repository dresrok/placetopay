<!-- Stored in resources/views/payments/items.blade.php -->
<h4>Intentos</h4>
<table class="table" id="attempts-table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Estado</th>
      <th scope="col">Razón</th>
      <th scope="col">Mensaje</th>
      <th scope="col">Fecha</th>
    </tr>
  </thead>
  <tbody>
      @forelse ($attempts as $attempt)
        <tr>
          <td>{{$attempt->id}}</td>
          <td>{{$attempt->status}}</td>
          <td>{{$attempt->reason}}</td>
          <td>{{$attempt->message}}</td>
          <td>{{$attempt->date}}</td>
        </tr>
      @empty
        <tr class="empty">
          <td colspan="6">No existen intentos de pago!!!</td>
        </tr>
      @endforelse
  </tbody>
</table>