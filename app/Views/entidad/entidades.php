<?= view('layouts/header') ?>
<!-- <?= view('layouts/navbar_vertical') ?> -->


<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/flag-icon/css/flag-icon.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/data-tables/css/jquery.dataTables.min.css">
<!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css"> -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/data-tables/css/select.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/materialize-stepper/materialize-stepper.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/form-wizard.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/css/table.css">

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/data-tables.css">

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/page-faq.css">


<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/vendors/sweetalert/sweetalert.css">


<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/app-file-manager.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/widget-timeline.css">
<?= view('layouts/navbar_horizontal')?>

<div id="main">
  <div class="row">
    <div class="pt-1 pb-0" id="breadcrumbs-wrapper">
      <!-- Search for small screen-->
      <div class="container">
        <div class="row">
          <div class="col s12 m6 l6">
            <h5 class="breadcrumbs-title"><span>Entidades</span></h5>
          </div>
          <div class="col s12 m6 l6 right-align-md">
            <ol class="breadcrumbs mb-0">
              <li class="breadcrumb-item"><a href="<?= $base_url ?>">Home</a></li>
              <li class="breadcrumb-item active">Entidades</li>
            </ol>
          </div>
        </div>
      </div>      
    </div>
    <div class="row">
      
    <?php foreach($estados as $estado): ?>
            <div class="col s12 m6 l4">
              <div class="card padding-4 animate fadeLeft">
                  <div class="row">                  
                      <div class="col s5 m5">
                          <h5 class="mb-0"><?= $estado->total ?></h5>
                          <p class="no-margin"><?= $estado->nombre ?></p>
                      </div>
                      <div class="col s7 m7 right-align">
                          <i class="material-icons background-round mt-5 mb-5  blue lighten-4 blue-text indicadores"><?= !empty($estado->icono) ? $estado->icono : 'adjust' ?></i>
                      </div>                    
                  </div>                
              </div>
            </div>      
            <?php endforeach ?>
    </div>
    <div class="col s12">
      <div class="container">        
        <div class="section section-data-tables">
          <!-- Page Length Options -->
          <div class="row">
            <div class="col s12">
              <div class="container">
                <div class="section section-data-tables">
                  <div class="row">
                    <div class="col s12">
                        <div class="card-3" id="faq">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col s12">
                                      <ul class="tabs">
                                        <li class="tab col m6"><a href="#new" class="active">Documentos</a></li>                                
                                        <li class="tab col m6"><a href="#show">Nuevo Documento</a></li>
                                      </ul>                              
                                    </div>
                                    <div id="documentos" class="col s12">
                                    <div id="new" class="col s12">
                                      <div class="section" id="faq">
                                        <div class="faq">
                                          <div class="col s12 l12">
                                              <ul class="collapsible categories-collapsible">
                                                  <li class="">
                                                      <div class="collapsible-header">
                                                        Filtro
                                                        <i class="material-icons">keyboard_arrow_right </i>
                                                      </div>
                                                      <div class="collapsible-body">
                                                        <div class="row">
                                                          <form class="col s12" action="<?= base_url(['cespidh', 'entidad', 'search']) ?>" method="post" autocomplete="off">
                                                            <div class="row">
                                                              <div class="col s12">
                                                                <div class="row">
                                                                  <div class="input-field col s12 l3">
                                                                    <input type="text" id="autocomplete-name" class="autocomplete-name" name="nombre" <?= !empty($data['nombre']) ? 'value="'.$data['nombre'].'"' :'' ?>>
                                                                    <label for="autocomplete-name">Nombre</label>
                                                                  </div>

                                                                  <div class="input-field col s12 l3">
                                                                    <input type="text" id="autocomplete-id" class="autocomplete-id" name="cedula" <?= !empty($data['cedula']) ? 'value="'.$data['cedula'].'"' :'' ?>>
                                                                    <label for="autocomplete-id">Cedula</label>
                                                                  </div>

                                                                  <div class="input-field col s12 l3">
                                                                    <select name="tipo_documento">
                                                                      <option value="">Seleccion una opción</option>
                                                                      <?php foreach($tipo_documento as $tipo): ?>
                                                                        <option <?= !empty($data['tipo_documento']) && $data['tipo_documento'] == $tipo->id_tipo  ? 'selected' :'' ?> value="<?= $tipo->id_tipo ?>"><?= $tipo->descripcion ?></option>
                                                                      <?php endforeach ?>
                                                                    </select>
                                                                    <label>Tipo de documento</label>  
                                                                  </div>
                                                                  <div class="input-field col s12 l3">
                                                                    <input type="text" id="autocomplete-sedes" class="autocomplete-sedes" name="sede" <?= !empty($data['sede']) ? 'value="'.$data['sede'].'"' :'' ?>>
                                                                    <label for="autocomplete-sedes">Sede</label>
                                                                  </div>
                                                                </div>

                                                                <div class="row">
                                                                  <div class="input-field col s12 l4">
                                                                    <input type="text" id="autocomplete-colaborador" class="autocomplete-colaborador" name="colaborador">
                                                                    <label for="autocomplete-colaborador">Colaborador</label>                                                    
                                                                  </div>
                                                                  <div class="input-field col s12 l4">
                                                                    <input type="text" class="datepicker" id="date-inicial" name="date_init" <?= !empty($data['date_init']) ? 'value="'.$data['date_init'].'"' :'' ?>>
                                                                    <label for="date-inicial">Fecha inicial</label>
                                                                  </div>
                                                                  <div class="input-field col s12 l4">
                                                                    <input type="text" class="datepicker" id="date-final" name="date_finish" <?= !empty($data['date_finish']) ? 'value="'.$data['date_finish'].'"' :'' ?>>
                                                                    <label for="date-final">Fecha final</label>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <div class="div-center pb-1">
                                                              <button class="btn waves-effect waves-light blue" type="submit">Filtrar
                                                                <i class="material-icons right">send</i>
                                                              </button>
                                                              <button class="btn waves-effect waves-light red lighten-1" type="reset">Resetear
                                                                <i class="material-icons right">close</i>
                                                              </button>
                                                            </div>
                                                          </form>
                                                        </div>
                                                      </div>
                                                  </li>
                                              </ul>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                    
                                      <div class="col s12">                                        
                                        <ul class="tabs">
                                        <?php foreach($estados as $key => $estado): ?>
                                          <li class="tab col m3"><a href="#estado_<?= ($key+1) ?>" <?php if(!isset($data)): ?>  class="<?= $key==0?'active':'' ?>" <?php endif ?>><?= $estado->nombre ?></a></li>
                                          <?php endforeach ?>
                                          <li class="tab col m3"><a href="#todo" <?php if(isset($data)): ?>  class="active" <?php endif ?>>Todas</a></li>
                                        </ul>
                                        <?php foreach($estados as $key => $estado): ?>  
                                      <div id="estado_<?= ($key+1) ?>" class="col s12">
                                        <table id="table-<?= ($key+1) ?>" class="display">
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
                                              <th>Acciones</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php foreach($documents as $document): ?>
                                              <?php if($document->id_estado == $estado->id_estado): ?>
                                              <tr>
                                                  <td><?= $document->abreviacion.''.$document->id_documento ?></td>
                                                  <td><?= $document->name ?></td>
                                                  <td><?= $document->id ?></td>
                                                  <td><?= $document->descripcion ?></td>
                                                  <td><?= $document->nombre ?></td>
                                                  <td><?= $document->sede ?></td>
                                                  <td><?= $document->help == 'off' ? 'No necesita': 'No asignado' ?></td>
                                                  <td><?= $document->fecha ?></td>
                                                  <td>
                                                    <div class="center-align">
                                                      <a class="tooltipped"
                                                        href="<?= base_url(['cespidh', 'edit', 'document', $document->id_documento]) ?>" target="_blank"
                                                        data-position="bottom" data-tooltip="Editar"
                                                      ><i class="material-icons grey-text">create</i></a>
  
                                                      <!-- Dropdown Trigger -->
                                                      <a class="waves-effect waves-block waves-light detail-button" href="javascript:void(0);" data-coverTrigger="true" data-target='detail_<?= $document->id_documento ?>'><i class="material-icons">more_vert</i></a>
                                                      <!-- Dropdown Structure -->
                                                      <ul class="dropdown-content" id="detail_<?= $document->id_documento ?>">
                                                        <li>
                                                          <a class="blue-text text-darken-1" href="<?= base_url(['cespidh', 'historial', 'document', $document->id_documento]) ?>" target="_blank">
                                                            <i class="material-icons">history</i> Historial
                                                          </a>
                                                        </li>
                                                        <li>
                                                          <a class="blue-text text-darken-1" href="<?= base_url(['cespidh', 'view', 'document', $document->id_documento, 1]) ?>" target="_blank">
                                                            <i class="material-icons">picture_as_pdf</i> Ver
                                                          </a>
                                                        </li>
                                                        <li>
                                                          <a class="blue-text text-darken-1" href="<?= base_url(['cespidh', 'view', 'document', $document->id_documento, 2]) ?>" target="_blank">
                                                            <i class="material-icons">file_download</i> Descargar
                                                          </a>
                                                        </li>
                                                      </ul>
                                                    </div>
                                                  </td>
                                              </tr>
                                            <?php endif ?>
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
                                      <?php endforeach ?>
                                      <div id="todo" class="col s12">
                                        <table id="table-0" class="display">
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
                                              <th>Acciones</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php foreach($documents as $document): ?>
                                              <tr>
                                                  <td><?= $document->abreviacion.''.$document->id_documento ?></td>
                                                  <td><?= $document->name ?></td>
                                                  <td><?= $document->id ?></td>
                                                  <td><?= $document->descripcion ?></td>
                                                  <td><?= $document->nombre ?></td>
                                                  <td><?= $document->sede ?></td>
                                                  <td><?= $document->help == 'off' ? 'No necesita': 'No asignado' ?></td>
                                                  <td><?= $document->fecha ?></td>
                                                  <td>
                                                    <div class="center-align">
                                                      <a class="tooltipped"
                                                        href="<?= base_url(['cespidh', 'edit', 'document', $document->id_documento]) ?>" target="_blank"
                                                        data-position="bottom" data-tooltip="Editar"
                                                      ><i class="material-icons grey-text">create</i></a>
  
                                                      <!-- Dropdown Trigger -->
                                                      <a class="waves-effect waves-block waves-light detail-button" href="javascript:void(0);" data-coverTrigger="true" data-target='detail_<?= $document->id_documento ?>_0'><i class="material-icons">more_vert</i></a>
                                                      <!-- Dropdown Structure -->
                                                      <ul class="dropdown-content" id="detail_<?= $document->id_documento ?>_0">
                                                        <li>
                                                          <a class="blue-text text-darken-1" href="<?= base_url(['cespidh', 'historial', 'document', $document->id_documento]) ?>" target="_blank">
                                                            <i class="material-icons">history</i> Historial
                                                          </a>
                                                        </li>
                                                        <li>
                                                          <a class="blue-text text-darken-1" href="<?= base_url(['cespidh', 'view', 'document', $document->id_documento, 1]) ?>" target="_blank">
                                                            <i class="material-icons">picture_as_pdf</i> Ver
                                                          </a>
                                                        </li>
                                                        <li>
                                                          <a class="blue-text text-darken-1" href="<?= base_url(['cespidh', 'view', 'document', $document->id_documento, 2]) ?>" target="_blank">
                                                            <i class="material-icons">file_download</i> Descargar
                                                          </a>
                                                        </li>
                                                      </ul>
                                                    </div>
                                                  </td>
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
                                    <div id="show" class="col s12">
                                      <div class="section" id="faq">
                                            <div class="faq row">
                                                <div class="col s12 l12">
                                                    <ul class="collapsible categories-collapsible">
                                                      <?php foreach($formularios as $key => $formulario): ?>
                                                        <li class="">
                                                          <div class="collapsible-header principal">
                                                            <?= $formulario->descripcion.' - '.$formulario->title ?>
                                                            <i class="material-icons">keyboard_arrow_right </i>
                                                          </div>
                                                          <div class="collapsible-body">
                                                            <form method="POST" action="<?= base_url(['cespidh', 'create', 'document']) ?>" enctype="multipart/form-data">
                                                                <input type="hidden" value="<?= $formulario->documento_tipo_id_tipo ?>" name="tipo_documento">
                                                                <input type="hidden" value="<?= $formulario->id ?>" name="id_formulario">
                                                                <ul class="stepper linear" id="linearStepper<?= $key ?>">
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
                                                                                      <input type="text" id="text_<?= $pregunta->id ?>" name="<?= $pregunta->campo_formulario?>" class="validate" <?= $pregunta->obligatorio  == 'Si' ? 'required':'' ?> <?= $pregunta->descripcion ? 'placeholder="'.$pregunta->descripcion .'"':'' ?>>
                                                                                  </div>
                                                                                <?php elseif($pregunta->tipo_pregunta_id == 2): ?> <!-- Pregunta Select -->
                                                                                  <div class="input-field col s12">
                                                                                    <select name="<?= $pregunta->campo_formulario?>" <?= $pregunta->obligatorio  == 'Si' ? 'required':'' ?>>
                                                                                      <option value="" disabled selected>Seleccion opción</option>
                                                                                      <?php foreach($pregunta->detalle as $detalle): ?>
                                                                                        <option value="<?= $detalle->id ?>"><?= $detalle->description ?></option>
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
                                                                                                    <input type="radio" <?= $pregunta->obligatorio  == 'Si' || $key_detalle == 0 ? 'required="required"':'' ?> value="<?= $detalle->id ?>" name="<?= $pregunta->campo_formulario?>" class="with-gap"/>
                                                                                                    <span><?= $detalle->description ?></span>
                                                                                                  </label>
                                                                                                </p>
                                                                                                <div class="pl-3">
                                                                                                  <?php foreach($detalle->detalle as $detalleHijo): ?>
                                                                                                    <?php if($detalleHijo->tipo_pregunta_id == 1): ?>
                                                                                                      <div class="input-field col s12 ">
                                                                                                          <label for="text_<?= $detalleHijo->id ?>"><?= $detalleHijo->description ?></label>
                                                                                                          <input type="text" id="text_<?= $detalleHijo->id ?>" name="<?= $detalleHijo->campo_formulario?>" class="validate"  <?= $pregunta->descripcion ? '':'' ?>>
                                                                                                      </div>
                                                                                                    <?php elseif($detalleHijo->tipo_pregunta_id == 3): ?>
                                                                                                      <p>
                                                                                                        <label>
                                                                                                          <input type="radio" <?= $pregunta->obligatorio  == 'Si' ? 'required':'' ?> value="<?= $detalleHijo->id ?>" name="<?= $detalle->campo_formulario?>" class="with-gap"/>
                                                                                                          <span><?= $detalleHijo->description ?></span>
                                                                                                        </label>
                                                                                                      </p>
                                                                                                    <?php elseif($detalleHijo->tipo_pregunta_id == 4): ?>
                                                                                                      <p>
                                                                                                        <label>
                                                                                                          <input type="checkbox" value="<?= $detalleHijo->id ?>" name="<?= $detalle->campo_formulario ?>[]" class="filled-in"/>
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
                                                                                                    <input type="checkbox" value="<?= $detalle->id ?>" name="<?= $pregunta->campo_formulario?>[]" class="filled-in"/>
                                                                                                    <span><?= $detalle->description ?></span>
                                                                                                  </label>
                                                                                                </p>
                                                                                                <div class="pl-3">
                                                                                                  <?php foreach($detalle->detalle as $detalleHijo): ?>
                                                                                                    <?php if($detalleHijo->tipo_pregunta_id == 1): ?>
                                                                                                      <div class="input-field col s12 ">
                                                                                                          <label for="text_<?= $detalleHijo->id ?>"><?= $detalleHijo->description ?></label>
                                                                                                          <input type="text" id="text_<?= $detalleHijo->id ?>" name="<?= $detalleHijo->campo_formulario?>" class="validate"  <?= $pregunta->descripcion ? '':'' ?>>
                                                                                                      </div>
                                                                                                    <?php elseif($detalleHijo->tipo_pregunta_id == 3): ?>
                                                                                                      <p>
                                                                                                        <label>
                                                                                                          <input type="radio" <?= $pregunta->obligatorio  == 'Si' ? 'required':'' ?> value="<?= $detalleHijo->id ?>" name="<?= $detalle->campo_formulario ?>" class="with-gap"/>
                                                                                                          <span><?= $detalleHijo->description ?></span>
                                                                                                        </label>
                                                                                                      </p>
                                                                                                    <?php elseif($detalleHijo->tipo_pregunta_id == 4): ?>
                                                                                                      <p>
                                                                                                        <label>
                                                                                                          <input type="checkbox" value="<?= $detalleHijo->id ?>" name="<?= $detalle->campo_formulario ?>[]" class="filled-in"/>
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
                                                                                  </div>
                                                                                  <input type="hidden" id="<?= $pregunta->campo_formulario ?>_hechos" name="<?= $pregunta->campo_formulario?>">
                                                                                
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
                                                                                                          <!-- <div class="row">
                                                                                                            <div class="file-field input-field  s12 m3col">
                                                                                                              <div class="btn large">
                                                                                                                <span>File</span>
                                                                                                                <input type="file" id="input_prueba_<?= $pregunta->id ?>">
                                                                                                              </div>
                                                                                                              <div class="file-path-wrapper hide">
                                                                                                                <input class="file-path validate" type="text">
                                                                                                              </div>
                                                                                                            </div>
                                                                                                            <div class="file-field input-field col s12 m9">
                                                                                                              <input placeholder="Placeholder" id="input_name_<?= $pregunta->id ?>" type="text" class="validate">
                                                                                                              <label for="input_name_<?= $pregunta->id ?>">First Name</label>
                                                                                                            </div>
                                                                                                            <div class="col m4 s12 mb-3">
                                                                                                                <button class="waves btn btn-primary" onclick="add_prueba(<?= $pregunta->id ?>, '<?= $pregunta->campo_formulario ?>')" type="button">
                                                                                                                    <i class="material-icons left">check</i>Agregar
                                                                                                                </button>
                                                                                                            </div>
                                                                                                          </div> -->
                                                                                                      </div>
                                                                                                      <!-- <input type="file" name="<?= $pregunta->campo_formulario?>[]">
                                                                                                      <input type="file" name="<?= $pregunta->campo_formulario?>[]"> -->
                                                                                                      <!-- <input type="file" multiple id="prueba_<?= $pregunta->id?>"> -->
                                                                                                      <div class="row app-file-recent-access mb-3 pruebas-anexos" id="pruebas_anexos_<?= $pregunta->id ?>">
                                                                                                          
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
                                                                  </li>
                                                                </ul>
                                                              </form>
                                                            </div>
                                                        </li>                                                
                                                      <?php endforeach ?>
                                                    </ul>                                            
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
            </div>
          </div>
        </div>
      </div> 
    </div>   
  </div>
</div>




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
    $('.datepicker').datepicker();
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
        swal(`El Documento # ${id}!`,
        {
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
    <script>
      function documentos(){
        var names = <?= json_encode(session('filtro_entidad')['names'],JSON_FORCE_OBJECT)?>;
        return names;
      }
      function cedulas_aux(){
        var cedulas = <?= json_encode(session('filtro_entidad')['ids'],JSON_FORCE_OBJECT)?>;
        return cedulas;
      }

      function sedes_aux(){
        var cedulas = <?= json_encode(session('filtro_entidad')['sedes'],JSON_FORCE_OBJECT)?>;
        return cedulas;
      }
    </script>

<script src="<?= base_url() ?>/assets/js/new_script/entidad.js"></script>
  

<?= view('layouts/footer_libre') ?>