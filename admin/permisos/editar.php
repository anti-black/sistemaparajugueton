<?php require "../lib/pagina.php"; require("../../lib/database.php");

$id = pagina::URLD64($_GET['id']); $errores = '';
$data = pagina::obtenerFila("SELECT * FROM categorias WHERE md5(id_categoria) = ?;", array($id));
$categoria = $data['categoria'];
if(empty($data))
    header('Location: ./');

if(!empty($_POST)) {
    $_POST = pagina::validarForm($_POST);
    $var = $_POST['categoria'];
    $var2 = pagina::URLD64($_POST['o']);
    $data = pagina::obtenerFilas('SELECT * FROM categorias WHERE categoria LIKE ? AND md5(id_categoria) != ?;', array($var, $var2));
    if (strlen($var) > 0) {
        if (empty($data)){
            $categoria = $_POST['categoria'];
            $sql = "UPDATE categorias SET categoria = ? WHERE md5(id_categoria) = ?";
            $params = array($categoria, $id);
            if (pagina::ejecutar($sql, $params))
                header('Location: ./');
        } else
            $errores = 'Nombre ya en uso.';
    }
    else
        $errores = 'Nombre no válido.';
}
Pagina::header("Modificar categoria");
?>
<br/>
<div class="row">
    <form method='post' action='?id=<?php echo $_GET['id']; ?>' class='col s12 push-m3 m6 push-l4 l4' enctype='multipart/form-data' autocomplete="off">
        <div class='row'>
            <div class="input-field col s10">
                <i class='material-icons prefix'>add</i>
                <input placeholder="Nombre de categoría" id="categoria"  name="categoria" type="text" class="validate" length="35" onkeyup="disponible('<?php echo $_GET['id']; ?>')" value="<?php echo $categoria; ?>">
                <label for="categoria">Categoría</label>
            </div>
            <div id='preloaderX' class="col s2">
            </div>
            <input id='nombre' type='text' name='id' class='hide' value='<?php print($id); ?>'/>
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
<?php Pagina::footer(); ?>