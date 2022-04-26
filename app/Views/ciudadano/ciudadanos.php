<?= view('layouts/header') ?>
<!-- <?= view('layouts/navbar_vertical') ?> -->

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/data-tables.css">

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/flag-icon/css/flag-icon.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/data-tables/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/data-tables/css/select.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/materialize-stepper/materialize-stepper.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/form-wizard.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/css/table.css">


<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/page-faq.css">


<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/sweetalert/sweetalert.css">


<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/app-file-manager.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/widget-timeline.css">
<?= view('layouts/navbar_horizontal') ?>

<div id="main">
  <div class="row">
    <div class="pt-1 pb-0" id="breadcrumbs-wrapper">
      <!-- Search for small screen-->
      <div class="container">
        <div class="row">
          <div class="col s12 m6 l6">
            <h5 class="breadcrumbs-title"><span>Documentos</span></h5>
          </div>
          <div class="col s12 m6 l6 right-align-md">
            <ol class="breadcrumbs mb-0">
              <li class="breadcrumb-item"><a href="<?= $base_url ?>">Home</a></li>
              <li class="breadcrumb-item active">Documentos</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="col s12">
      <div class="container">
        <div class="section section-data-tables">
          <!-- Page Length Options -->
          <div class="row">
            <div class="col s12">
                <div class="card-3" id="faq">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12">
                              <ul class="tabs">
                                <li class="tab col m6"><a href="#new" class="active">Nuevo Documento</a></li>                                
                                <li class="tab col m6"><a href="#show">Documentos</a></li>
                              </ul>                              
                            </div>
                            <div id="new" class="col s12">
                              <div class="section" id="faq">
                                    <div class="faq row">
                                        <div class="col s12 l12">
                                            <ul class="collapsible categories-collapsible">
                                              <?php foreach($formularios as $key => $formulario): ?>
                                                <li class="">
                                                    <div class="collapsible-header">
                                                      <?= $formulario->descripcion ?>
                                                      <i class="material-icons">keyboard_arrow_right </i>
                                                    </div>
                                                    <div class="collapsible-body">
                                                      <ul class="stepper linear" id="linearStepper<?= $key ?>">
                                                        <?php foreach($formulario->secciones as $key_2 => $seccion): ?>
                                                          <li class="step<?= $key_2 == 0 ? ' active': '' ?>">
                                                            <div class="step-title waves-effect"><?= mb_strtoupper($seccion->title, 'utf-8') ?></div>
                                                            <div class="step-content">
                                                                <div class="row">
                                                                    <?php foreach($seccion->preguntas as $key_3 => $pregunta): ?>
                                                                      <?php if($pregunta->tipo_pregunta_id == 1): ?>  <!-- Pregunta Abierta -->
                                                                        <div class="input-field col m6 s12">
                                                                            <label for="text_<?= $pregunta->id ?>"><?= $pregunta->pregunta ?>: <?= $pregunta->obligatorio  == 'Si' ? '<span class="red-text">*</span>':'' ?></label>
                                                                            <input type="text" id="text_<?= $pregunta->id ?>" name="firstName1" class="validate" <?= $pregunta->obligatorio  == 'Si' ? 'required':'' ?> placeholder="<?= $pregunta->descripcion ?>">
                                                                        </div>
                                                                      <?php elseif($pregunta->tipo_pregunta_id == 2): ?> <!-- Pregunta Select -->
                                                                        <div class="input-field col s12">
                                                                          <select>
                                                                            <option value="" disabled selected>Seleccion opción</option>
                                                                            <?php foreach($pregunta->detalle as $detalle): ?>
                                                                              <option value="1"><?= $detalle->description ?></option>
                                                                            <?php endforeach ?>
                                                                          </select>
                                                                          <label><?= $pregunta->pregunta ?></label>
                                                                        </div>
                                                                      <?php elseif($pregunta->tipo_pregunta_id == 3): ?> <!-- Pregunta Radio -->
                                                                        <ul class="collapsible categories-collapsible">
                                                                          <li class="">
                                                                              <div class="collapsible-header"><?= $pregunta->pregunta ?><i class="material-icons">
                                                                                      keyboard_arrow_right </i></div>
                                                                              <div class="collapsible-body">
                                                                                <div class="row">
                                                                                  <?php foreach($pregunta->detalle as $detalle): ?>
                                                                                    <p>
                                                                                      <label>
                                                                                        <input type="radio" name="group1" class="with-gap"/>
                                                                                        <span><?= $detalle->description ?></span>
                                                                                      </label>
                                                                                    </p>
                                                                                    <div class="pl-3">
                                                                                      <?php foreach($detalle->detalle as $detalleHijo): ?>
                                                                                        <?php if($detalleHijo->tipo_pregunta_id == 3): ?>
                                                                                          <p>
                                                                                            <label>
                                                                                              <input type="radio" name="group2" class="with-gap"/>
                                                                                              <span><?= $detalleHijo->description ?></span>
                                                                                            </label>
                                                                                          </p>
                                                                                        <?php elseif($detalleHijo->tipo_pregunta_id == 4): ?>
                                                                                          <p>
                                                                                            <label>
                                                                                              <input type="checkbox" class="filled-in"/>
                                                                                              <span><?= $detalleHijo->description ?></span>
                                                                                            </label>
                                                                                          </p>
                                                                                        <?php endif ?>
                                                                                      <?php endforeach ?>
                                                                                    </div>
                                                                                  <?php endforeach ?>
                                                                                </div>
                                                                          </li>
                                                                        </ul>
                                                                      <?php elseif($pregunta->tipo_pregunta_id == 4): ?> <!-- Pregunta Checkbox -->
                                                                        <ul class="collapsible categories-collapsible">
                                                                          <li class="">
                                                                              <div class="collapsible-header"><?= $pregunta->pregunta ?><i class="material-icons">
                                                                                      keyboard_arrow_right </i></div>
                                                                              <div class="collapsible-body">
                                                                                <div class="row">
                                                                                  <?php foreach($pregunta->detalle as $detalle): ?>
                                                                                    <p>
                                                                                      <label>
                                                                                        <input type="checkbox" class="filled-in"/>
                                                                                        <span><?= $detalle->description ?></span>
                                                                                      </label>
                                                                                    </p>
                                                                                    <div class="pl-3">
                                                                                      <?php foreach($detalle->detalle as $detalleHijo): ?>
                                                                                        <?php if($detalleHijo->tipo_pregunta_id == 3): ?>
                                                                                          <p>
                                                                                            <label>
                                                                                              <input type="radio" name="group2" class="with-gap"/>
                                                                                              <span><?= $detalleHijo->description ?></span>
                                                                                            </label>
                                                                                          </p>
                                                                                        <?php elseif($detalleHijo->tipo_pregunta_id == 4): ?>
                                                                                          <p>
                                                                                            <label>
                                                                                              <input type="checkbox" class="filled-in"/>
                                                                                              <span><?= $detalleHijo->description ?></span>
                                                                                            </label>
                                                                                          </p>
                                                                                        <?php endif ?>
                                                                                      <?php endforeach ?>
                                                                                    </div>
                                                                                  <?php endforeach ?>
                                                                                </div>
                                                                          </li>
                                                                        </ul>
                                                                      <?php elseif($pregunta->tipo_pregunta_id == 5): ?> <!-- Pregunta Lista texto -->
                                                                        <ul class="collapsible categories-collapsible">
                                                                          <li class="">
                                                                              <div class="collapsible-header"><?= $pregunta->pregunta ?><i class="material-icons">
                                                                                      keyboard_arrow_right </i></div>
                                                                              <div class="collapsible-body">
                                                                                <div class="row">
                                                                                  <div class="input-field col s12">
                                                                                    <textarea id="pregunta_<?= $pregunta->id ?>_question" class="materialize-textarea"></textarea>
                                                                                    <label for="pregunta_<?= $pregunta->id ?>_question"><?= $pregunta->descripcion ?></label>
                                                                                  </div>
                                                                                  <div class="col m4 s12 mb-3">
                                                                                      <button class="waves-effect waves btn btn-primary" onclick="add_list(<?= $pregunta->id ?>)" type="button">
                                                                                          <i class="material-icons left">check</i>Agregar
                                                                                      </button>
                                                                                  </div>
                                                                                </div>
                                                                                <table class="Highlight centered responsive-table" id="pregunta_<?= $pregunta->id ?>">
                                                                                  <thead>
                                                                                    <tr>
                                                                                      <th><?= $pregunta->titulo ?></th>
                                                                                      <th>Accion</th>
                                                                                    </tr>
                                                                                  </thead>
                                                                                  <tbody>
                                                                                  </tbody>
                                                                                </table>
                                                                              </div>
                                                                          </li>
                                                                        </ul>
                                                                      
                                                                      <?php elseif($pregunta->tipo_pregunta_id == 6): ?> <!-- Pregunta Lista Documento -->
                                                                        <ul class="collapsible categories-collapsible">
                                                                          <li>
                                                                            <div class="collapsible-header"><?= $pregunta->pregunta ?> <i class="material-icons">
                                                                                    keyboard_arrow_right </i></div>
                                                                            <div class="collapsible-body pruebas">
                                                                                <div class="content-right">
                                                                                  <!-- file manager main content start -->
                                                                                    <div class="app-file-area">
                                                                                        <div class="app-file-content">
                                                                                            <div class="titles-pruebas">
                                                                                                <h6 class="font-weight-700 mb-3"><?= $pregunta->descripcion ?></h6>
                                                                                                  <div class="file-field input-field">
                                                                                                      <div class="btn">
                                                                                                          <span>Cargar archivo</span>
                                                                                                          <input type="file" multiple="multiple" id="input_prueba_<?= $pregunta->id ?>" onchange="add_prueba(<?= $pregunta->id ?>)">
                                                                                                      </div>
                                                                                                      <div class="file-path-wrapper">
                                                                                                          <input class="file-path validate" id="names_pruebas_<?= $pregunta->id ?>" type="text" placeholder="<?= $pregunta->titulo ?>">
                                                                                                      </div>
                                                                                                    </div>
                                                                                                    <!-- <div class="col s12 mb-3">
                                                                                                        <button class="waves-effect waves btn btn-primary" onclick="add_prueba(<?= $pregunta->id ?>)" type="button">
                                                                                                            <i class="material-icons left">check</i>Agregar
                                                                                                        </button>
                                                                                                    </div> -->
                                                                                            </div>
                                                                                          <!-- App File - Recent Accessed Files Section Starts -->
                                                                                            <div class="row app-file-recent-access mb-3 pruebas-anexos" id="pruebas_anexos_<?= $pregunta->id ?>">
                                                                                                
                                                                                            </div>
                                                                                      </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                          </li>
                                                                        </ul>
                                                                      <?php endif ?>
                                                                    <?php endforeach ?>
                                                                </div>
                                                                <div class="step-actions">
                                                                    <div class="row">
                                                                      <?php if($key_2 > 0): ?>
                                                                        <div class="col m4 s12 mb-3">
                                                                            <button class="red btn btn-reset" type="reset">
                                                                                <i class="material-icons left">clear</i>Reset
                                                                            </button>
                                                                        </div>
                                                                        <div class="col m4 s12 mb-3">
                                                                            <button class="btn btn-light previous-step">
                                                                                <i class="material-icons left">arrow_back</i>
                                                                                Anterior
                                                                            </button>
                                                                        </div>
                                                                      <?php endif ?>
                                                                        <div class="col m4 s12 mb-3">
                                                                            <button class="waves-effect waves dark btn btn-primary next-step" type="submit">
                                                                                Siguiente
                                                                                <i class="material-icons right">arrow_forward</i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                          </li>
                                                        <?php endforeach ?>
                                                        <li class="step">
                                                            <div class="step-title waves-effect">¿QUIÉN PRESENTA LA PETICION?</div>
                                                            <div class="step-content">
                                                                <div class="row">
                                                                    <div class="input-field col m6 s12">
                                                                        <label for="eventName1">Nombre: <span class="red-text">*</span></label>
                                                                        <input type="text" class="validate" id="eventName1" name="eventName1" required>
                                                                    </div>
                                                                    <div class="input-field col m6 s12">
                                                                        <label for="cedula">Cedula: <span class="red-text">*</span></label>
                                                                        <input type="number" class="validate" id="cedula" name="cedula" required>
                                                                    </div>
                                                                    <div class="input-field col m6 s12">
                                                                        <label for="ciudad">Ciudad: <span class="red-text">*</span></label>
                                                                        <input type="text" class="validate" id="ciudad" name="ciudad" required>
                                                                    </div>
                                                                    <div class="input-field col m6 s12">
                                                                        <label for="direccion">Dirección: <span class="red-text">*</span></label>
                                                                        <input type="text" class="validate" id="eventName1" name="direccion" required>
                                                                    </div>
                                                                    <div class="input-field col m6 s12">
                                                                        <input placeholder="Placeholder" id="phone-input" type="text" class="">
                                                                        <label for="phone-input">Phone Number</label>
                                                                    </div>
                                                                    <div class="input-field col m6 s12">
                                                                        <label for="correo">Correo electronico: <span class="red-text">*</span></label>
                                                                        <input type="email" class="validate" id="correo" name="correo" required>
                                                                    </div>
                                                                    <div class="input-field col m6 s12">
                                                                      <?php foreach($generos as $genero): ?>
                                                                        <p>
                                                                          <label>
                                                                            <input class="with-gap" name="group1" type="radio"/>
                                                                            <span><?= $genero->name ?></span>
                                                                          </label>
                                                                        </p>
                                                                      <?php endforeach ?>
                                                                    </div>
                                                                    <div class="input-field col m6 s12">
                                                                      <select>
                                                                        <option value="" disabled selected>Seleccione uno</option>
                                                                        <?php foreach ($etnias as $etnia): ?>
                                                                          <option value="<?= $etnia->id ?>"><?= $etnia->name ?></option>
                                                                        <?php endforeach ?>
                                                                      <label>¿Con cual de estos grupos te identificas?</label>
                                                                    </div>
                                                                    <div class="input-field col m6 s12">
                                                                    <p>
                                                                      <label>
                                                                        <input type="checkbox"/>
                                                                        <span>Autoriza firma (Crear firma digital)</span>
                                                                      </label>
                                                                    </p>
                                                                    <p>
                                                                      <label>
                                                                        <input type="checkbox"/>
                                                                        <span>Acepta términos y condiciones</span>
                                                                      </label>
                                                                    </p>
                                                                    </div>
                                                                </div>
                                                                <div class="step-actions">
                                                                    <div class="row">
                                                                        <div class="col m4 s12 mb-1">
                                                                            <button class="red btn mr-1 btn-reset" type="reset">
                                                                                <i class="material-icons">clear</i>
                                                                                Reset
                                                                            </button>
                                                                        </div>
                                                                        <div class="col m4 s12 mb-3">
                                                                            <button class="btn btn-light previous-step">
                                                                                <i class="material-icons left">arrow_back</i>
                                                                                Anterior
                                                                            </button>
                                                                        </div>
                                                                        <div class="col m4 s12 mb-1">
                                                                            <button class="waves-effect waves-dark btn btn-primary" type="submit">Submit</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                      </ul>
                                                    </div>
                                                </li>                                                
                                              <?php endforeach ?>
                                            </ul>                                            
                                        </div>
                                    </div>
                              </div>
                            </div>
                            <div id="show" class="col s12">
                            <table id="table-rechazada" class="display">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Cedula</th>
                                            <th>Tipo de Documento</th>
                                            <th>Estado</th>
                                            <th>Entidad</th>
                                            <th>Colaborador</th>
                                            <th>Fecha</th>
                                            <!-- <th>Acciones</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php foreach($documents as $document): ?>
                                        <tr>
                                            <td><?= $document['id'] ?></td>
                                            <td><?= $document['name'] ?></td>
                                            <td><?= $document['cedula'] ?></td>
                                            <td><?= $document['document'] ?></td>
                                            <td><?= $document['status'] ?></td>
                                            <td><?= $document['entidad'] ?></td>
                                            <td><?= $document['colaborador'] == 0 ? 'No necesita': 'William Bonilla' ?></td>
                                            <td><?= $document['date'] ?></td>
                                            <!-- <td class="center-align">
                                              <a class="tooltipped" href="<?= $base_url ?>/table-edit.php" data-position="bottom" data-tooltip="Editar"><i class="material-icons grey-text">create</i></a>
                                              <a class="modal-trigger" href="#modal2"><i class="material-icons grey-text">more_vert</i></a>
                                            </td> -->
                                        </tr>
                                      <?php endforeach ?>
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Cedula</th>
                                            <th>Tipo de Documento</th>
                                            <th>Estado</th>
                                            <th>Entidad</th>
                                            <th>Colaborador</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Structure -->
