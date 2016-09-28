<?php $N_FORM = 0;
require "../lib/pagina.php";
require("../../lib/database.php");

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

echo pagina::header('Productos' , true);
?>
<div class="container">
	<center><h3>Productos</h3></center>
	<div class="row">
		<form method="get" autocomplete="off" onpaste="return false" oncut="return false" oncopy="return false">
			 <div class='input-field col s6 m4'>

				<i class='material-icons prefix'>search</i>
				<input name="busqueda" id="search" type="search" <?php echo "value='$busqueda'" ?> required>
				<label for='buscar'>Búsqueda</label>
				</div>
				<div class='input-field col s6 m4'>
      <!--Boton para ejecutar la busqueda-->
			</div>
		</form>
		<a href='crear.php'class='btn cyan darken-3 left'><i class='material-icons right'>playlist_add</i>nuevo</a>
		<a href='precios.php'class='btn green darken-1'><i class='material-icons'>publish</i></a>
<?php
//busqueda y listado de productos
if(!empty($_POST))
{
	$search = trim($_POST['buscar']);
	$sql = "SELECT * FROM productos WHERE nombre_producto LIKE ? ORDER BY estado DESC, id_producto ASC;";
	$params = array("%$search%");
}
else
{
	$sql = "SELECT * FROM productos ORDER BY estado DESC, id_producto ASC;";
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
						<th>Imagen</th>
									<th>Precio</th>

			<th>Estado</th>
		</tr>
	</thead>
	<tbody>";
		foreach($data as $row)
		{
			$tabla .= 	"<tr>

			<td>$row[nombre_producto]</td>
			<td><div><img class='materialboxed' width='150' src='data:image/*;base64,$row[imagen]' alt='Imagen producto'></div></td>

			<td>$row[precio_normal_producto]</td>

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
					<a href='modificar.php?id=$row[id_producto]' class='btn blue'><i class='material-icons'>mode_edit</i></a>";

				if ($row['estado'] == 1)
					$tabla .= "	<a href='estado.php?id=$row[id_producto]' class='btn red'><i class='material-icons'>visibility_off</i></a>";
				else
					$tabla .= "	<a href='estado.php?id=$row[id_producto]' class='btn red'><i class='material-icons'>visibility</i></a>";

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
echo Pagina::footer(); ?>