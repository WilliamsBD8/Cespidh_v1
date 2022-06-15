<?= view('layouts/header') ?>
<script src="<?= base_url() ?>/assets/js/new_script/formulario.js"></script>
<?= view('layouts/navbar_horizontal') ?>



<div id="main">
  <div class="row">
    <div class="col s12 m12">
      <div class="container">
        <h4 class="card-title center-align"><?= $formulario->title ?> - Documento <?= $documento->abreviacion.'-'.$documento->id_documento ?></h4>
        <p class="card-title center-align"><b><?= $documento->descripcion ?></b></p>
        <div class="row">
          <div class="col s12">
            <ul class="tabs">
              <li class="tab col m6"><a class="active" href="#edit">Editar documento</a></li>
              <li class="tab col m6"><a href="#new">Cargar nuevo documento</a></li>
            </ul>
          </div>
        </div>
          <!-- Editar -->
        <div class="section" id="edit">
          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card-2" id="faq">
                <div class="card-content">
                  <form id="form-edit" method="POST" action="<?= base_url(['cespidh', 'edit', 'document']) ?>" enctype="multipart/form-data">
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
                                <input type="hidden" name="id" id="id">
                                  <div class="input-field col m6 s12">
                                      <label for="cedula">Cedula: <span class="red-text">*</span></label>
                                      <input required type="text" class="validate autocomplete-usuarios_form" id="cedula" name="cedula">
                                  </div>
                                  <div class="input-field col m6 s12">
                                      <label for="name">Nombre: <span class="red-text">*</span></label>
                                      <input type="text" class="validate" id="name" name="name" required>
                                  </div>
                                  <div class="input-field col m6 s12">
                                      <label for="ciudad">Ciudad: <span class="red-text">*</span></label>
                                      <input required type="text" class="validate" id="ciudad" name="ciudad">
                                  </div>
                                  <div class="input-field col m6 s12">
                                      <label for="direccion">Dirección: <span class="red-text">*</span></label>
                                      <input required type="text" class="validate" id="direccion" name="direccion">
                                  </div>
                                  <div class="input-field col m6 s12">
                                      <label for="phone">Numero de telefono: <span class="red-text">*</span></label>
                                      <input required type="text" class="phone-input" id="phone" name="phone">
                                  </div>
                                  <div class="input-field col m6 s12">
                                      <label for="email">Correo electronico: <span class="red-text">*</span></label>
                                      <input required type="email" class="validate" id="email" name="email">
                                  </div>
                                  <div class="input-field col m6 s12">
                                    <?php foreach($generos as $genero): ?>
                                      <p>
                                        <label>
                                          <input id="genero_<?= $genero->id ?>" class="with-gap genero" value="<?= $genero->id ?>" name="genero" type="radio"/>
                                          <span><?= $genero->name ?></span>
                                        </label>
                                      </p>
                                    <?php endforeach ?>
                                  </div>
                                  <div class="input-field col m6 s12">
                                    <select name="etnia" id="etnia">
                                      <option id="etnia_vacio" selected value="" disabled>Seleccione grupo etnico</option>
                                      <?php foreach ($etnias as $etnia): ?>
                                        <option id="etnia_<?= $etnia->id ?>" value="<?= $etnia->id ?>"><?= $etnia->name ?></option>
                                      <?php endforeach ?>
                                      </select>
                                    <label>¿Con cual de estos grupos te identificas?</label>
                                  </div>
                                  <div class="input-field col m6 s12">
                                    <p>
                                      <label>
                                        <input type="checkbox" name="firma_<?= $formulario->id ?>" <?= $documento->firma == 'on' ? 'checked':'' ?>/>
                                        <span>Autoriza firma (Crear firma digital)</span>
                                      </label>
                                    </p>
                                    <p>
                                      <label>
                                        <input type="checkbox" name="terminos_<?= $formulario->id ?>" <?= $documento->terminos == 'on' ? 'checked':'' ?>/>
                                        <span>Acepta términos y condiciones  <a href="javascript:void(0)" onclick="terminos();">Ver</a></span>
                                      </label>
                                    </p>
                                    <p>
                                      <label>
                                        <input type="checkbox" name="help_<?= $formulario->id ?>" <?= $documento->help == 'on' ? 'checked':'' ?>/>
                                        <span>Necesita ayuda en el proceso de verificación del documento</span>
                                      </label>
                                    </p>
                                  </div>
                              </div>
                              <div class="step-actions">
                                  <div class="row">
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
                                      <div class="col m4 s12 mb-3">
                                          <button class="waves-effect waves dark btn btn-primary" id="btn-update" onclick="update_user(<?= $key_2 ?>)" type="button">
                                              Siguiente
                                              <i class="material-icons right">arrow_forward</i>
                                          </button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </li>
                      <li class="step">
                        <div class="step-title waves-effect">Motivo de la edición</div>
                        <div class="step-content">
                            <div class="row">
                              <div class="input-field">
                                <textarea id="observation" class="materialize-textarea" name="observation"></textarea>
                                <label for="observation">Motivo</label>
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
                                        <button class="waves-effect waves-dark btn btn-primary" type="button" onclick="guardar()">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </li>
                    </ul>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="new">
          <div class="row section padding-4">
            <form id="new_document" action="<?= base_url(['cespidh', 'edit', 'new_document']) ?>" enctype='multipart/form-data' method="post">
              <input type="hidden" name="id_documento" value="<?= $documento->id_documento ?>">
              <div class="col s12">
                <input type="file" name="new_document" id="input-file-now" class="dropify-Es" data-default-file="" data-allowed-file-extensions="pdf docx" />
              </div>
              <div class="input-field col s12">
                <textarea id="motivo" class="materialize-textarea" name="observation"></textarea>
                <label for="motivo">Motivo/Observación</label>
              </div>
            </form>
            <div class="col s12">
              <div class="div-center pb-1">
                <button class="btn waves-effect waves-light blue" onclick="new_document()">Filtrar
                  <i class="material-icons right">send</i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- END PAGE LEVEL JS-->


<?= view('layouts/footer_libre') ?>
<script>
  $(document).ready(function(){
    $('.tooltipped').tooltip();
    $('.dropdown-trigger').dropdown({
      constrainWidth: false, // Does not change width of dropdown to that of the activator
      alignment: 'center', // Displays dropdown with edge aligned to the left of button
    });
    $('.modal').modal();
  });
  function user_aux(){
    var data = <?= json_encode($user)?>;
    return data;
  }
</script>

<script src="<?= base_url() ?>/assets/vendors/dropify/js/dropify.min.js"></script>

<script src="<?= base_url() ?>/assets/js/scripts/form-file-uploads.js"></script>

<script src="<?= base_url() ?>/assets/js/new_script/edit.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function terminos(){
    Swal.fire({
      title: 'Términos y condiciones',
      html:`<div style="max-height: 400px"><?= $terminos->text ?></div>`,
      showCloseButton: false,
      showCancelButton: false,
      confirmButtonText: 'Entendido',
      scrollbarPadding: true,
      heightAuto: false
    });
  }
</script>