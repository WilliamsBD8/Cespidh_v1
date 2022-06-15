<?= view('layouts/header') ?>
<!-- <?= view('layouts/navbar_vertical') ?> -->
<?= view('layouts/navbar_horizontal')?>

<div id="main">
  <div class="row">
    <div class="pt-1 pb-0" id="breadcrumbs-wrapper">
      <!-- Search for small screen-->
      <div class="container">
        <div class="row">
          <div class="col s12 m6 l6">
          </div>
          <div class="col s12 m6 l6 right-align-md">
            <ol class="breadcrumbs mb-0">
              <li class="breadcrumb-item"><a href="<?= base_url(['home']) ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= base_url(['cespidh', 'entidad']) ?>">Documentos</a></li>
              <li class="breadcrumb-item active">Historial</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <h4 class="card-title center-align">Historial - Documento <?= $documento->abreviacion.'-'.$documento->id_documento ?></h4>
    <p class="card-title center-align"><b><?= $documento->descripcion ?></b></p>
    <div class="center-align">
      <button class="btn" onclick="agregar_user()">Asignar usuario</button>
    </div>
    <div class="col s12">
      <div class="container">
          <!-- Page Length Options -->
          <div class="row">
            <div class="col s12">
              <div class="container">
                <div class="section-data-tables">
                  <div class="row">
                    <div class="card padding-4 animate fadeLeft col s12">
                      <div class="row">
                        <table id="table-history" class="display">
                          <thead>
                            <tr>
                              <th>Fecha de creación</th>
                              <th>Usuario</th>
                              <th>Tipo</th>
                              <th>Observación</th>
                              <th>Documento / Asignado</th>
                              <th>Estado</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($works as $work): ?>
                              <tr>                        
                                <td><?= date('Y-m-d', strtotime($work->created_at))
                                      .'<br>'.
                                      date('h:i:s a', strtotime($work->created_at)) ?></td>
                                  <td><?= $work->user->name ?></td>
                                  <td><?= $work->name ?></td>
                                  <td><?= $work->observation ?></td>
                                  <td>
                                    <?php if($work->work_type_id != 2): ?>
                                      <div class="center-align">
                                        <?php $carpeta = $work->work_type_id == 3 ? 'upload' : 'pdf' ?>
                                        <?php if(preg_match('/pdf/', $work->document)): ?>
                                          <a class="a-icon red-text" href="<?= base_url(['docs', $carpeta, $work->document]) ?>" target="_blank">
                                            <i class="fa-regular fa-file-pdf"></i>
                                          </a>
                                        <?php else: ?>
                                          <a class="a-icon blue-text" href="<?= base_url(['cespidh', 'docs',$work->work_type_id, $work->document]) ?>" target="_blank">
                                            <i class="fa-regular fa-file-word"></i>
                                          </a>
                                        <?php endif ?>
                                        <?php if(!empty($work->document_2)): ?>
                                          <?php if(preg_match('/pdf/', $work->document_2)): ?>
                                            <a class="a-icon red-text" href="<?= base_url(['docs', $carpeta, $work->document_2]) ?>" target="_blank">
                                              <i class="fa-regular fa-file-pdf"></i>
                                            </a>
                                          <?php else: ?>
                                            <a class="a-icon blue-text" href="<?= base_url(['cespidh', 'docs',$work->work_type_id, $work->document_2]) ?>" target="_blank">
                                              <i class="fa-regular fa-file-word"></i>
                                            </a>
                                          <?php endif ?>
                                        <?php endif ?>
                                      <?php else: ?>
                                        <?= $work->user_asigado->name ?>
                                      <?php endif ?>
                                    </div>
                                  </td>
                                  <td><?= $work->status ?></td>
                                </tr>
                                <?php  endforeach ?>
                              </tbody>
                            </table>
                          </div>
                    </div>
                    <!-- <?php if($documento->help == 'off'): ?>
                      <div class="col s12 m3">
                        <div class="container">
                          <div class="section">
                            <form class="padding-4 animate fadeRigth" action="<?= base_url(['cespidh', 'historial', 'work']) ?>" method="post">
                              <h5>Asignar a:</h5>
                              <hr>
                              <div class="input-field">
                                <select class="select2 browser-default" name="user">
                                  <option value="" disabled selected>Seleccionar usuario</option>
                                  <?= $selected = '' ?>
                                  <?php foreach ($usuarios as $key => $usuario): ?>
                                    <?php foreach ($works as $key => $work){
                                      if($work->work_type_id == 2){
                                        $selected = $usuario->id == $work->user_aux ? 'selected' : '';
                                        break;
                                      }
                                    }?>
                                    <option value="<?= $usuario->id ?>" <?= $selected ?>><?= $usuario->name.' - '.$usuario->rol ?></option>
                                  <?php endforeach ?>
                                </select>
                              </div>
                              <div class="input-field">
                                <textarea id="observation" class="materialize-textarea" name="observation"></textarea>
                                <label for="observation">Observación</label>
                              </div>
                              <input type="hidden" name="type_work" value="2">
                              <input type="hidden" name="id_documento" value="<?= $documento->id_documento ?>">
                              <input type="hidden" name="type" value="create">
                              <button class="btn success" type="submit">Asignar usuario</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    <?php endif ?> -->
                    <!-- <div class="col s12">
                      <ul class="tabs">
                        <li class="tab col m6"><a href="#work_1" class="active">Documentos</a></li>                                
                        <li class="tab col m6"><a href="#work_2">Asignación</a></li>
                      </ul>
                    </div>
                    <div id="work_1" class="col s12">
                    </div>
                    <div id="work_2" class="col s12">
                      <div class="row">
                        <div class="card padding-4 animate fadeLeft col s12 <?= $documento->help == 'on' ? 'm9': '' ?> ">
                          <div class="row">
                            <table class="display">
                              <thead>
                                <tr>
                                  <th>Fecha de creación</th>
                                  <th>Usuario</th>
                                  <th>Asignado a:</th>
                                  <th>Observación</th>
                                  <th>Estado</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach($works as $work): ?>
                                  <?php if($work->work_type_id == 2): ?>
                                    <tr>
                                      <td><?= date('Y-m-d', strtotime($work->created_at))
                                        .'<br>'.
                                        date('h:i:s a', strtotime($work->created_at)) ?></td>
                                      <td><?= $work->user->name ?></td>
                                      <td><?= $work->user_asigado->name ?></td>
                                      <td><?= $work->observation ?></td>
                                      <td><?= $work->status ?></td>
                                    </tr>
                                  <?php endif ?>
                                <?php  endforeach ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        
                        
                      </div>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>



