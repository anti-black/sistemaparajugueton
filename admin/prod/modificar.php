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
  echo Pagina::header("Agregar producto");
  //declaramos variables
  $id = null;
  $nombre = null;
  $descripcion = null;
  $existencia = null;
  $precio_normal_producto = null;
  $precio_oferta_producto = null;
  $precio_afiliado_producto = null;
  $imagen = null;
  $categoria = null;
  $clasificacion = null;
  $marca = null;
  $codigo = null;


}
else
{//encabezado de la pagina
  Pagina::header("Modificar producto");
  $id = $_GET['id'];
  if(isset($_POST['id']))
    $id = $_POST['id'];
  //echo $id;
  $sql = "SELECT * FROM productos WHERE id_producto = ?";
  $params = array($id);
  $data = pagina::obtenerFila($sql, array($id));
  //declaramos variables
  $nombre = $data['nombre_producto'];
  $descripcion = $data['descripcion_producto'];
  $existencia = $data['existencias_producto'];
  $precio_normal_producto = $data['precio_normal_producto'];
  $precio_oferta_producto = $data['precio_oferta_producto'];
  $precio_afiliado_producto = $data['precio_afiliado_producto'];
  $imagen = $data['imagen'];
  $categoria = $data['id_categoria'];
  $clasificacion = $data['id_clasificacion'];
  $marca = $data['id_marca'];
  $codigo = $data ['codigo'];

}
//echo $id;
//echo "HOlaa";
if(!empty($_POST))
{//declaramos variables con metodo POST
  $_POST = Pagina::validarForm($_POST);
  //declaramos variables
  $nombre = $_POST['nombre'];
  //echo $nombre ."**";
  $descripcion = $_POST['descripcion'];
  //echo $descripcion ."**";
  $existencia = $_POST['existencias_producto'];
  //echo $existencia ."**";
  $precio_normal_producto = $_POST['precio_normal_producto'];
  //echo $precio_normal_producto ."**";
  $precio_oferta_producto = $_POST['precio_oferta_producto'];
  //echo $precio_oferta_producto ."**";
  $precio_afiliado_producto = $_POST['precio_afiliado_producto'];
  //echo $precio_afiliado_producto ."**";
  $archivo = $_FILES['imagen'];
  //echo $archivo['name'];
  $estado = $_POST['estado'];
  //echo $estado;
  $categoria = $_POST['categoria'];
  //echo $categoria ."**";
  $clasificacion = $_POST['clasificacion'];
  //echo $clasificacion ."**";
  $marca = $_POST['marca'];
  //echo $marca ."**";
  $codigo = $_POST['codigo'];
  $id = $_POST['id'];

  if($descripcion == "")
  {
    $descripcion = null;
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
   $sql = "INSERT INTO productos(codigo,nombre_producto, descripcion_producto, existencias_producto, precio_normal_producto, precio_oferta_producto, precio_afiliado_producto, imagen, id_categoria , id_clasificacion , id_marca,estado) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
   $params = array($codigo,$nombre, $descripcion, $existencia, $precio_normal_producto, $precio_oferta_producto , $precio_afiliado_producto, $imagen, $categoria, $clasificacion, $marca,1);
   //$params = array(78657,"Nombre2", "Descrip2", 10, 40, 30 ,10, $imagen, 2, 2, 3,1);
   if (pagina::ejecutar($sql, $params)) {
 //      echo "Agregado";
 header('Location: ./');
   }
 }
 else
 {//Se sustituyen los valores que ya estaban por los nuevos
  $sql = "UPDATE productos SET nombre_producto = ?, descripcion_producto = ?, existencias_producto = ?, precio_normal_producto = ?, precio_oferta_producto = ?, precio_afiliado_producto = ?, imagen =?,id_categoria = ? , id_clasificacion = ?, id_marca = ? WHERE id_producto = ?";
  $params = array($nombre, $descripcion, $existencia, $precio_normal_producto, $precio_oferta_producto , $precio_afiliado_producto, $imagen, $categoria, $clasificacion, $marca, $id);
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

    <div class='input-field col s12 m6'>
     <i class='material-icons prefix'>add</i>
     <input id='nombre' type='text' name='nombre' class='validate' length='50' maxlenght='50' value='<?php print($nombre); ?>' required/>
     <label for='nombre'>Nombre</label>
   </div>
   <div class='input-field col s12 m6'>
   <i class='material-icons prefix'>description</i>
   <input id='descripcion' type='text' name='descripcion' class='validate' length='200' maxlenght='500' value='<?php print($descripcion); ?>'/>
   <label for='descripcion'>Descripción</label>
   </div>
   <div class='input-field col s12 m6'>
   <i class='material-icons prefix'>description</i>
   <input id='codigo' type='text' name='codigo' class='validate' length='200' maxlenght='200' value='<?php print($codigo); ?>'/>
   <label for='codigo'>Codigo</label>
   </div>
   <div class='input-field col s12 m6'>
     <i class='material-icons prefix'>shopping_cart</i>
     <input id='precio_normal_producto' type='number' name='precio_normal_producto' class='validate' max='999.99' min='0.01' step='any' value='<?php print($precio_normal_producto); ?>' required/>
     <label for='precio_normal_producto'>normal ($)</label>
   </div>
 </div>
 <div class='row'>
 	<div class='input-field col s12 m6'>
 		<i class='material-icons prefix'>shopping_cart</i>
     <input id='precio_oferta_producto' type='number' name='precio_oferta_producto' class='validate' max='999.99' min='0.01' step='any' value='<?php print($precio_oferta_producto); ?>' required/>
     <label for='precio_oferta_producto'>oferta ($)</label>
 	</div>
 	<div class='input-field col s12 m6'>
 		<i class='material-icons prefix'>shopping_cart</i>
     <input id='precio_afiliado_producto' type='number' name='precio_afiliado_producto' class='validate' max='999.99' min='0.01' step='any' value='<?php print($precio_afiliado_producto); ?>' required/>
     <label for='precio_afiliado_producto'>afiliado ($)</label>
 	</div>
 	<div class='input-field col s12 m6'>
 		<i class='material-icons prefix'>shopping_cart</i>
     <input id='existencias_producto' type='number' name='existencias_producto' class='validate' max='999.99' min='0.01' step='any' value='<?php print($existencia); ?>' required/>
     <label for='existencias_producto'>Existencias</label>
 	</div>

 	</div>
 <div class='row'>
  <div class='input-field col s12 m6'>

 <div class='input-field col s12 m6'>
						<?php pagina::armarCombo('categoria', $categoria, "SELECT * FROM categorias") ?>
					</div>
					</div>
					<div class='input-field col s12 m6'>
						<?php pagina::armarCombo('clasificacion', $categoria, "SELECT * FROM clasificaciones") ?>
					</div>
					<div class='input-field col s12 m6'>
						<?php pagina::armarCombo('marca', $categoria, "SELECT * FROM marcas") ?>
					</div>
</div>
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