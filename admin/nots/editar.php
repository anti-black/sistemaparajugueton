<?php require "../lib/pagina.php"; require("../../lib/database.php");
$cabecera = Pagina::header("Editar noticia");

$id = pagina::URLD64($_GET['id']); $errores = '';
//SELECT id_noticia, titulo, subtitulo, informacion_pri, informacion_sec, informacion_ter, imagen_pri, imagen_sec, imagen_ter, fecha, estado FROM noticias
function validarF($fecha){
	$var0 = strtotime(str_replace('/', '-', $fecha));
	$hoy = strtotime(date('d-m-Y', time()));
	if ($hoy > $var0) return array(false, 'La fecha de inicio está en el pasado.');
	return array(true, $var0);
}
function validarImg($archivo, $activado = true, $extra = false){
	if (!$activado) return array(false, null);
	if (empty($archivo['tmp_name']) && $extra) return array(false, null);
	if (empty($archivo['tmp_name']) && (!$extra)) return array(true, 'El archivo no debe de estar vacio.');
	$res = pagina::validarImagen($archivo, 'm');
	if (strlen($res) == 0)
		return array(false, pagina::convertirA64($archivo));
	else return array(true, $res);
}

$_POST = pagina::validarForm($_POST);
$var0 = $_POST['titulo'];
$var1 = substr($_POST['subtitulo'], 0, 75);
$var2 = substr($_POST['informacion_pri'], 0, 1500);
$var3 = substr($_POST['informacion_sec'], 0, 1500);
$var4 = substr($_POST['informacion_ter'], 0, 1500);
$var5 = $_FILES['imagen_pri'];
$var6 = $_FILES['imagen_sec'];
$var7 = $_FILES['imagen_ter'];
$var8 = $_POST['fecha'];
$var5_ = isset($_POST['Archivo1']);
$var6_ = isset($_POST['Archivo2']);
$var7_ = isset($_POST['Archivo3']);
if(!empty($_POST)) {
	$data = pagina::obtenerFilas('SELECT * FROM eventos WHERE nombre_evento LIKE ?;', array($var0));
	if (preg_match("/^[a-zA-Z0-9 \x7f-\xff]{1,50}$/", $var0)) {
		if (!empty($var0) || !empty($var2) || !empty($var5)) {
			$var8 = validarF($var8);
			$var5 = validarImg($var5, $var5_);
			$var6 = validarImg($var6, $var6_, true);
			$var7 = validarImg($var7, $var7_, true);
			if (!$var8[0]){
				$errores = $var8[1];}
			elseif ($var5[0]){
				$errores = $var5[1];}
			elseif ($var6[0]){
				$errores = $var6[1];}
			elseif ($var7[0]){
				$errores = $var7[1];}
			elseif (empty($data)) {
				if (mb_strlen($errores) == 0) {

			        var_dump($var5, $var6, $var7);
					$var8 = date('Y-m-d', $var8[1]);
					$sql = "UPDATE noticias SET titulo = ?, subtitulo = ?, informacion_pri = ?, informacion_sec = ?, informacion_ter = ?, fecha = ? WHERE md5(id_noticia) = ?;";
					//, imagen_pri, imagen_sec, imagen_ter) VALUES(?,?,?,?,?,?,?,?,?)
					//, $var5[1], $var6[1], $var7[1]
					$params = array($var0, $var1, $var2, $var3, $var4, $var8, $id);
					if (pagina::ejecutar($sql, $params)){
					    if ($var5[1] != null) pagina::ejecutar("UPDATE noticias SET imagen_pri = ? WHERE md5(id_noticia) = ?;", array($var5[1], $id));
					    if (!$var6[0]) pagina::ejecutar("UPDATE noticias SET imagen_sec = ? WHERE md5(id_noticia) = ?;", array($var6[1], $id));
					    if (!$var7[0]) pagina::ejecutar("UPDATE noticias SET imagen_ter = ? WHERE md5(id_noticia) = ?;", array($var7[1], $id));
					    header('Location: ./');
					} else $errores = 'Error desconocido.';
				}
			} else $errores = 'Nombre ya en uso.';
		} else $errores = 'Completa al menos el título, la fecha, la información primaria y la imagen primaria.';
	} else $errores = 'Nombre no válido.';
}
$data = pagina::obtenerFila('SELECT * FROM noticias WHERE md5(id_noticia) = ?;', array($id));
if (empty($data)) header('Location: ./');
$var0 = $data['titulo'];
$var1 = $data['subtitulo'];
$var2 = $data['informacion_pri'];
$var3 = $data['informacion_sec'];
$var4 = $data['informacion_ter'];
$var5 = 'data:image/*;base64,'.$data['imagen_pri'];
$var6 = empty($data['imagen_sec']) ? '' : 'data:image/*;base64,'.$data['imagen_sec'];
$var7 = empty($data['imagen_ter']) ? '' : 'data:image/*;base64,'.$data['imagen_ter'];
$var8 = date('d/m/Y', strtotime($data['fecha']));

