<?php
//enlace al formato de la pagina
require("../lib/pagina.php");
//enlace a la base de datos
require("../../lib/database.php");
//encabezado de la pagina
 echo Pagina::header("Clientes");
?>
<!--formulario donde hacemos busquedas, y agregamos un nuevo producto-->
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
//busqueda y listado de productos
if(!empty($_POST))
{
	$search = trim($_POST['buscar']);
	$sql = "SELECT * FROM clientes WHERE nombre_cliente LIKE ? ORDER BY estado DESC, id_cliente ASC;";
	$params = array("%$search%");
}
else
{
	$sql = "SELECT * FROM clientes ORDER BY estado DESC, id_cliente ASC";
	$params = null;
}
$data = Database::getRows($sql, $params);
if($data != null)
	//mostramos la tabla en la que se presentan la informacion
{
	$tabla = 	"<table class='centered striped'>
	<thead>
		<tr>
			<th>Nombre</th>
				<th>Apellido</th>

			<th>Estado</th>
		</tr>
	</thead>
	<tbody>";
		foreach($data as $row)
		{
			$tabla .= 	"<tr>

			<td>$row[nombre_cliente]</td>
			<td>$row[apellido_cliente]</td>

			<td>";

	if($row['estado'] == 1)
				{
					$tabla .= "<i class='material-icons'>visibility</i>";
				}
				else
				{
					$tabla .= "<i class='material-icons'>visibility_off</i>";
				}
				$tabla .= 	"</td>
				<td>
					<a href='ver.php?id=$row[id_cliente]' class='btn blue-grey darken-2'><i class='material-icons'>person</i></a>";

				if ($row['estado'] == 1)
					$tabla .= "	<a href='estado.php?id=$row[id_cliente]' class='btn red'><i class='material-icons'>visibility_off</i></a>";


				else
					$tabla .= "	<a href='estado.php?id=$row[id_cliente]' class='btn red'><i class='material-icons'>visibility</i></a>";


				$tabla .= "

				</td>
			</tr>";
		}
		$tabla .= "</tbody>
	</table>";
	//imprimimos la variable tabla
	print($tabla);
}
else
{
	print("<div class='card-panel yellow'><i class='material-icons left'>warning</i>No hay registros.</div>");
}
 echo Pagina::footer();
?>