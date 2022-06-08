<?= view('layouts/header') ?>
<link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/select2/select2.min.css" type="text/css">
<link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/select2/select2-materialize.css" type="text/css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/pages/form-select2.css">
<?= view('layouts/navbar_horizontal') ?>

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
    <div class="col s12">
      <div class="container">
        <div class="section">
          <!-- Page Length Options -->
          <div class="row">
            <div class="col s12 m12 l12">
              <h4 class="card-title center-align">Historial</h4>
              <div class="row">
                <div class="col s12">
                  <ul class="tabs">
                    <li class="tab col m6"><a href="#work_1" class="active">Documento</a></li>
                    <li class="tab col m6"><a href="#work_2">Asignaciones</a></li>
                  </ul>
                </div>
                <div id="work_1" class="col s12">
                  <div class="card padding-4 animate fadeLeft">
                    <div class="row">
                      <table class="striped responsive-table">
                        <thead>
                          <tr>
                            <th>Fecha de creación</th>
                            <th>Usuario</th>
                            <th>Rol</th>
                            <th>Observación</th>
                            <th>Documento</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($works as $work): ?>
                            <?php if($work->work_type_id == 1): ?>
                              <tr>
                                <td><?= date_fecha($work->created_at)
                                  .'<br>'.
                                  date('h:i:s a', strtotime($work->created_at)) ?></td>
                                <td><?= $work->user->name ?></td>
                                <td><?= $work->user->rol->name ?></td>
                                <td><?= $work->observation ?></td>
                                <td><a href="<?= base_url(['docs', $work->document]) ?>" target="_blank"><?= $work->document ?></a></td>
                              </tr>
                            <?php endif ?>
                          <?php  endforeach ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div id="work_2" class="col s12">
                  <div class="row">
                    <div class="card padding-4 animate fadeLeft col s12 <?= $documento->help == 'on' ? 'm9': '' ?> ">
                      <div class="row">
                        <div class="col s12"></div>
                        <table class="striped responsive-table">
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
                              <?php if($work->work_type_id != 1): ?>
                                <tr>
                                  <td><?= date_fecha($work->created_at)
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
                    
                    <?php if($documento->help == 'on'): ?>
                      <div class="col s12 m3">
                        <div class="container">
                          <div class="section">
                            <form action="<?= base_url(['cespidh', 'historial', 'work']) ?>" method="post">
                              <h5>Asignar a:</h5>
                              <hr>
                              <div class="input-field">
                                <select class="select2 browser-default" name="user">
                                  <option value="" disabled selected>Seleccionar colaborador</option>
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
                              <button class="btn success" type="submit">Agregar usuario</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>
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



<form id="form_respuesta" action="<?= base_url(['cespidh', 'historial', 'work']) ?>" method="post">
  <input type="hidden" name="id_documento" value="<?= $work->documento_id_documento ?>">
  <input type="hidden" name="observation_respuesta" id="observation_respuesta">
  <input type="hidden" name="work_id" id="work_id">
  <input type="hidden" name="status" id="status">
  <input type="hidden" name="user_aux" id="user_aux">
  <input type="hidden" name="type" value="respuesta">
</form>
<?= view('layouts/footer') ?>


<!-- BEGIN PAGE VENDOR JS-->
<script src="<?= base_url() ?>/assets/vendors/select2/select2.full.min.js"></script>
<!-- END PAGE VENDOR JS-->


<!-- BEGIN PAGE LEVEL JS-->
<script src="<?= base_url() ?>/assets/js/scripts/form-select2.js"></script>
<script src="<?= base_url() ?>/assets/vendors/sweetalert/sweetalert.min.js"></script>
<script>
  function enviar(success = true, id_work, user){
    if(success){
      $('#status').val('Aceptado');
      $('#work_id').val(id_work);
      $('#user_aux').val(user);
      $('#form_respuesta').submit();
    }else
      swal("Motivo del rechazo:", {
        content: "input",
      })
      .then((value) => {
        if (value === null || value == '') {
          swal({
            title: "El motivo es obligatorio",
            icon: 'warning',
            dangerMode: true,
            buttons: {
              cancel: 'Cancelar',
              delete: 'Ok!'
            }
          }).then(function (willDelete) {
            if (willDelete == 'delete') {
             enviar(false);
            }
          });
        }else{
          $('#status').val('Rechazado');
          $('#work_id').val(id_work);
          $('#user_aux').val(user);
          $('#observation_respuesta').val(value);
          $('#form_respuesta').submit();
        }
      })
  }
</script>