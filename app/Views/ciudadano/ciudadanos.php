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
                                                <li class="">
                                                    <div class="collapsible-header">
                                                      Derecho de petición
                                                      <i class="material-icons">keyboard_arrow_right </i>
                                                    </div>
                                                    <div class="collapsible-body">
                                                      <?php 
                                                        
                                                      ?>
                                                    </div>
                                                </li>                                                
                                            </ul>                                            
                                        </div>
                                    </div>
                              </div>
                            </div>
                            <div id="show" class="col s12">Test 2</div>
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


  

<?= view('layouts/footer') ?>