<!-- <div id="modal2" class="modal option modal-fixed-footer">
  <div class="modal-content options">
    <h4>Mas opciones</h4>
    <div class="mb-3 center">
      <p>
        <a href="<?= $base_url ?>/table-detail.php"
          class="mb-12 waves-effect waves-light btn blue lighten-4 blue-text"><i class="material-icons left">history</i> Historial</a>
      </p>
      <p>
        <a class="mb-12 waves-effect waves-light btn blue lighten-4 blue-text"><i class="material-icons left">file_download</i> Descargar</a>
      </p>
      <p>
        <a class="mb-12 waves-effect waves-light btn blue lighten-4 blue-text" ><i class="material-icons left">delete</i> Eliminar</a>
      </p>
      <p>
        <a class="mb-12 waves-effect waves-light btn blue lighten-4 blue-text"><i class="material-icons left">done</i> Publicar</a>
      </p>
    </div>
  </div>
</div> -->




<!-- BEGIN VENDOR JS-->
<script src="<?= base_url() ?>/assets/js/vendors.min.js"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="<?= base_url() ?>/assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>/assets/vendors/data-tables/js/dataTables.select.min.js"></script>

<script src="<?= base_url() ?>/assets/vendors/materialize-stepper/materialize-stepper.min.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN THEME  JS-->
<script src="<?= base_url() ?>/assets/js/plugins.js"></script>
<script src="<?= base_url() ?>/assets/js/search.js"></script>
<script src="<?= base_url() ?>/assets/js/custom/custom-script.js"></script>
<script src="<?= base_url() ?>/assets/js/scripts/data-tables.js"></script>

    
<script src="<?= base_url() ?>/assets/vendors/sweetalert/sweetalert.min.js"></script>
    
