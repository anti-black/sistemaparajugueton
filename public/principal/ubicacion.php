<?php
require("../page1.php");
Page::header("Sucursales");
?>


<div class="container">
<?php
$sql = "SELECT sucursal, direccion_sucursal, datosmapas FROM sucursales WHERE estado = 1;";
$datos = Database::getRows($sql , array());
foreach ($datos as $fila) {
    $suc = $fila['sucursal'];
    $det = $fila['direccion_sucursal'];
    $datos = $fila['datosmapas'];

    echo "
    <div class='row'>
      <div class='col s12 m12'>
      <p><h5>$suc</h5></p>
      <address>
                <p>$det</p>
            </address> <br>
        <div>
            <div class='video-container'>
                <iframe src='$datos' width='1150' height='400' frameborder='0' style='border:0' allowfullscreen></iframe>
            </div>
        </div>
      </div>
    </div>
";

} ?>
</div>
    </div>
</div>

<?php
Page::footer();
?>