echo $cabecera;
?>
<br/>
<div class="row container">
	<form method='post' class='col s12' enctype='multipart/form-data' autocomplete="off">
		<div class='row'>
			<div class="col s12 m6">
				<div class="input-field col s11">
					<input placeholder="Título de la noticia" id="titulo" name="titulo" type="text" class="validate" length="50" onkeyup="disponible('<?php echo $_GET['id']; ?>')" value="<?php echo $var0; ?>" required>
					<label for="titulo">Título</label>
				</div>
				<div id='preloaderX' class="col s1"></div>
			</div>
			<div class="col s12 m6">
				<div class="input-field col s12">
					<input placeholder="Subtítulo de la noticia" id="subtitulo"  name="subtitulo" type="text" class="validate" length="75" value="<?php echo $var1; ?>">
					<label for="subtitulo">Subtítulo</label>
				</div>
			</div>
		</div>
		<div class="divider"></div>
		<div class='row'>
			<div class="col s12 m6 l4">
				<div class="input-field col s12">
				    <label for="informacion_pri">Bloque 1</label>
					<textarea id="informacion_pri" name="informacion_pri" placeholder="Primer bloque de información que se colocará en la noticia" class="materialize-textarea" length="1500" required><?php echo $var2; ?></textarea>
				</div>
			</div>
			<div class="col s12 m6 l4">
				<div class="col s12">
                    <p>Imagen actual</p>
                    <img class="responsive-img materialboxed" src="<?php echo $var5?>" alt="Imagen primaria actual">
				</div>
			</div>
			<div class="col s12 m6 l4">
				<p>
					<input type="checkbox" id="Archivo1" name="Archivo1"/>
					<label for="Archivo1">Modificar imagen</label>
				</p>
                <div class="file-field input-field col s12">
					<div class="btn">
						<span>Imagen</span>
						<input type="file" name="imagen_pri" id="imagen_pri">
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text" placeholder="PNG/JPG">
					</div>
				</div>
			</div>
		</div>
		<div class="divider"></div>
		<div class='row'>
			<div class="col s12 m6 l4">
				<div class="col s12">
				    <label for="informacion_sec">Bloque 2</label>
					<textarea id="informacion_sec" name="informacion_sec" placeholder="Segundo bloque de información que se colocará en la noticia" class="materialize-textarea" length="1500"><?php echo $var3; ?></textarea>
				</div>
			</div>
			<div class="col s12 m6 l4">
				<div class="input-field col s12">
                    <p>Imagen actual</p>
<?php echo (!empty($var6)) ? '<img class="responsive-img materialboxed" src="'.$var6.'" alt="Imagen secundaria actual">' : '<p>Sin imagen.</p>' ?>
				</div>
			</div>
			<div class="col s12 m6 l4">
				<p>
					<input type="checkbox" id="Archivo2" name="Archivo2" />
					<label for="Archivo2">Modificar imagen</label>
				</p>
                <div class="file-field input-field col s12">
					<div class="btn">
						<span>Imagen</span>
						<input type="file" name="imagen_sec" id="imagen_sec">
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text" placeholder="PNG/JPG">
					</div>
				</div>
			</div>
		</div>
		<div class="divider"></div>
		<div class='row'>
			<div class="col s12 m6 l4">
				<div class="input-field col s12">
				    <label for="informacion_ter">Bloque 3</label>
					<textarea id="informacion_ter" name="informacion_ter" placeholder="Segundo bloque de información que se colocará en la noticia" class="materialize-textarea" length="1500"><?php echo $var4; ?></textarea>
				</div>
			</div>
			<div class="col s12 m6 l4">
				<div class="col s12">
                    <p>Imagen actual</p>
<?php echo (!empty($var7)) ? '<img class="responsive-img materialboxed" src="'.$var7.'" alt="Imagen terciaria actual">' : '<p>Sin imagen.</p>' ?>
				</div>
			</div>
			<div class="col s12 m6 l4">
				<p>
					<input type="checkbox" id="Archivo3" name="Archivo3" />
					<label for="Archivo3">Modificar imagen</label>
				</p>
                <div class="file-field input-field col s12">
					<div class="btn">
						<span>Imagen</span>
						<input type="file" name="imagen_ter" id="imagen_ter">
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text" placeholder="PNG/JPG">
					</div>
				</div>
			</div>
		</div>
		<div class="divider"></div>
		<div class="row">
			<div class="col s12 m6">
				<div class="input-field col s12">
					<label for="fecha">Fecha de fin</label>
					<input id="fecha" type="date" class="datepicker" name="fecha" value="<?php echo empty($_POST['fecha']) ? $var8 : $_POST['fecha']; ?>">
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