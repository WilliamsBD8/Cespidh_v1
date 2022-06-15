function new_document() {
    var motivo = $('#motivo').val();
    var file = $('#input-file-now').val();
    if (file == '')
        return alert('<span class="red-text">No se puede ingresar sin un archivo</span>', 'red lighten-5');
    if (motivo == '')
        return alert('<span class="red-text">No se puede ingresar sin un motivo</span>', 'red lighten-5');
    $('#new_document').submit();
}
$(document).ready(function() {
    var user = user_aux();
    $('#id').val(user.id);
    $('#cedula').val(user.cedula);
    $('#name').val(user.name);
    $('#ciudad').val(user.ciudad);
    $('#direccion').val(user.direccion);
    $('#phone').val(user.phone);
    $('#email').val(user.email);
    $(`#genero_${user.genero_id}`).prop("checked", true);
    $(`#etnia_${user.grupo_etnia_id}`).prop("selected", true);
    M.updateTextFields();
    $('select').formSelect();
    $('.phone-input').formatter({
        'pattern': '{{9999999999}}',
        'persistent': true
    });
});

function update_user(key) {
    var data = new URLSearchParams({
        id: $('#id').val(),
        cedula: $('#cedula').val(),
        name: $('#name').val(),
        ciudad: $('#ciudad').val(),
        direccion: $('#direccion').val(),
        phone: $('#phone').val(),
        email: $('#email').val(),
        genero: $(`input[name=genero]:checked`).val(),
        etnia: $(`#etnia`).val(),
        validation: true
    });
    var url = base_url(['cespidh', 'update', 'user']);
    result = proceso_fetch(url, data.toString());
    result.then(data => {
        if (data.update) {
            var linearStepper = document.querySelector('#linearStepper0');
            var linearStepperInstace = new MStepper(linearStepper, {
                firstActive: (key + 2),
            });
            linearStepperInstace.nextStep((key + 1));
            linearStepperInstace.updateStepper();

        } else {
            var mensajes = Object.entries(data.messages);
            console.log(data.messages);
            mensajes.forEach(([key, message]) => {
                alert(`<span class="red-text">${message}</span>`, 'red lighten-5');
            })
        }
    });
}

function guardar() {
    var data = new URLSearchParams({
        id: $('#id').val(),
        cedula: $('#cedula').val(),
        name: $('#name').val(),
        ciudad: $('#ciudad').val(),
        direccion: $('#direccion').val(),
        phone: $('#phone').val(),
        email: $('#email').val(),
        genero: $(`input[name=genero]:checked`).val(),
        etnia: $(`#etnia`).val(),
        validation: false
    });
    var url = base_url(['cespidh', 'update', 'user']);
    result = proceso_fetch(url, data.toString());
    result.then(data => {
        $('#form-edit').submit();
    });
}