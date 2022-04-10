<!-- card stats start -->
<?php
    $total = count($tipos);
    $aux_div = 12;
    if($total >= 4)
        $aux_div = 3;
    elseif($total == 3)
        $aux_div = 4;
    elseif($total == 2)
        $aux_div == 6
?>
<div id="card-stats" class="pt-0">
    <div class="row">
        <?php foreach($tipos as $tipo): ?>
            <div class="col s12 l<?= $aux_div ?>">
                <div class="card animate fadeLeft">
                    <div class="card-content blue  darken-3 white-text">
                        <p class="card-stats-title"><i class="material-icons">person_outline</i> <?= $tipo->descripcion ?></p>
                        <h4 class="card-stats-number white-text"><?= $tipo->total ?></h4>
                    </div>
                    <div class="card-action blue  darken-4">
                        <span class="text text-lighten-5 white-text">Este mes: <?= $tipo->total_mes ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
<!--card stats end-->
<!-- Current balance & total transactions cards-->
<div class="row vertical-modern-dashboard">
    <div class="col s12 l8 animate fadeRight">
        <!--Line Chart-->
        <div id="chartjs-line-chart" class="card">
            <div class="card-content">
                <h4 class="card-title">Documentos Generados</h4>
                <div class="row">
                    <div class="col s12">
                        <div class="sample-chart-wrapper"><canvas id="line-chart" height="400"></canvas></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 l4">
        <!-- Recent Buyers -->
        <div class="card recent-buyers-card animate fadeUp">
            <div class="card-content">
                <h4 class="card-title mb-0">Entidades Agregadas Recientemente</h4>
                <ul class="collection mb-0">
                    <?php if(!empty($user)): ?>
                        <?php foreach($users as $user): ?>
                            <li class="collection-item avatar">
                                <img src="<?= base_url() ?>/img/entidades/user.png" alt="" class="circle" />
                                <p class="font-weight-600"><?= $user->name ?></p>
                                <p class="medium-small"><?= date_fecha($user->created_at) ?></p>
                            </li>
                        <?php endforeach ?>
                    <?php else: ?>
                        <h5>No hay entidades creadas</h5>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!--Pie & Doughnut Charts-->
<div class="row">
    <div class="col s12 m6 l4 animate fadeRight">
        <div class="card pt-1 pb-1">
            <p class="header center">Documentos Generados</p>
            <div><canvas id="general-chart" height="400"></canvas></div>
        </div>
    </div>
    <div class="col s12 m6 l4 animate fadeRight">
        <div class="card pt-1 pb-1">
            <p class="header center">Grupo Etnico</p>
            <div><canvas id="etnia-chart" height="400"></canvas></div>
        </div>
    </div>
    <div class="col s12 m6 l4 animate fadeRight">
        <div class="card pt-1 pb-1">
            <p class="header center">Genero</p>
            <div><canvas id="genero-chart" height="400"></canvas></div>
        </div>
    </div>
    
</div>

<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="<?= base_url() ?>/assets/vendors/chartjs/chart.min.js"></script>
<script src="<?= base_url() ?>/assets/vendors/chartist-js/chartist.min.js"></script>
<script src="<?= base_url() ?>/assets/vendors/chartist-js/chartist-plugin-tooltip.js"></script>
<script src="<?= base_url() ?>/assets/vendors/chartist-js/chartist-plugin-fill-donut.min.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN THEME  JS-->
<script src="<?= base_url() ?>/assets/js/plugins.js"></script>
<script src="<?= base_url() ?>/assets/js/search.js"></script>
<script src="<?= base_url() ?>/assets/js/custom/custom-script.js"></script>
<!-- END THEME  JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="<?= base_url() ?>/assets/js/scripts/dashboard-modern.js"></script>
<script src="<?= base_url() ?>/assets/js/scripts/intro.js"></script>
<script src="<?= base_url() ?>/assets/js/scripts/charts-chartjs.js"></script>

<script>
    function documentos(){
        var documentos = <?= json_encode($documentos,JSON_FORCE_OBJECT)?>;
        return documentos;
    }
    function meses(){
        var meses = <?= json_encode($meses,JSON_FORCE_OBJECT)?>;
        return meses;
    }

    function tipos_documento(){
        var tipos = <?= json_encode($tipos,JSON_FORCE_OBJECT)?>;
        return tipos;
    }

    function grupos_etnia(){
        var grupos = <?= json_encode($grupos,JSON_FORCE_OBJECT)?>;
        return grupos;
    }

    function genero(){
        var genero = <?= json_encode($genero,JSON_FORCE_OBJECT)?>;
        return genero;
    }
</script>

<script src="<?= base_url() ?>/assets/js/new_script/graficos.js"></script>