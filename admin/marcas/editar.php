<?php require "../lib/pagina.php"; require("../../lib/database.php");

$cabecera = Pagina::header("Modificar marca");

$id = pagina::URLD64($_GET['id']); $errores = '';
$data = pagina::obtenerFila("SELECT * FROM marcas WHERE md5(id_marca) = ?;", array($id));
$marca = $data['marca'];
$img= 'data:image/*;base64,'.$data['img_marca'];
if(empty($data))
    header('Location: ./');

if(!empty($_POST)) {
    $_POST = pagina::validarForm($_POST);
    $var = $_POST['marca'];
    $var2 = $id;
    $data = pagina::obtenerFilas('SELECT * FROM marcas WHERE marca LIKE ? AND md5(id_marca) != ?;', array($var, $var2));
	if (preg_match("/^[a-zA-Z \x7f-\xff]{1,35}$/", $var)) {
        if (empty($data)){
            if (isset($_FILES['Archivo']) && isset($_POST['ArchivoA'])) {
                $Archivo = $_FILES['Archivo'];
                $EstadoArchivo = pagina::validarImagen($Archivo);
                if (mb_strlen($EstadoArchivo) == 0) {
                    $Archivo = pagina::convertirA64($Archivo);
                    $marca = $_POST['marca'];
                    $sql = "UPDATE marcas SET marca = ?, img_marca = ? WHERE md5(id_marca) = ?;";
                    $params = array($marca, $Archivo, $id);
                    if (pagina::ejecutar($sql, $params))
                        header('Location: ./');
                } else
                    $errores = $EstadoArchivo;
            } else {
                $marca = $_POST['marca'];
                $sql = "UPDATE marcas SET marca = ? WHERE md5(id_marca) = ?;";
                $params = array($marca, $id);
                if (pagina::ejecutar($sql, $params))
                    header('Location: ./');
            }
        } else
            $errores = 'Nombre ya en uso.';
    }
    else
        $errores = 'Nombre no válido.';
}

echo $cabecera;
?>
<br/>
<div class="container row">
    <form method='post' action='?id=<?php echo $_GET['id']; ?>' class='col s12' enctype='multipart/form-data' autocomplete="off">
        <div class='row'>
            <div class="col s12 m4 l4">
                <div class="input-field col s10">
                    <i class='material-icons prefix'>add</i>
                    <input placeholder="Nombre de marca" id="marca"  name="marca" type="text" class="validate" length="35" onkeyup="disponible('<?php echo $_GET['id']; ?>')" value="<?php echo $marca; ?>">
                    <label for="marca">Marca</label>
                </div>
                <div id='preloaderX' class="col s2"></div>
            </div>
            <div class="col s12 m4 l4">
                <p>Imagen actual</p>
                <img id="imagen" class='col s12 materialboxed' src='<?php print($img); ?>' alt='Imagen de categoría'>
            </div>
            <div class="col s12 m4 l4">
                <div class="file-field input-field col s12">
					<div class="btn">
						<span>Imagen</span>
						<input type="file" name="Archivo" id="Archivo">
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text" placeholder="PNG/JPG">
					</div>
		    	</div>
		    	<br/>
                <p>
                    <input type="checkbox" name="ArchivoA" id="ArchivoA" <?php print(''); ?> />
                    <label for="ArchivoA">Actualizar</label>
                </p>
            </div>
        </div>
        <br/>
        <div class="row">
            <a href='index.php' class='btn grey left'><i class='material-icons right'>cancel</i>Cancelar</a>
            <button type='submit' class='btn blue right'><i class='material-icons right'>save</i>Guardar</button>
        </div>
    </form>
</div>
<?php echo strlen($errores) > 0 ? '<div class="row"><div class="card red white-text"><div class="col s12 push-m3 m6 push-l4 l4"><p>'.$errores.'</p></div></div></div>' : ''; ?>
<script type="text/javascript" src="comandos.js"></script>
<?php echo Pagina::footer(); ?>