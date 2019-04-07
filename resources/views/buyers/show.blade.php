<!--Stored in resources/views/buyers/show.blade.php -->
<form>
  <div class="form-group row">
    <label for="staticDocument" class="col-sm-3 col-form-label font-weight-bold">Documento</label>
    <div class="col-sm-9">
      <input
        type="text"
        readonly
        class="form-control-plaintext"
        id="staticDocument"
        value="{{ ($buyer) ? $buyer->documentType->code : '' }} {{ ($buyer) ? $buyer->document : '' }}"
      >
    </div>
  </div>
  <div class="form-group row">
    <label for="staticName" class="col-sm-3 col-form-label font-weight-bold">Nombre</label>
    <div class="col-sm-9">
      <input type="text" readonly class="form-control-plaintext" id="staticName" value="{{ ($buyer) ? $buyer->name : '' }}">
    </div>
  </div>
  <div class="form-group row">
    <label for="staticSurname" class="col-sm-3 col-form-label font-weight-bold">Apellido</label>
    <div class="col-sm-9">
      <input type="text" readonly class="form-control-plaintext" id="staticSurname" value="{{ ($buyer) ? $buyer->surname : '' }}">
    </div>
  </div>
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Email</label>
    <div class="col-sm-9">
      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ ($buyer) ? $buyer->email : '' }}">
    </div>
  </div>
  <div class="form-group row">
    <label for="staticCity" class="col-sm-3 col-form-label font-weight-bold">Ciudad</label>
    <div class="col-sm-9">
      <input type="text" readonly class="form-control-plaintext" id="staticCity" value="{{ ($buyer) ? $buyer->city : '' }}">
    </div>
  </div>
  <div class="form-group row">
    <label for="staticStreet" class="col-sm-3 col-form-label font-weight-bold">Dirección</label>
    <div class="col-sm-9">
      <textarea type="text" readonly class="form-control-plaintext" id="staticStreet">{{ ($buyer) ? $buyer->street : '' }}</textarea>
    </div>
  </div>
  <div class="form-group row">
    <label for="staticMobile" class="col-sm-3 col-form-label font-weight-bold">Celular</label>
    <div class="col-sm-9">
      <input type="text" readonly class="form-control-plaintext" id="staticMobile" value="{{ ($buyer) ? $buyer->mobile : '' }}">
    </div>
  </div>
</form>