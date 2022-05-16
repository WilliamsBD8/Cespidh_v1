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
<script src="<?= base_url() ?>/assets/js/vendors.min.js"></script>
<script src="<?= base_url() ?>/assets/js/new_script/formulario.js"></script>
<?= view('layouts/navbar_horizontal') ?>



<div id="main">
  <div class="row">
    <div class="col s12 m12">
      <div class="container">
        <div class="section">
          <!-- Page Length Options -->
          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card-2" id="faq">
                <div class="card-content">
                  <h4 class="center-align"><?= $formulario->title.' - '.$documento->descripcion ?></h4>
                  <form method="POST" action="<?= base_url(['cespidh', 'edit', 'document']) ?>" enctype="multipart/form-data">
                    <input type="hidden" value="<?= $documento->id_documento ?>" name="id_documento">
                    <input type="hidden" value="<?= $formulario->id ?>" name="id_formulario">
                    <ul class="stepper linear" id="linearStepper0">
                      <?php foreach($formulario->secciones as $key_2 => $seccion): ?>
                        <li class="step<?= $key_2 == 0 ? ' active': '' ?>">
                          <div class="step-title waves-effect"><?= mb_strtoupper($seccion->title, 'utf-8') ?></div>
                          <div class="step-content">
                            <div class="row">
                                <?php foreach($seccion->preguntas as $key_3 => $pregunta): ?>
                                  <div class="container">
                                    <?php if($pregunta->tipo_pregunta_id == 1): ?>  <!-- Pregunta Abierta -->
                                      <div class="input-field col m6 s12 ">
                                          <label for="text_<?= $pregunta->id ?>"><?= $pregunta->pregunta ?> <?= $pregunta->obligatorio  == 'Si' ? ':<span class="red-text">*</span>':'' ?></label>
                                          <input type="text" id="text_<?= $pregunta->id ?>" name="<?= $pregunta->campo_formulario?>" class="validate" <?= $pregunta->obligatorio  == 'Si' ? 'required':'' ?> <?= $pregunta->descripcion ? 'placeholder="'.$pregunta->descripcion .'"':'' ?> value="<?= !empty($pregunta->respuesta) ? $pregunta->respuesta[0]->respuesta : '' ?>">
                                      </div>
                                    <?php elseif($pregunta->tipo_pregunta_id == 2): ?> <!-- Pregunta Select -->
                                      <div class="input-field col s12">
                                        <select name="<?= $pregunta->campo_formulario?>" <?= $pregunta->obligatorio  == 'Si' ? 'required':'' ?>>
                                          <option value="" disabled selected>Seleccion opción</option>
                                          <?php foreach($pregunta->detalle as $detalle): ?>
                                            <option value="<?= $detalle->id ?>" <?= $detalle->id == $detalle->respuesta[0]->pregunta_detalle_id ? 'selected':'' ?>><?= $detalle->description ?></option>
                                          <?php endforeach ?>
                                        </select>
                                        <label><?= $pregunta->pregunta ?>:<?= $pregunta->obligatorio  == 'Si' ? '<span class="red-text">*</span>':'' ?></label>
                                      </div>
                                    <?php elseif($pregunta->tipo_pregunta_id == 3): ?> <!-- Pregunta Radio -->
                                      <div class="col s12 ">
                                        <ul class="collapsible categories-collapsible secundario">
                                          <li class="active">
                                              <div class="collapsible-header"><?= $pregunta->pregunta ?><i class="material-icons">
                                                      keyboard_arrow_right </i></div>
                                              <div class="collapsible-body">
                                                <div class="row">
                                                  <?php foreach($pregunta->detalle as $key_detalle => $detalle): ?>
                                                    <p>
                                                      <label>
                                                        <input type="radio" <?= $pregunta->obligatorio  == 'Si' || $key_detalle == 0 ? 'required="required"':'' ?> value="<?= $detalle->id ?>" name="<?= $pregunta->campo_formulario?>" class="with-gap" <?= !empty($detalle->respuesta) ? 'checked':'' ?>/>
                                                        <span><?= $detalle->description ?></span>
                                                      </label>
                                                    </p>
                                                    <div class="pl-3">
                                                      <?php foreach($detalle->detalle as $detalleHijo): ?>
                                                        <?php if($detalleHijo->tipo_pregunta_id == 1): ?>
                                                          <div class="input-field col s12 ">
                                                              <label for="text_<?= $detalleHijo->id ?>"><?= $detalleHijo->description ?></label>
                                                              <input type="text" id="text_<?= $detalleHijo->id ?>" name="<?= $detalleHijo->campo_formulario?>" class="validate"  <?= $pregunta->descripcion ? '':'' ?> <?= !empty($detalleHijo->respuesta) ? 'value="'.$detalleHijo->respuesta[0]->respuesta.'"' : '' ?>>
                                                          </div>
                                                        <?php elseif($detalleHijo->tipo_pregunta_id == 3): ?>
                                                          <p>
                                                            <label>
                                                              <input type="radio" <?= !empty($detalleHijo->respuesta) ? 'checked':'' ?> <?= $pregunta->obligatorio  == 'Si' ? 'required':'' ?> value="<?= $detalleHijo->id ?>" name="<?= $detalle->campo_formulario?>" class="with-gap"/>
                                                              <span><?= $detalleHijo->description ?></span>
                                                            </label>
                                                          </p>
                                                        <?php elseif($detalleHijo->tipo_pregunta_id == 4): ?>
                                                          <p>
                                                            <label>
                                                              <input type="checkbox" <?= !empty($detalleHijo->respuesta) ? 'checked':'' ?> value="<?= $detalleHijo->id ?>" name="<?= $detalle->campo_formulario ?>[]" class="filled-in"/>
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
                                      </div>
                                    <?php elseif($pregunta->tipo_pregunta_id == 4): ?> <!-- Pregunta Checkbox -->
                                      <div class="col s12 ">
                                        <ul class="collapsible categories-collapsible secundario">
                                          <li class="">
                                              <div class="collapsible-header"><?= $pregunta->pregunta ?><?= $pregunta->obligatorio  == 'Si' ? '<span class="red-text">: *</span>':'' ?><i class="material-icons">
                                                      keyboard_arrow_right </i></div>
                                              <div class="collapsible-body">
                                                <div class="row">
                                                  <?php foreach($pregunta->detalle as $detalle): ?>
                                                    <p>
                                                      <label>
                                                        <input type="checkbox" value="<?= $detalle->id ?>" <?= !empty($detalle->respuesta) ? 'checked':'' ?> name="<?= $pregunta->campo_formulario?>[]" class="filled-in"/>
                                                        <span><?= $detalle->description ?></span>
                                                      </label>
                                                    </p>
                                                    <div class="pl-3">
                                                      <?php foreach($detalle->detalle as $detalleHijo): ?>
                                                        <?php if($detalleHijo->tipo_pregunta_id == 1): ?>
                                                          <div class="input-field col s12 ">
                                                              <label for="text_<?= $detalleHijo->id ?>"><?= $detalleHijo->description ?></label>
                                                              <input type="text" id="text_<?= $detalleHijo->id ?>" <?= !empty($detalleHijo->respuesta) ? 'value="'.$detalleHijo->respuesta[0]->respuesta.'"' : '' ?>  name="<?= $detalleHijo->campo_formulario?>" class="validate"  <?= $pregunta->descripcion ? $pregunta->descripcion:'' ?>>
                                                          </div>
                                                        <?php elseif($detalleHijo->tipo_pregunta_id == 3): ?>
                                                          <p>
                                                            <label>
                                                              <input type="radio" <?= !empty($detalleHijo->respuesta) ? 'checked':'' ?> <?= $pregunta->obligatorio  == 'Si' ? 'required':'' ?> value="<?= $detalleHijo->id ?>" name="<?= $detalle->campo_formulario ?>" class="with-gap"/>
                                                              <span><?= $detalleHijo->description ?></span>
                                                            </label>
                                                          </p>
                                                        <?php elseif($detalleHijo->tipo_pregunta_id == 4): ?>
                                                          <p>
                                                            <label>
                                                              <input type="checkbox" <?= !empty($detalleHijo->respuesta) ? 'checked':'' ?> value="<?= $detalleHijo->id ?>" name="<?= $detalle->campo_formulario ?>[]" class="filled-in"/>
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
                                      </div>
                                    <?php elseif($pregunta->tipo_pregunta_id == 5): ?> <!-- Pregunta Lista texto -->
                                      <div class="col s12 ">
                                        <ul class="collapsible categories-collapsible secundario">
                                          <li class="">
                                              <div class="collapsible-header"><?= $pregunta->pregunta ?><i class="material-icons">
                                                      keyboard_arrow_right </i></div>
                                              <div class="collapsible-body">
                                                <div class="row">
                                                  <div class="input-field col s12">
                                                    <textarea id="<?= $pregunta->campo_formulario ?>" class="materialize-textarea"></textarea>
                                                    <label for="<?= $pregunta->campo_formulario ?>"><?= $pregunta->descripcion ?></label>
                                                  </div>
                                                  <div class="col m4 s12 mb-3">
                                                      <button class="waves-effect waves btn btn-primary agg-edit_<?= $pregunta->campo_formulario ?>" onclick="add_list(<?= $pregunta->id ?>, '<?= $pregunta->campo_formulario ?>')" type="button">
                                                          <i class="material-icons left">check</i>Agregar
                                                      </button>
                                                  </div>
                                                </div>
                                                
                                                <input type="hidden" id="<?= $pregunta->campo_formulario ?>_hechos" name="<?= $pregunta->campo_formulario?>" value="">
                                                <table class="Highlight centered responsive-table" id="pregunta_<?= $pregunta->id ?>">
                                                  <thead>
                                                    <tr>
                                                      <th><?= $pregunta->titulo ?></th>
                                                      <th>Accion</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    <?php foreach ($pregunta->respuesta as $key => $respuesta): ?>
                                                      <tr id="pregunta_<?= $pregunta->id ?>_<?= ($key+1) ?>">
                                                        <td class="detalle"><?= $respuesta->respuesta ?></td>
                                                        <td>
                                                          <a class="btn-floating mb-1 edit" onclick="edit_list('<?= $pregunta->id ?>', <?= ($key+1) ?>, '<?= $pregunta->campo_formulario ?>')"><i class="material-icons">create</i></a>
                                                          <a class="btn-floating mb-1 delete" onclick="delete_list('pregunta_<?= $pregunta->id ?>', <?= ($key+1) ?>, '<?= $pregunta->campo_formulario ?>')"><i class="material-icons">close</i></a>
                                                        </td>
                                                      </tr>
                                                      <script>
                                                          add_edit('<?= $pregunta->id ?>', '<?= $respuesta->respuesta ?>', '<?= $pregunta->campo_formulario ?>');
                                                      </script>
                                                    <?php endforeach ?>
                                                  </tbody>
                                                </table>
                                              </div>
                                          </li>
                                        </ul>
                                      </div>
                                    
                                    <?php elseif($pregunta->tipo_pregunta_id == 6): ?> <!-- Pregunta Lista Documento -->
                                      <ul class="collapsible categories-collapsible secundario">
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
                                                              <button class="btn btn-primary" type="button" onclick="agg_anexo('<?= $pregunta->campo_formulario?>', <?= $pregunta->id ?>)">Agregar nuevo
                                                                <i class="material-icons right">check</i>
                                                              </button>
                                                          </div>
                                                          <div class="row app-file-recent-access mb-3 pruebas-anexos" id="pruebas_anexos_<?= $pregunta->id ?>">
                                                              <?php foreach($pregunta->respuesta as $key => $respuesta): ?>
                                                                <div class="col l4 s12 anexo">
                                                                  <div class="card box-shadow-none mb-1 app-file-info">
                                                                      <div class="card-content">
                                                                        <div class="app-file-content-logo grey lighten-4">
                                                                            <i class="material-icons">attach_file</i>
                                                                        </div>
                                                                        <div class="app-file-recent-details">
                                                                            <div class="icons-pruebas">
                                                                                <a href="#!" class="indigo-text font-weight-600" onclick="prueba_delete(this, <?= $pregunta->id ?>)"><i class="material-icons">close</i></a>
                                                                                <a target="_blank" href="<?= base_url(['img', 'files', $respuesta->documento]) ?>" class="indigo-text font-weight-600"><i class="material-icons">cloud_download</i></a>
                                                                            </div>
                                                                            <div class="row">
                                                                              <div class="file-field input-field col s12">
                                                                                <div class="btn large">
                                                                                  <span>Archivo</span>
                                                                                  <input type="file" id="input_prueba_<?= $pregunta->id ?>" name="<?= $pregunta->campo_formulario?>[]">
                                                                                </div>
                                                                                <div class="file-path-wrapper">
                                                                                  <input class="file-path validate" type="text" value="<?= $respuesta->documento ?>"  placeholder="Nombre parcial del archivo">
                                                                                  <input type="hidden" name="respuesta_<?= $pregunta->id ?>[]" value="<?= $respuesta->id ?>">
                                                                                </div>
                                                                              </div>
                                                                              <div class="file-field input-field col s12">
                                                                                <input placeholder="Nombre del archivo" value="<?= $respuesta->respuesta ?>" id="input_name_<?= $pregunta->id ?>" type="text" class="validate" name="<?= $pregunta->campo_formulario?>_names[]">
                                                                              </div>
                                                                            </div>
                                                                        </div>
                                                                      </div>
                                                                  </div>
                                                                </div>
                                                              <?php endforeach ?>
                                                          </div>
                                                    </div>
                                                  </div>
                                              </div>
                                          </div>
                                        </li>
                                      </ul>
                                    <?php endif ?>
                                  </div>
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
                                    <?php if($key_2 != (count($formulario->secciones) - 1)): ?>
                                      <div class="col m4 s12 mb-3">
                                          <button class="waves-effect waves dark btn btn-primary next-step" type="submit">
                                              Siguiente
                                              <i class="material-icons right">arrow_forward</i>
                                          </button>
                                      </div>
                                    <?php else: ?>
                                      <div class="col m4 s12 mb-1">
                                        <button class="waves-effect waves-dark btn btn-primary" type="submit">Submit</button>
                                      </div>
                                    <?php endif ?>
                                  </div>
                              </div>
                          </div>
                        </li>
                      <?php endforeach ?>
                      <!-- <li class="step">
                        <div class="step-title waves-effect">¿QUIÉN PRESENTA LA PETICION?</div>
                        <div class="step-content">
                            <div class="row">
                                <div class="input-field col m6 s12">
                                    <label for="name">Nombre: <span class="red-text">*</span></label>
                                    <input type="text" class="validate" id="name" name="name" required value="<?= session('user')->name ?>">
                                </div>
                                <div class="input-field col m6 s12">
                                    <label for="id">Cedula: <span class="red-text">*</span></label>
                                    <input type="number" class="validate" id="id" name="id" required value="<?= session('user')->id ?>">
                                </div>
                                <div class="input-field col m6 s12">
                                    <label for="ciudad">Ciudad: <span class="red-text">*</span></label>
                                    <input type="text" class="validate" id="ciudad" name="ciudad" required value="<?= session('user')->ciudad ?>">
                                </div>
                                <div class="input-field col m6 s12">
                                    <label for="direccion">Dirección: <span class="red-text">*</span></label>
                                    <input type="text" class="validate" id="eventName1" name="direccion" required value="<?= session('user')->direccion ?>">
                                </div>
                                <div class="input-field col m6 s12">
                                    <label for="phone">Numero de telefono</label>
                                    <input type="text" class="" id="phone" name="phone" value="<?= session('user')->phone ?>">
                                </div>
                                <div class="input-field col m6 s12">
                                    <label for="email">Correo electronico: <span class="red-text">*</span></label>
                                    <input type="email" class="validate" id="email" name="email" required value="<?= session('user')->email ?>">
                                </div>
                                <div class="input-field col m6 s12">
                                  <?php foreach($generos as $genero): ?>
                                    <p>
                                      <label>
                                        <input class="with-gap" value="<?= $genero->id ?>" name="genero" type="radio" <?= $genero->id == session('user')->genero_id ? 'checked':'' ?>/>
                                        <span><?= $genero->name ?></span>
                                      </label>
                                    </p>
                                  <?php endforeach ?>
                                </div>
                                <div class="input-field col m6 s12">
                                  <select name="etnia">
                                    <option value="" disabled>Seleccione uno</option>
                                    <?php foreach ($etnias as $etnia): ?>
                                      <option value="<?= $etnia->id ?>" <?= $genero->id == session('user')->genero_id ? 'selected':'' ?>><?= $etnia->name ?></option>
                                    <?php endforeach ?>
                                    </select>
                                  <label>¿Con cual de estos grupos te identificas?</label>
                                </div>
                                <div class="input-field col m6 s12">
                                  <p>
                                    <label>
                                      <input type="checkbox" name="autoriza"/>
                                      <span>Autoriza firma (Crear firma digital)</span>
                                    </label>
                                  </p>
                                  <p>
                                    <label>
                                      <input type="checkbox" name="condiciones"/>
                                      <span>Acepta términos y condiciones</span>
                                    </label>
                                  </p>
                                  <p>
                                    <label>
                                      <input type="checkbox" name="help_<?= $formulario->id ?>"/>
                                      <span>Necesita ayuda en el proceso de verificación del documento</span>
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
                      </li> -->
                    </ul>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




<script src="<?= base_url() ?>/assets/js/new_script/funciones.js"></script>

<!-- BEGIN VENDOR JS-->

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


    <!-- END PAGE LEVEL JS-->
  

<?= view('layouts/footer') ?>