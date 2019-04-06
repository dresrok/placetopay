<!--Stored in resources/views/buyers/create.blade.php -->
<form id="create_buyer_form" method="POST" action="{{ route('buyers.store') }}">
  @csrf
  <input type="hidden" name="payment_id" id="currency" value="{{ $payment->id }}">
  <div class="form-group">
    <label for="document_type_id">Tipo documento</label>
    <select
      type="text"
      class="form-control"
      name="document_type_id"
      id="document_type_id" 
      aria-describedby="documentTypeHelp"
    >
      @foreach ($documentTypes as $documentType)
        <option value="{{ $documentType->id }}">{{ $documentType->code }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="document">Documento *</label>
    <input
      type="text"
      class="form-control"
      name="document"
      id="document" 
      aria-describedby="documentHelp"
      placeholder="Documento"
    >
  </div>
  <div class="form-group">
    <label for="name">Nombre *</label>
    <input
      type="text"
      class="form-control"
      name="name"
      id="name" 
      aria-describedby="nameHelp"
      placeholder="Nombre"
    >
  </div>
  <div class="form-group">
    <label for="surname">Apellido *</label>
    <input
      type="text"
      class="form-control"
      name="surname"
      id="surname" 
      aria-describedby="surnameHelp"
      placeholder="Apellido"
    >
  </div>
  <div class="form-group">
    <label for="email">Email *</label>
    <input
      type="email"
      class="form-control"
      name="email"
      id="email" 
      aria-describedby="emailHelp"
      placeholder="Email"
    >
  </div>
  <div class="form-group">
    <label for="city">Ciudad *</label>
    <input
      type="text"
      class="form-control"
      name="city"
      id="city" 
      aria-describedby="cityHelp"
      placeholder="Ciudad"
    >
  </div>
  <div class="form-group">
    <label for="street">Dirección *</label>
    <textarea
      type="text"
      class="form-control"
      name="street"
      id="street" 
      aria-describedby="streetHelp"
      placeholder="Dirección"
    ></textarea>
  </div>
  <div class="form-group">
    <label for="mobile">Celular *</label>
    <input
      type="text"
      class="form-control"
      name="mobile"
      id="mobile" 
      aria-describedby="mobileHelp"
      placeholder="Celular"
    >
  </div>
  <button type="submit" class="btn btn-primary loading">Guardar</button>
</form>
<hr>
@push('scripts')
<script>
  $( document ).ready(function() {
    $("#create_buyer_form").validate({
      rules:{
        document: {
          required: true,
          document: '#document_type_id'
        },
        name: {
          required: true,
          lettersonlywithaccents: true,
          maxlength: 128
        },
        surname: {
          required: true,
          lettersonlywithaccents: true,
          maxlength: 128
        },
        email: {
          required: true,
          email: true,
          maxlength: 32
        },
        street: {
          required: true,
          maxlength: 64
        },
        city: {
          required: true,
          maxlength: 64
        },
        mobile: {
          required: true,
          number: true,
          minlength: 6,
          maxlength: 30
        }
      },
      submitHandler: function(form, e) {
        e.preventDefault();
        _ajaxSubmit($(form), function(response) {
          let $form = $('#create_buyer_form');
          let showForm = `@include('buyers.show', ['buyer' => $payment->buyer])`;
          console.log(response);
          let $div = $form.parent();
          $div.empty();
          $div.append(showForm);
          $('#staticDocument').val(`${response.document_type.code} ${response.document}`)
          $('#staticName').val(response.name)
          $('#staticSurname').val(response.surname)
          $('#staticEmail').val(response.email)
          $('#staticCity').val(response.city)
          $('#staticStreet').text(response.street)
          $('#staticMobile').val(response.mobile)
        });
      }
    });
  });
</script>
@endpush