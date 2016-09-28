<?php
require("../lib/pagina.php");
require("../../lib/database.php");
Pagina::header("Eliminar emplado");

if(!empty($_GET['id']))
{
    $id = $_GET['id'];
}
else
{
    header("location: index.php");
}

if(!empty($_POST))
{
	$id = $_POST['id'];
	try
	{
		if($id != $_SESSION['id_empleado'])
		{
			$sql = "DELETE FROM empleados WHERE id_empleado = ?";
		    $params = array($id);
		    Database::executeRow($sql, $params);
		    header("location: index.php");
		}
		else
		{
			throw new Exception("No se puede eliminar a sí mismo.");
		}
	}
	catch (Exception $error)
	{
		print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
	}
}
?>
<form method='post' class='row'>
	<input type='hidden' name='id' value='<?php print($id); ?>'/>
	<button type='submit' class='btn red'><i class='material-icons right'>done</i>Si</button>
	<a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>No</a>
</form>
<?php
Pagina::footer();
?>