<script src="<?= base_url() ?>/assets/js/scripts/extra-components-sweetalert.js"></script>
<script>
  $(document).ready(function(){
    $('.tooltipped').tooltip();
    $('.dropdown-trigger').dropdown({
      constrainWidth: false, // Does not change width of dropdown to that of the activator
      alignment: 'center', // Displays dropdown with edge aligned to the left of button
    });
    $('.modal').modal();
  });

  function delete_document(id){
    swal({
      title: `¿Esta seguro de eliminar el Documento # ${id}?`,
      icon: 'warning',
      dangerMode: true,
      buttons: {
        cancel: 'No',
        delete: 'Si'
      }
    }).then(function (willDelete) {
      if (willDelete) {
        swal(`El Documento # ${id}!`, {
          icon: "success",
        });
      } else {
        swal("Your imaginary file is safe", {
          title: 'Cancelled',
          icon: "error",
        });
      }
    });
  }
</script>

<!-- BEGIN PAGE LEVEL JS-->
<script src="<?= base_url() ?>/assets/js/scripts/form-wizard.js"></script>


<script src="<?= base_url() ?>/assets/vendors/formatter/jquery.formatter.min.js"></script>

<script src="<?= base_url() ?>/assets/js/scripts/form-masks.js"></script>

<script src="<?= base_url() ?>/assets/js/new_script/formulario.js"></script>
    <!-- END PAGE LEVEL JS-->
  

<?= view('layouts/footer') ?>