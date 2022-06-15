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
        var cedula = $(`#form-${id} #id-${id}`).val();
        if (cedula != '') {
            const users = users_aux();
            var user = users.filter(user => user.cedula == cedula);
            console.log(user);
            if (user.length == 1) {
                $(`#form-${id} #name-${id}`).val(user[0].name);
                $(`#form-${id} #ciudad-${id}`).val(user[0].ciudad);
                $(`#form-${id} #direccion-${id}`).val(user[0].direccion);
                $(`#form-${id} #phone-${id}`).val(user[0].phone);
                $(`#form-${id} #email-${id}`).val(user[0].email);
                $(`#form-${id} #genero_${user[0].genero_id}`).prop("checked", true);
                $(`#form-${id} #etnia-${id} #etnia_${user[0].grupo_etnia_id}`).prop("selected", true);
                M.updateTextFields();
                $('select').formSelect();
            } else {
                $(`#form-${id} #name-${id}`).val('');
                $(`#form-${id} #ciudad-${id}`).val('');
                $(`#form-${id} #direccion-${id}`).val('');
                $(`#form-${id} #phone-${id}`).val('');
                $(`#form-${id} #email-${id}`).val('');
                $(`#form-${id} .with-gap.genero`).prop("checked", false);
                $(`#form-${id} #etnia-${id} #etnia_vacio`).prop("selected", true);
                M.updateTextFields();
                $('select').formSelect();
            }
        }
    }, 1000);
}

function filtrar() {
    var form = $('#filtro');
    var url = form.attr('action');
    var data = form.serialize();
    result = proceso_fetch(url, data.toString());
    result.then(data => {
        $('table.display').DataTable().destroy();
        data.estados.forEach((estado, key) => {
            tabla(data, key, estado);
        });
        estado = { id_estado: 0 };
        tabla(data, (-1), estado);

        $('table.display').DataTable({
            "responsive": false,
            order: [
                [0, 'desc']
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "Todo"]
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
            },
        });
        $('.tabs a').removeClass('active');
        $('.todo-tab a').addClass('active');
        $('.tabs').tabs();
    });
}

function tabla(data, key, estado) {
    $(`#table-${(key+1)} tbody`).html('');
    var tbody = '';
    data.documents.forEach((document, key) => {
        if (estado.id_estado == document.id_estado || estado.id_estado == 0) {
            tbody += `
                        <tr>
                            <td>${document.abreviacion+document.id_documento}</td>
                            <td>${document.name}</td>
                            <td>${document.cedula}</td>
                            <td>${document.descripcion}</td>
                            <td>${document.nombre}</td>
                            <td>${document.sede}</td>
                            <td>`;
            if (document.help == 'off')
                tbody += 'No necesita';
            else if (document.asignacion)
                tbody += `${document.asignacion}`;
            else
                tbody += 'No asignado';
            tbody += `
                            </td>
                            <td>${document.fecha} </td>
                            <td>
                                <div class="center-align">
                                    <a class="tooltipped"
                                    href="${base_url(['cespidh', 'edit', 'document', document.id_documento])}" target="_blank"
                                        data-position="bottom" data-tooltip="Editar"
                                    ><i class="material-icons grey-text">create</i></a>
                                    <a class="waves-effect waves-block waves-light detail-button" href="javascript:void(0);" data-coverTrigger="true" data-target='detail_${document.id_documento}'><i class="material-icons">more_vert</i></a>
                                    
                                    <ul class="dropdown-content" id="detail_${document.id_documento}">
                                    <li>
                                        <a class="blue-text text-darken-1" href="${ base_url(['cespidh', 'historial', 'document', document.id_documento]) }">
                                        <i class="material-icons">history</i> Historial
                                        </a>
                                    </li>
                                    <li>
                                        <a class="blue-text text-darken-1" href="${base_url(['cespidh', 'view', 'document', document.id_documento, 1])}" target="_blank">
                                        <i class="material-icons">picture_as_pdf</i> Ver
                                        </a>
                                    </li>
                                    <li>
                                        <a class="blue-text text-darken-1" href="${ base_url(['cespidh', 'view', 'document', document.id_documento, 2]) }" target="_blank">
                                        <i class="material-icons">file_download</i> Descargar
                                        </a>
                                    </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    `;
        }
    });
    $(`#table-${(key+1)} tbody`).html(tbody);
    $('.detail-button').dropdown({
        inDuration: 300,
        outDuration: 225,
        constrainWidth: false,
        hover: false,
        gutter: 0,
        coverTrigger: false,
        alignment: "right",
        hover: false,
        closeOnClick: true,
    });
}

function guardar(key) {
    var data = new URLSearchParams({
        cedula: $(`#id-${key}`).val(),
        name: $(`#name-${key}`).val(),
        ciudad: $(`#ciudad-${key}`).val(),
        direccion: $(`#direccion-${key}`).val(),
        phone: $(`#phone-${key}`).val(),
        email: $(`#email-${key}`).val(),
        genero: $(`.genero-${key} input[name=genero]:checked`).val(),
        etnia: $(`#etnia-${key}`).val(),
    });
    result = proceso_fetch(base_url(['cespidh', 'create', 'user']), data.toString());
    result.then(data => {
        if (data.update) {
            $(`#form-${key}`).submit();
        } else {
            var mensajes = Object.entries(data.messages);
            // console.log(data.messages);
            mensajes.forEach(([key, message]) => {
                alert(`<span class="red-text">${message}</span>`, 'red lighten-5');
            })
        }
    });
}