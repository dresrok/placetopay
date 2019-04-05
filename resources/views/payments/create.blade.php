<!-- Stored in resources/views/payments/create.blade.php -->
<h4>Crear Referencia de Pago</h4>
<form id="create_reference_form" method="POST" action="/payments">
  @csrf
  <input type="hidden" name="currency" id="currency" value="COP">
  <input type="hidden" name="allow_partial" id="allow_partial" value="0">
  <div class="form-group">
    <label for="reference">Referencia</label>
    <input
      type="text"
      class="form-control"
      name="reference"
      id="reference" 
      aria-describedby="referenceHelp"
      placeholder="Referencia"
      readonly
      value="{{ $reference }}"
    >
    <small id="referenceHelp" class="form-text text-muted">La referencia se genera automáticamente.</small>
  </div>
  <div class="form-group">
    <label for="description">Descripción *</label>
    <textarea
      type="text"
      class="form-control"
      name="description"
      id="description" 
      aria-describedby="descriptionHelp"
      placeholder="Descripción"
    ></textarea>
  </div>
  <div class="form-group">
    <label for="total">Total *</label>
    <input
      type="number"
      class="form-control"
      name="total"
      id="total" 
      aria-describedby="totalHelp"
      placeholder="Total"
    >
  </div>
  <button type="submit" class="btn btn-primary loading">Guardar</button>
</form>
<hr>
@section('scripts')
<script>
  $("#create_reference_form").validate({
    rules:{
      reference: {
        required: true
      },
      description: {
        required: true
      },
      total: {
        required: true
      }
    },
    submitHandler: function(form, e) {
      e.preventDefault();
      _ajaxSubmit($(form), function(response) {
        $.get('payments/generate-reference', function(data) {
          $('#reference').val(data);
        });
        let tr = `
          <tr>
            <td>${response.id}</td>
            <td>${response.reference}</td>
            <td>${response.description}</td>
            <td>${response.currency}</td>
            <td>${response.total}</td>
            <td>
              <a href="{{ route('payments.show', ['id' => ':id']) }}" class="btn btn-info btn-sm" role="button" aria-pressed="true">Ver</a>
            </td>
          </tr>
        `;
        tr = tr.replace(/:id/g, response.id);
        if ($('#references-table tbody tr:first-child').hasClass('empty')) {
          $('#references-table tbody tr').remove('.empty');
        }
        $('#references-table tbody').append(tr);
      });
    }
  });
</script>
@endsection