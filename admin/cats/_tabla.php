<?php require("../lib/pagina.php");

if(!empty($_POST)) {
	$search = trim($_POST['buscar']);
	$sql = "SELECT *, (SELECT COUNT(*) FROM productos WHERE productos.id_categoria = categorias.id_categoria) AS cuenta FROM categorias WHERE categoria LIKE ? ORDER BY estado DESC, id_categoria ASC;";
	$params = array("%$search%");
}
else {
	$sql = "SELECT *, (SELECT COUNT(*) FROM productos WHERE productos.id_categoria = categorias.id_categoria) AS cuenta FROM categorias ORDER BY estado DESC, id_categoria ASC;";
	$params = null;
}
$data = pagina::obtenerFilas($sql, $params);
if($data != null) {
	$modales = '';
	$tabla = "
<div class='container'>
	<table class='highlight'>
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Estado</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>";
	foreach($data as $row)
	{
		$id = pagina::URLA64(md5($row['id_categoria']));
		$no = $row['categoria'];
		$es = $row['estado'];
		$tabla .= 	"
			<tr>
				<td>$no</td>
				<td>".($es ?  "<i class='material-icons'>visibility</i>" : "<i class='material-icons'>visibility_off</i>")."</td>
				<td>
					<a href='editar.php?id=$id' class='btn btn-flat blue'><i class='material-icons white-text'>mode_edit</i></a>".
					($es ?
						"<a href='#ocultar_$id' class='waves-effect waves-light btn modal-trigger btn btn-flat orange'><i class='material-icons white-text'>visibility_off</i></a>" :
						"<a href='#mostrar_$id' class='waves-effect waves-light btn modal-trigger btn btn-flat orange'><i class='material-icons white-text'>visibility</i></a>").
					(($row['cuenta'] < 1) ?
						"<a class='waves-effect waves-light btn modal-trigger red' href='#eliminacion_$id'><i class='material-icons white-text'>delete_forever</i></a>" : '')."
				</td>
			</tr>";
		$modales .= "
		<div id='eliminacion_$id' class='modal'>
			<div class='modal-content'>
				<h4>Eliminar categoría</h4>
				<p>Esta eliminación es parmanente, está habilitada por que ésta informacion no está siendo usada, Desea eliminar la categoría: \"$no\"</p>
			</div>
			<div class='modal-footer'>
				<a onclick=\"$('#eliminacion_$id').closeModal(); eliminar('$id');\" class='modal-action modal-close btn btn-flat red'><i class='material-icons right'>delete_forever</i>Eliminar</a>
				<a class='modal-action modal-close btn btn-flat green'><i class='material-icons right'>cancel</i>Cancelar</a>
			</div>
		</div>

		<div id='mostrar_$id' class='modal'>
			<div class='modal-content'>
				<h4>Mostrar categoría</h4>
				<p>La categoría actualmente está ocultada para su uso, está por mostrar: \"$no\"</p>
			</div>
			<div class='modal-footer'>
				<a onclick=\"$('#mostrar_$id').closeModal(); permutar('$id', 1);\" class='modal-action modal-close btn btn-flat orange'><i class='material-icons right'>visibility</i>Mostar</a>
				<a class='modal-action modal-close btn btn-flat green'><i class='material-icons right'>cancel</i>Cancelar</a>
			</div>
		</div>

		<div id='ocultar_$id' class='modal'>
			<div class='modal-content'>
				<h4>Ocultar categoría</h4>
				<p>La categoría actualmente está visible para su uso, está por ocultar: \"$no\"</p>
			</div>
			<div class='modal-footer'>
				<a onclick=\"$('#ocultar_$id').closeModal(); permutar('$id', 0);\" class='modal-action modal-close btn btn-flat orange'><i class='material-icons right'>visibility_off</i>Ocultar</a>
				<a class='modal-action modal-close btn btn-flat green'><i class='material-icons right'>cancel</i>Cancelar</a>
			</div>
		</div>
		";
	}
	$tabla .= "
		</tbody>
	</table>
</div>";
	print($tabla);
	print($modales);
}
else
{
	print("<div class='card-panel yellow'><i class='material-icons left'>warning</i>No hay registros.</div>");
}
?>