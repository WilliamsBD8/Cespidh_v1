$(document).ready(function() {
    $('input.autocomplete-name').autocomplete({
        data: documentos(),
    });
    $('input.autocomplete-id').autocomplete({
        data: cedulas_aux(),
    });
    $('input.autocomplete-sedes').autocomplete({
        data: sedes_aux(),
    });
    $('input.autocomplete-usuarios').autocomplete({
        data: usuarios_aux(),
    });
    rellenar(filtro_aux());

    const users = users_aux();
    var cedulas = {};
    users.forEach(user => {
        cedulas[`${user.cedula}`] = null;
    });
    $('input.autocomplete-usuarios_form').autocomplete({
        data: cedulas,
    });
});

function rellenar(data) {
    if (data != null) {
        $('input.autocomplete-name').val(data.nombre);
        $('input.autocomplete-id').val(data.cedula);
        $('input.autocomplete-sedes').val(data.sede);
        $('input#date-inicial').val(data.date_init);
        $('input#date-final').val(data.date_finish);
        $('input#autocomplete-usuarios').val(data.usuario);
        M.updateTextFields();
    }
}

function buscar_user(id) {
    setTimeout(() => {
        var cedula = $(`#form-${id} #id`).val();
        console.log(cedula);
        if (cedula != '') {
            const users = users_aux();
            var user = users.filter(user => user.cedula == cedula);
            console.log(user);
            if (user.length == 1) {
                $(`#form-${id} #name`).val(user[0].name);
                $(`#form-${id} #ciudad`).val(user[0].ciudad);
                $(`#form-${id} #direccion`).val(user[0].direccion);
                $(`#form-${id} #phone`).val(user[0].phone);
                $(`#form-${id} #email`).val(user[0].email);
                $(`#form-${id} #genero_${user[0].genero_id}`).prop("checked", true);
                $(`#form-${id} #etnia_${user[0].grupo_etnia_id}`).prop("selected", true);
                M.updateTextFields();
                $('select').formSelect();
            } else {
                $(`#form-${id} #name`).val('');
                $(`#form-${id} #ciudad`).val('');
                $(`#form-${id} #direccion`).val('');
                $(`#form-${id} #phone`).val('');
                $(`#form-${id} #email`).val('');
                $(`#form-${id} .with-gap.genero`).prop("checked", false);
                $(`#form-${id} #etnia_vacio`).prop("selected", true);
                M.updateTextFields();
                $('select').formSelect();
            }
        }
    }, 1000);
}