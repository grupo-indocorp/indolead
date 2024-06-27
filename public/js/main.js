/**
 * Funciones para registro y actualización de datos
 */
function capturarToken() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
}
function limpiarError() {
  const dialog = document.querySelector("#dialog");
  dialog.querySelectorAll('.is-invalid, .invalid-feedback').forEach(element => {
    element.classList.contains('is-invalid') ? element.classList.remove('is-invalid') : element.remove();
  });
}
function mostrarError(response) {
  let errors = response.responseJSON;
  if (errors) {
    let firstErrorKey = null;
    $.each(errors.errors, function (key, value) {
      $('#dialog #' + key).addClass('is-invalid');
      $('#dialog #' + key).after('<span class="invalid-feedback" role="alert"><strong>' + value + '</strong></span>');
      if (!firstErrorKey) {
        firstErrorKey = key;
      }
    });
    if (firstErrorKey) {
      $('#dialog #' + firstErrorKey).focus();
    }
  }
}
