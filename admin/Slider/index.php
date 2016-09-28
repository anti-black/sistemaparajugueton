<?php $N_FORM = 0;
require "../lib/pagina.php";
require("../../lib/database.php");

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

pagina::header('Slider' , true);
?>
		<br>
		<br>

<div class="container">

	<div class="row">

		<a href='crear.php'class='btn cyan darken-3 left'><i class='material-icons right'>playlist_add</i>nuevo</a>
		<br>
		<br>


<?php
//busqueda y listado de productos




	$sql = "SELECT * FROM slider ORDER BY estado DESC, id_slider ASC;";
	$params = null;
	$data = Database::getRows($sql, $params);
if($data != null)
	//mostramos la tabla en la que se presentan la informacion
{
	$tabla = 	"<table class='centered striped'>
	<thead>
		<tr>

						<th>Imagen</th>


			<th>Estado</th>
		</tr>
	</thead>
	<tbody>";
		foreach($data as $row)
		{
			$tabla .= 	"<tr>


			<td><div><img class='materialboxed' width='150' src='data:image/*;base64,$row[imagen]' alt='Imagen producto'></div></td>
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
					<a href='modificar.php?id=$row[id_slider]' class='btn blue'><i class='material-icons'>mode_edit</i></a>";

				if ($row['estado'] == 1)
					$tabla .= "	<a href='estado.php?id=$row[id_slider]' class='btn red'><i class='material-icons'>visibility_off</i></a>";
				else
					$tabla .= "	<a href='estado.php?id=$row[id_slider]' class='btn red'><i class='material-icons'>visibility</i></a>";

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
Pagina::footer();
?>