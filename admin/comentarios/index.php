<?php
//enlace al formato de la pagina
require("../lib/pagina.php");
//enlace a la base de sdatos
require("../../lib/database.php");
//encabezado de la pagina
 echo Pagina::header("Comentarios");
?>
<!--formulario de la busqueda y agregar un nuevo cliente-->
<form method='post' class='row' autocomplete="off" onpaste="return false" oncut="return false" oncopy="return false">
	<div class='input-field col s6 m4'>
		<i class='material-icons prefix'>search</i>
		<input id='buscar' type='text' name='buscar' class='validate'/>
		<label for='buscar'>Búsqueda</label>
	</div>
	<div class='input-field col s6 m4'>
		<button type='submit' class='btn grey left'><i class='material-icons right'>pageview</i>Aceptar</button>
	</div>

</form>
<?php
if(!empty($_POST))
{ //consulta para la busqueda de los comentarios
	$search = trim($_POST['buscar']);
	$sql = "SELECT * FROM comentarios, productos, clientes WHERE comentarios.id_producto = productos.id_producto AND comentarios.id_cliente = clientes.id_cliente AND comentario like ?";
	$params = array("%$search%");
}
else
{
	$sql = "SELECT * FROM comentarios, productos, clientes WHERE comentarios.id_producto = productos.id_producto AND comentarios.id_cliente = clientes.id_cliente";
	$params = null;
}

$data = Database::getRows($sql, $params);
//Aca nos muestra en forma de tabla todas los clientes
if($data != null)
{
	$tabla = 	"<table class='centered striped'>
	<thead>
		<tr>

			<th>Cliente</th>
			<th>PRODUCTO</th>
			<th>COMENTARIO</th>


		</tr>
	</thead>
	<tbody>";
		foreach($data as $row)
		{
			$tabla .= 	"<tr>

			<td>$row[nombre_cliente]</td>
			<td>$row[nombre_producto]</td>
			<td>$row[comentario]</td>




			<td>";
	            /*if($row['estado'] == 1)
				{
					$tabla .= "<i class='material-icons'>visibility</i>";
				}
				else
				{
					$tabla .= "<i class='material-icons'>visibility_off</i>";
				}*/
				$tabla .= 	"</td>
				<td>

					<a href='delete.php?id=$row[id_comentario]' class='btn red'><i class='material-icons'>delete</i></a>
				</td>
			</tr>";
		}
		$tabla .= "</tbody>
	</table>";
	//imprimimos los valores dentro de la variable tabla
	print($tabla);
}
else
{
	print("<div class='card-panel yellow'><i class='material-icons left'>warning</i>No hay registros.</div>");
}
echo Pagina::footer();
?>