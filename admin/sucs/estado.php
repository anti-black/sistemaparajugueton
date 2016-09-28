<?php
require "../lib/pagina.php";
require("../../lib/database.php");
$cabecera = pagina::header('Estado de sucursal');
if(empty($_GET['id'])){
    $id = null;
    $estado = 1;
}
if (isset($_POST['id']))
    $id = $_POST['id'];
else {
    Pagina::header("Modificar estado");
    $id = $_GET['id'];
    $sql = "SELECT * FROM sucursales WHERE id_sucursal = ?";
    $params = array($id);
    $data = pagina::obtenerFila($sql, array($id));
    $estado = $data['estado'];
}
if(!empty($_POST)) {
    $_POST = Pagina::validarForm($_POST);
    $estado = $_POST['estado'];
    if($estado == "")
        $estado = null;
    if($id == null) {
        $sql = "INSERT INTO sucursales(estado) VALUES(?)";
        $params = array($estado);
    }
    else {
        $sql = "UPDATE sucursales SET  estado = ? WHERE id_sucursal = ?";
        $params = array($estado, $id);
        if (pagina::ejecutar($sql, $params)) {
            header("location: ./");
        }
    }
}

echo $cabecera; ?>
<!---Formulario para agregar productos y actualizar datos-->
<form method='post'class='row' enctype='multipart/form-data' autocomplete="off" action="estado.php">
    <div class='row'>
        <div class='file-field input-field col s12 m6'>
            <div class='input-field col s12 m6'>
            <label>Estado:</label>
            <br>
            <br>
            <input id='activo' type='radio' name='estado' class='with-gap' value='1' <?php print(($estado == 1)?"checked":""); ?>/>
            <label for='activo'><i class='material-icons'>visibility</i></label>
            <input id='inactivo' type='radio' name='estado' class='with-gap' value='0' <?php print(($estado == 0)?"checked":""); ?>/>
            <label for='inactivo'><i class='material-icons'>visibility_off</i></label>
            <br>
            <input type="text" name='id' class='hide' value='<?php echo $id;?>'/>
            </div>
        </div>
    </div>
    <br>
    <a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>Cancelar</a>
    <button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>
<?php echo Pagina::footer();
?>