<?php

require "../lib/pagina.php";
//enlace a la base de datos
require("../../lib/database.php");

//verificamos si los campos estan vacios o no si no estan vacios se hace la consulta necesaria para actualizar datos
if(empty($_GET['id']))
{//encabezado de la pagina
  echo Pagina::header("Agregar producto");
  //declaramos variables
  $id = null;

  $estado = 1;

}
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
else
{//encabezado de la pagina
  Pagina::header("Modificar estado");
  $id = $_GET['id'];
  $sql = "SELECT * FROM productos WHERE id_producto = ?";
  $params = array($id);
  $data = pagina::obtenerFila($sql, array($id));
  //declaramos variables
  $estado = $data['estado'];

}

if(!empty($_POST))
{//declaramos variables con metodo POST
  $_POST = Pagina::validarForm($_POST);
  //declaramos variables
  $estado = $_POST['estado'];
    //echo $estado;
  if($estado == "")
  {
    $estado = null;
  }



    //Si los campos estan vacios se agrega un nuevo registro, de lo contrario solo se actualizan los datos
  if($id == null)
  {
   $sql = "INSERT INTO productos(estado) VALUES(?)";
   $params = array($estado);
   //echo("holaa");
 }
 else
 {//Se sustituyen los valores que ya estaban por los nuevos
  $sql = "UPDATE productos SET  estado = ? WHERE id_producto = ?";
  $params = array($estado, $id);
   if (pagina::ejecutar($sql, $params)) {
         header("location: index.php");
   }
}
}
?>
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
<?php echo Pagina::footer(); ?>