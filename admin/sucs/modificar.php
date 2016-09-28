<?php $N_FORM = 91;
require "../lib/pagina.php";
$cabecera = pagina::header('Sucursaleses', false);

$errores = $maps = $det = $suc = '';
$ID = $_GET['id'];

if (isset($_GET['id']) && empty($_POST)){
	$suc = pagina::obtenerValor('SELECT sucursal FROM sucursales WHERE id_sucursal = ?;', 0, array($ID));
	$det = pagina::obtenerValor('SELECT direccion_sucursal FROM sucursales WHERE id_sucursal = ?;', 0, array($ID));
	$maps = pagina::obtenerValor('SELECT datosmapas FROM sucursales WHERE id_sucursal = ?;', 0, array($ID));
	//var_dump(array($maps, $det, $suc));
}

if (!empty($_POST)) {
	if (isset($_POST['suc']) && isset($_POST['suc']) && isset($_POST['suc'])) {
		$_POST = pagina::validarForm($_POST);
		$suc = $_POST['suc'];
		$det = $_POST['det'];
		$maps = $_POST['maps'];
		$errores .= !isset($suc) || empty($suc) ? 'El campo de sucursales no debe de estar vacío.' : '';
		$errores .= !isset($det) || empty($det) ? 'El campo de detalles de sucursales no debe de estar vacío.' : '';
		$errores .= !isset($maps) || empty($maps) ? 'El campo de detalles de GoogleMaps no debe de estar vacío.' : '';
		$sql = "UPDATE sucursales SET sucursal = ?, direccion_sucursal = ?, datosmapas = ? WHERE md5(id_sucursal) = ?;";
		if (!(strlen($errores) > 0)){
			if (pagina::ejecutar($sql, array($suc, $det, $maps, $_GET['id'])))
				header('Location: ./');
		}
	} else
		$errores .= 'Complete todo';
}

echo $cabecera; ?>
	<div class="row">
		<div class="col s12 m8 l6">
			<div class="card-panel">
				<h4 class="header2">Modificar sucursal</h4>
				<!--onpaste="return false;" oncut="return false;" oncopy="return false;"-->
				<form action"crear.php" method="post" enctype="multipart/form-data" autocomplete="off" >
					<div class="row">
						<div class="input-field col s12">
							<i class="material-icons prefix">note_add</i>
							<input id="suc" name="suc" type="text" class="validate" length="50" required <?php echo "value='$suc'"; ?>>
							<label for="suc">Sucursal</label>
						</div>
					</div>
					<div class="row">
				      	<div class="file-field input-field col s12">
							<i class="material-icons prefix">note_add</i>
							<textarea id="det" name="det" type="text" class="materialize-textarea" length="250" required><?php echo $det; ?></textarea>
							<label for="det">Detalles</label>
				    	</div>
			    	</div>
					<div class="row">
				      	<div class="file-field input-field col s12">
							<i class="material-icons prefix">note_add</i>
							<textarea id="maps" name="maps" type="text" placeholder="Coloca la dirección de recusos de la etiqueta de Google Maps" class="materialize-textarea" length="600" required><?php echo $maps; ?></textarea>
							<label for="maps">Etiqueta de Mapas</label>
				    	</div>
			    	</div>
					<div class="row">
						<button class="btn green waves-effect waves-light right" type="submit">
							Actualizar
							<i class="mdi-content-send right"></i>
						</button>
					</div>
				</form>
			</div>
		</div>
<?php
echo (strlen($errores) > 0) ? "
		<div class='col s12 m4 l4'>
			<div class='card-panel red'>
				<h4 class='white-text'>Errores</h4>
				<p class='white-text'>$errores</p>
			</div>
		</div>" : '';
?>
	</div>

<?php echo pagina::footer(); ?>
