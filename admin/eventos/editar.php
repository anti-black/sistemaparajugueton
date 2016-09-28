<?php require "../lib/pagina.php";

$cabecera = Pagina::header("Editar evento");

$id = pagina::URLD64($_GET['id']); $errores = '';

function validarFI($fecha){
	$var = strtotime(str_replace('/', '-', $fecha));
	$hoy = strtotime(date('d-m-Y', time()));
	if ($hoy > $var) return array(false, 'La fecha de inicio está en el pasado.');
	return array(true, $var);
}
function validarFF($fecha){
	$var = strtotime(str_replace('/', '-', $fecha));
	$hoy = strtotime(date('d-m-Y', time()));
	if ($hoy > $var) return array(false, 'La fecha de fin está en el pasado.');
	return array(true, $var);
}
function validarRango($A, $B){
	if ($A == $B) return array($A, $B);
	$Menor = $A > $B ? $B : $A;
	$Mayor = $A === $Menor ? $B : $A;
	return array($Menor, $Mayor);
};

$_POST = pagina::validarForm($_POST);
$var = $_POST['nombre_evento'];
$var1 = mb_substr($_POST['detalle_evento'], 0, 250);
$var2 = mb_substr($_POST['lugar'], 0, 150);
$var3 = $_POST['fecha_inicio'];
$var4 = $_POST['fecha_fin'];
if(!empty($_POST)) {
	$data = pagina::obtenerFilas('SELECT * FROM eventos WHERE nombre_evento LIKE ? AND md5(id_evento) <> ?;', array($var, $id));
	if (preg_match("/^[a-zA-Z0-9 \x7f-\xff]{1,25}$/", $var)) {
		if (!empty($var3) || !empty($var4)) {
			$var3 = validarFI($var3);
			$var4 = validarFF($var4);
			if (!$var3[0])
				$errores = $var3[1];
			elseif (!$var4[0])
				$errores = $var4[1];
			elseif (empty($data)) {
				$preVar = validarRango($var3, $var4);
				$var3 = date('Y-m-d', $preVar[0][1]);
				$var4 = date('Y-m-d', $preVar[1][1]);
				$sql = "UPDATE eventos SET nombre_evento = ?, detalle_evento = ?, lugar = ?, fecha_inicio = ?, fecha_fin = ? WHERE md5(id_evento) = ?;";
				$params = array($var, $var1, $var2, $var3, $var4, $id);
				if (pagina::ejecutar($sql, $params))
					header('Location: ./');
			} else $errores = 'Nombre ya en uso.';
		} else $errores = 'Completa las fechas.';
	} else $errores = 'Nombre no válido.';
}
else{
    $data = pagina::obtenerFila("SELECT * FROM eventos WHERE md5(id_evento) = ?;", array($id));
    if(empty($data))
        header('Location: ./');
    $var = $data['nombre_evento'];
    $var1 = $data['detalle_evento'];
    $var2 = $data['lugar'];
    $var3 = date('d/m/Y', strtotime($data['fecha_inicio']));
    $var4 = date('d/m/Y', strtotime($data['fecha_fin']));
}

echo $cabecera;
?>
<br/>
<div class="row container">
	<form method='post' class='col s12' enctype='multipart/form-data' autocomplete="off">
		<div class='row'>
			<div class="col s12 m6 l4">
				<div class="input-field col s10">
					<input placeholder="Nombre de evento" id="nombre_evento"  name="nombre_evento" type="text" class="validate" length="25" onkeyup="disponible('<?php echo $_GET['id']; ?>')" value="<?php echo $var; ?>" required>
					<label for="nombre_evento">Evento</label>
				</div>
				<div id='preloaderX' class="col s2"></div>
			</div>
			<div class="col s12 m6 l4">
				<div class="input-field col s12">
					<textarea id="detalle_evento" name="detalle_evento" placeholder="Información extra del evento" class="materialize-textarea" length="250"><?php echo $var1; ?></textarea>
					<label for="detalle_evento">Detalles del evento</label>
				</div>
			</div>
			<div class="col s12 m6 l4">
				<div class="input-field col s12">
					<textarea id="lugar" name="lugar" placeholder="Sitio donde se llevará a cabo el evento" class="materialize-textarea" length="150" required><?php echo $var2; ?></textarea>
					<label for="lugar">Lugar del evento</label>
				</div>
			</div>
			<div class="col s12 m6 l4">
				<div class="input-field col s12">
					<label for="fecha_inicio">Fecha de inicio</label>
					<input id="fecha_inicio" type="date" class="datepicker" name="fecha_inicio" value="<?php echo $var3; ?>">
				</div>
			</div>
			<div class="col s12 m6 l4">
				<div class="input-field col s12">
					<label for="fecha_fin">Fecha de fin</label>
					<input id="fecha_fin" type="date" class="datepicker" name="fecha_fin" value="<?php echo $var4; ?>">
				</div>
			</div>
		</div>
		<br/>
		<div class="row">
			<a href='index.php' class='btn grey left'><i class='material-icons right'>cancel</i>Cancelar</a>
			<button type='submit' class='btn blue right'><i class='material-icons left'>save</i>Guardar</button>
		</div>
	</form>
</div>
<?php echo strlen($errores) > 0 ? '
<div class="row">
	<div class="col s12 push-m3 m6 push-l4 l4 card red white-text">
		<div class="center-align">
			<p>'.$errores.'</p>
		</div>
	</div>
</div>' : ''; ?>
<script type="text/javascript" src="comandos.js"></script>
<?php echo Pagina::footer(); ?>