const array_list = [];

function delete_list(pregunta, id) {
    $(`#${pregunta}_${id}`).hide();
}

function add_list(id) {
    var value = $(`#pregunta_${id}_question`).val();
    if (array_list[`pregunta_${id}`] == undefined)
        array_list[`pregunta_${id}`] = [];
    array_list[`pregunta_${id}`].push(value);
    var list = '';
    array_list[`pregunta_${id}`].forEach((pregunta, key) => {
        list += `
          <tr id="pregunta_${id}_${(key+1)}">
            <td>${pregunta}</td>
            <td>
              <a class="btn-floating mb-1 waves-effect waves-light"><i class="material-icons">create</i></a>
              <a class="btn-floating mb-1 waves-effect waves-light" onclick="delete_list('pregunta_${id}', ${(key+1)})"><i class="material-icons">close</i></a>
            </td>
          </tr>
        `;
    })
    $(`#pregunta_${id} tbody`).html(list);
    $(`#pregunta_${id}_question`).val('')
    M.updateTextFields();
}

const names = [];

function add_prueba(id) {
    var files = $(`#input_prueba_${id}`).prop("files");
    if (names[`prueba_${id}`] == undefined)
        names[`prueba_${id}`] = [];
    var aux_names = $.map(files, function(val) { return val.name; });
    var names_text = '';
    aux_names.forEach(aux_name => {
        names[`prueba_${id}`].push(aux_name);
    })
    var pruebas = '';
    names[`prueba_${id}`].forEach((name, key) => {
        names_text += `${name},`;
        pruebas += `
          <div class="col l4 s12" id="prueba_${id}_${(key+1)}">
              <div class="card box-shadow-none mb-1 app-file-info">
                  <div class="card-content">
                    <div class="app-file-content-logo grey lighten-4">
                        <i class="material-icons">attach_file</i>
                    </div>
                    <div class="app-file-recent-details">
                        <div class="icons-pruebas">
                            <a href="#!" class="indigo-text font-weight-600"><i class="material-icons">file_download</i></a>
                            <a href="#!" class="indigo-text font-weight-600" onclick="prueba_delete('${id}', ${(key+1)})"><i class="material-icons">close</i></a>
                        </div>
                        <p>Nombre: ${name}</p>
                    </div>
                  </div>
              </div>
          </div>`;
    });
    $(`#pruebas_anexos_${id}`).html(pruebas);
}

function prueba_delete(prueba, id) {
    names[`prueba_${prueba}`].splice((id - 1), 1);
    $(`#prueba_${prueba}_${id}`).hide();
}