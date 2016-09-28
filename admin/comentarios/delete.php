<?php
//Enlace para el formato de la pagina
require("../lib/pagina.php");
//enlace para base de datos
require("../../lib/database.php");
//encabezado de la pagina
echo Pagina::header("Eliminar comentario");

if(!empty($_GET['id']))
{
	$id = $_GET['id'];
}
else
{
	header("location: index.php");
}
//Proceso para mostrar y eliminar comentarios
if(!empty($_POST))
{
	$id = $_POST['id'];
	try
	{
		$sql = "DELETE FROM comentarios WHERE id_comentario = ?";
		$params = array($id);
		Database::executeRow($sql, $params);
		header("location: index.php");
	}
	catch (Exception $error)
	{
		print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
	}
}
?>
<br>
<br>
<br>
<br>
<center><h4>¿Esta seguro de eliminar el comentario?</h4></center>
<!--formulario donde estan los comentarios-->
<center><form method='post' class='row'>
	<input type='hidden' name='id' value='<?php print($id); ?>'/>
	<button type='submit' class='btn red'><i class='material-icons right'>done</i>Si</button>
	<a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>No</a>
</form></center>
<?php
echo Pagina::footer();
?>