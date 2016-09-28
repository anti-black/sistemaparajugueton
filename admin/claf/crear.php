<?php require "../lib/pagina.php"; require("../../lib/database.php");

$cabecera = Pagina::header("Crear clasificación");
$clasificacion = '';

if(!empty($_POST)) {
    $_POST = pagina::validarForm($_POST);
    $clasificacion = $var = $_POST['clasificacion'];
    $data = pagina::obtenerFilas('SELECT * FROM clasificaciones WHERE clasificacion LIKE ?;', array($var));
	if (preg_match("/^[a-zA-Z \x7f-\xff]{1,35}$/", $var)) {
        if (empty($data)){
            $clasificacion = $_POST['clasificacion'];
            $sql = "INSERT INTO clasificaciones(clasificacion) VALUES (?);";
            $params = array($clasificacion);
            if (pagina::ejecutar($sql, $params))
                header('Location: ./');
        } else
            $errores = 'Nombre ya en uso.';
    }
    else
        $errores = 'Nombre no válido.';
}
echo $cabecera;
?>
<br/>
<div class="row container">
    <form method='post' class='col s12 push-m3 m6 push-l4 l4' enctype='multipart/form-data' autocomplete="off">
        <div class='row'>
            <div class="input-field col s10">
                <i class='material-icons prefix'>add</i>
                <input placeholder="Nombre de clasificación" id="clasificacion"  name="clasificacion" type="text" class="validate" length="35" onkeyup="disponible('<?php echo $_GET['id']; ?>')" value="<?php echo $clasificacion; ?>">
                <label for="clasificacion">Clasificación</label>
            </div>
            <div id='preloaderX' class="col s2"></div>
            <input id='nombre' type='text' name='id' class='hide' value='<?php print($id); ?>'/>
        </div>
        <br/>
        <div class="row">
            <a href='index.php' class='btn grey left'><i class='material-icons right'>cancel</i>Cancelar</a>
            <button type='submit' class='btn blue right'><i class='material-icons right'>save</i>Guardar</button>
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