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
              <li class="breadcrumb-item"><a href="<?= base_url(['cespidh', 'ciudadanos']) ?>">Documentos</a></li>
              <li class="breadcrumb-item active">Historial</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="col s12 <?= $documento->help == 'on' ? 'm9': '' ?>">
      <div class="container">
        <div class="section">
          <!-- Page Length Options -->
          <div class="row">
            <div class="col s12 m12 l12">
              <h4 class="card-title center-align">Historial</h4>
              <div class="card padding-4 animate fadeLeft">
                <div class="row">
                  <table class="striped responsive-table">
                    <thead>
                      <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Observación</th>
                        <th>Documento</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($works as $work): ?>
                        <tr>
                          <td><?= date_fecha($work->created_at) ?></td>
                          <td><?= $work->user->name ?></td>
                          <td><?= $work->user->rol->name ?></td>
                          <td><?= $work->observation ?></td>
                          <td><?= $work->documento ?></td>
                        </tr>
                      <?php  endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php if($documento->help == 'on'): ?>
      <div class="col s12 m3">
        <div class="container">
          <div class="section">
            <form action="">
              <h5>Colaborador</h5>
              <hr>
              <div class="input-field">
                <select class="select2 browser-default">
                  <option value="" disabled selected>Seleccionar colaborador</option>
                  <?php foreach ($colaboradores as $key => $colaborador): ?>
                    <option value="<?= $colaborador->id ?>"><?= $colaborador->name ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <button class="btn success">Agregar colaborador</button>
            </form>
          </div>
        </div>
      </div>
    <?php endif ?>
  </div>
</div>

<?= view('layouts/footer') ?>


<!-- BEGIN PAGE VENDOR JS-->
<script src="<?= base_url() ?>/assets/vendors/select2/select2.full.min.js"></script>
<!-- END PAGE VENDOR JS-->


<!-- BEGIN PAGE LEVEL JS-->
<script src="<?= base_url() ?>/assets/js/scripts/form-select2.js"></script>