<form id="form_respuesta" action="<?= base_url(['cespidh', 'historial', 'work']) ?>" method="post">
  <input type="hidden" name="id_documento" value="<?= $work->documento_id_documento ?>">
  <input type="hidden" name="observation_respuesta" id="observation_respuesta">
  <input type="hidden" name="work_id" id="work_id">
  <input type="hidden" name="status" id="status">
  <input type="hidden" name="user_aux" id="user_aux">
  <input type="hidden" name="type" value="respuesta">
</form>

<?= view('layouts/footer_libre') ?>

                
<!-- BEGIN PAGE VENDOR JS-->
<script src="<?= base_url() ?>/assets/vendors/select2/select2.full.min.js"></script>
<!-- END PAGE VENDOR JS-->


<!-- BEGIN PAGE LEVEL JS-->
<script src="<?= base_url() ?>/assets/js/scripts/form-select2.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function agregar_user(){
    Swal.fire({
      title: 'Asignar usuario',
      html:`
        <form action="<?= base_url(['cespidh', 'historial', 'work']) ?>" method="post">
          <div class="input-field">
            <select class="select2 browser-default" name="user">
              <option value="" disabled selected>Seleccionar usuario</option>
              <?= $selected = '' ?>
              <?php foreach ($usuarios as $key => $usuario): ?>
                <?php foreach ($works as $key => $work){
                  if($work->work_type_id == 2){
                    $selected = $usuario->id == $work->user_aux ? 'selected' : '';
                    break;
                  }
                }?>
                <option value="<?= $usuario->id ?>" <?= $selected ?>><?= $usuario->name.' - '.$usuario->rol ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="input-field">
            <textarea id="observation" class="materialize-textarea" name="observation"></textarea>
            <label for="observation">Observación</label>
          </div>
          <input type="hidden" name="type_work" value="2">
          <input type="hidden" name="id_documento" value="<?= $documento->id_documento ?>">
          <input type="hidden" name="type" value="create">
          <button class="btn success" type="submit">Asignar usuario</button>
        </form>
      `,
      showCloseButton: false,
      showCancelButton: false,
      showConfirmButton: false,
    });
    $(".select2").select2({
      dropdownAutoWidth: true,
      width: '100%',
      minimumResultsForSearch: Infinity,
    })
  }
</script>