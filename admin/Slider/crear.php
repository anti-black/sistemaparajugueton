<?php

//enlace al formato de la pagina
require "../lib/pagina.php";
//enlace a la base de datos
require("../../lib/database.php");

$id = 0;
if(isset($_POST['id']))
    $id = $_POST['id'];
//echo $id;
//verificamos si los campos estan vacios o no si no estan vacios se hace la consulta necesaria para actualizar datos
if(empty($_GET['id']) && $id == 0)
{//encabezado de la pagina
  Pagina::header("Agregar imagen");
  //declaramos variables
  $id = null;
  $imagen = null;



}
else
{//encabezado de la pagina
  Pagina::header("Modificar Slider");
  $id = $_GET['id'];
  if(isset($_POST['id']))
    $id = $_POST['id'];
  //echo $id;
  $sql = "SELECT * FROM slider WHERE id_slider = ?";
  $params = array($id);
  $data = pagina::obtenerFila($sql, array($id));
  //declaramos variables

  $imagen = $data['imagen'];

}
//echo $id;
//echo "HOlaa";
if(!empty($_POST))
{//declaramos variables con metodo POST
  $_POST = Pagina::validarForm($_POST);

  $archivo = $_FILES['imagen'];

  $id = $_POST['id'];

  if($archivo == "")
  {
    $archivo = null;
  }

  try
  {
   if($archivo['name'] != null)
   {
    $base64 = pagina::convertirA64($archivo);
    if($base64 != false)
    {
      $imagen = $base64;
      //echo $imagen;
    }
    else
    { //mensaje de error
      throw new Exception("La imagen seleccionada no es valida.");
    }
  }
  else
  {
    if($imagen == null)
    {//mensaje de error
      throw new Exception("Debe seleccionar una imagen.");
    }
  }
    //Si los campos estan vacios se agrega un nuevo registro, de lo contrario solo se actualizan los datos
  if($id == null)
  {
   $sql = "INSERT INTO slider(imagen, estado) VALUES(?,?)";
   $params = array($imagen,1);
   //$params = array(78657,"Nombre2", "Descrip2", 10, 40, 30 ,10, $imagen, 2, 2, 3,1);
   if (pagina::ejecutar($sql, $params)) {
 //      echo "Agregado";
 header('Location: ./');
   }
 }
 else
 {//Se sustituyen los valores que ya estaban por los nuevos
  $sql = "UPDATE slider SET imagen = ? WHERE id_slider = ?";
  $params = array($imagen, $id);
  if (pagina::ejecutar($sql, $params)) {
 //      echo "Agregado";
 header('Location: ./');
   }
}
}
catch (Exception $error)
{
  print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
}
}
?>
<!---Formulario para agregar productos y actualizar datos-->
<form method='post' class='row' enctype='multipart/form-data' autocomplete="off" action="crear.php">
  <div class='row'>

     <input id='nombre' type='text' name='id' class='hide' value='<?php print($id); ?>'/>

<div class='row'>
 <div class='file-field input-field col s12 m6'>
  <div class='btn'>
    <span>Imagen</span>
    <input type='file' name='imagen'>
  </div>
  <div class='file-path-wrapper'>
    <input class='file-path validate' type='text' placeholder='1200x1200px máx., 2MB máx., PNG/JPG/GIF'>
  </div>
</div>

</div>
<a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>Cancelar</a>
<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>
<?php
Pagina::footer();
?>