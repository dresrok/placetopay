$.validator.addMethod(
    'lettersonlywithaccents',
    function(value, element) {
        return this.optional(element) || /^[a-z\s-a-záéíóúý]+$/i.test(value);
    },
    'Por favor, escribe solo letras.'
);
$.validator.addMethod(
    'document',
    function(value, element, param) {
        let documentTypeCode = $('option:selected', param).text();
        switch (documentTypeCode) {
            case 'CC':
            case 'TI':
            case 'RC':
                return this.optional(element) || /^\d+$/.test(value);
            case 'NIT':
            case 'RUT':
                return (
                    this.optional(element) || /^\d{10,11}-[\d]{1}$/i.test(value)
                );
            default:
                return (
                    this.optional(element) ||
                    /^[0-9{8,10}]+(-?[a-zA-z0-9{1}])?$/.test(value)
                );
        }
    },
    'Por favor, escribe un documento válido'
);
/**
 * Función pública para validar un formulario
 * @param {form} $form
 * @param {json} rules
 */
function validateForm($form, rules) {
    $form.validate({
        rules: rules,
        submitHandler: function(form) {
            if ($(form).hasClass('ajax-submit')) {
                _ajaxSubmit($form, oTable);
            } else {
                form.submit();
            }
        }
    });
}

/**
 * Función privada para realizar
 * submit de un formulario vía ajax
 * @param {form} $form
 */
function _ajaxSubmit($form, callback) {
    let type =
        $('input[name=_method]', $form).length === 1
            ? $('input[name=_method]', $form).val()
            : $form.attr('method');
    let $btn = $('.loading', $form);
    $btn.prop('disabled', true);
    $btn.html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...'
    );
    $.ajax({
        url: $form.attr('action'),
        type: type,
        dataType: 'json',
        data: $form.serialize()
    })
        .done(function(response) {
            callback(response);
            $form.trigger('reset');
        })
        .fail(function(jqXHR, textStatus) {
            console.error(jqXHR, textStatus);
        })
        .always(function() {
            $btn.html('Guardar');
            $btn.prop('disabled', false);
        });
}
