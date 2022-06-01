$(document).ready(function() {
    const documents = documentos();
    const cedulas = cedulas_aux();
    const sedes = sedes_aux();
    $('input.autocomplete-name').autocomplete({
        data: documents,
    });
    $('input.autocomplete-id').autocomplete({
        data: cedulas,
    });
    $('input.autocomplete-sedes').autocomplete({
        data: sedes,
    });
})