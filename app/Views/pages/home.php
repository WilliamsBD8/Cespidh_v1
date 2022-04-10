<?= view('layouts/header') ?>
<!-- <?= view('layouts/navbar_vertical') ?> -->
<?= view('layouts/navbar_horizontal') ?>
    <!-- BEGIN: Page Main-->
<?php if ( !empty(configInfo()['intro']) && isset(configInfo()['intro'])): ?>
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <div class="card">
                            <div class="card-content">
                                <?= configInfo()['intro'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                    <script src="<?= base_url() ?>/assets/js/vendors.min.js"></script>

                    <?php if(session('user')->role_id <= 2): ?>
                        <?= view('admin/index', [
                            'users' => $user,
                            'tipos' => $documentos_tipo,
                            'documentos' => $documentos,
                            'meses' => $meses,
                            'grupos' => $grupos,
                            'genero' => $genero
                            ]) ?>
                    <?php else: ?>
                        <?= view('ciudadano/index') ?>
                    <?php endif ?>


                    </div>
                </div>
                <div class="content-overlay"></div>
            </div>
        </div>
    </div>
<?php endif; ?>


<?= view('layouts/footer') ?>