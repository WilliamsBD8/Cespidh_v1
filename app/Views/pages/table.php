<?= view('layouts/header') ?>
<?= view('layouts/navbar_horizontal') ?>
<!-- <?= view('layouts/navbar_vertical') ?> -->

<!-- BEGIN: Page Main-->
<div id="main">
    <div class="row">
        <div class="col s12">
            <div class="container">
                <div class="section">
                    <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">
                                    <?php if($title == 'Tipos de documento'): ?>
                                        <div class="row">
                                            <div class="col s12">
                                                <ul class="tabs">
                                                    <li class="tab col m6"><a href="#new" class="active"><?= $title ?></a></li>                                
                                                    <li class="tab col m6"><a href="#show">Instrucciones de uso</a></li>
                                                </ul>                              
                                            </div>
                                            <div id="new" class="col s12">
                                                <br>
                                                <h4 class="card-title"><?= $title ?></h4>
                                                <p><?= $subtitle ?></p>
                                                <?=  $output ?>
                                            </div>
                                            <div id="show" class="col s12">
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th>Opción</th>
                                                            <th>Función</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{created_document}}</td>
                                                            <td>Fecha de creación de documento</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{user.direccion}}</td>
                                                            <td>Dirección de quien pidio el documento</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{user.ciudad}}</td>
                                                            <td>Ciudad de quien pidio el documento</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{user.email}}</td>
                                                            <td>Correo electronico de quien pidio el documento</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{user.telefono}}</td>
                                                            <td>Telefono de quien pidio el documento</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{user.nombre}}</td>
                                                            <td>Nombre de quien pidio el documento</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{user.cedula}}</td>
                                                            <td>Cedula de quien pidio el documento</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <h4 class="card-title"><?= $title ?></h4>
                                        <p><?= $subtitle ?></p>
                                        <?=  $output ?>
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
<?= view('layouts/footer') ?>