<h4 class="center-align">Bienvenido al portal de <?= isset(configInfo()['name_app']) ? configInfo()['name_app'] : 'IPLANET' ?></h4>
<div id="card-stats" class="pt-0">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card animate fadeLeft">
              <table class="centered striped">
                <tbody>
                <tr>
                  <td>Nombre</td>
                  <td><?= session('user')->name ?></td>
                </tr>
                <tr>
                  <td>Tipo de usuario</td>
                  <td><?= session('user')->role_name ?></td>
                </tr>
                <tr>
                  <td>Fecha de inicio</td>
                  <td><?= date_fecha(date('Y-m-d')) ?></td>
                </tr>
                <tr>
                  <td>Hora de inicio</td>
                  <td><?= date('H:i A') ?></td>
                </tr>
                </tbody>
              </table>

              
            </div>
        </div>
    </div>
</div>