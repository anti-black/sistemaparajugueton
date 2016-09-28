<?php require("../lib/pagina.php");

function mes($mes){
	switch ($mes) {
		case 'January': return 'Enero';
		case 'February': return 'Febrero';
		case 'March': return 'Marzo';
		case 'April': return 'Abril';
		case 'May': return 'Mayo';
		case 'June': return 'Junio';
		case 'July': return 'Julio';
		case 'August': return 'Agosto';
		case 'September': return 'Septiembre';
		case 'October': return 'Octubre';
		case 'November': return 'Noviembre';
		case 'December': return 'Diciembre';
		default: return $mes;
	}
}

if(!empty($_POST)) {
	$search = trim($_POST['buscar']);
	$sql = "SELECT * FROM eventos WHERE nombre_evento LIKE ? ORDER BY estado DESC, id_evento ASC;";
	$params = array("%$search%");
}
else {
	$sql = "SELECT * FROM eventos ORDER BY estado DESC, id_evento ASC;";
	$params = null;
}
$data = pagina::obtenerFilas($sql, $params);
if($data != null) {
	$modales = '';
	$tabla = "
<div class='container'>
	<table class='highlight responsive-table'>
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Lugar</th>
				<th>Inicio</th>
				<th>Fin</th>
				<th>Estado</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>";
	foreach($data as $row)
	{
		$id = pagina::URLA64(md5($row['id_evento']));

		$fe = date('j', strtotime($row['fecha_inicio'])).' de '.mes(date('F', strtotime($row['fecha_inicio']))).', '.date('Y', strtotime($row['fecha_inicio']));
		$ff = date('j', strtotime($row['fecha_fin'])).' de '.mes(date('F', strtotime($row['fecha_fin']))).', '.date('Y', strtotime($row['fecha_fin']));
		$lu = $row['lugar'];
		$ne = $row['nombre_evento'];
		$es = $row['estado'];
		$tabla .= 	"
			<tr>
				<td>$ne</td>
				<td>$lu</td>
				<td>$fe</td>
				<td>$ff</td>
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
				<p>Esta eliminación es parmanente, Desea eliminar el evento: \"$ne\"</p>
			</div>
			<div class='modal-footer'>
				<a onclick=\"$('#eliminacion_$id').closeModal(); eliminar('$id');\" class='modal-action modal-close btn btn-flat red'><i class='material-icons right'>delete_forever</i>Eliminar</a>
				<a class='modal-action modal-close btn btn-flat green'><i class='material-icons right'>cancel</i>Cancelar</a>
			</div>
		</div>

		<div id='mostrar_$id' class='modal'>
			<div class='modal-content'>
				<h4>Mostrar categoría</h4>
				<p>El evento actualmente está ocultada, está por mostrar: \"$ne\"</p>
			</div>
			<div class='modal-footer'>
				<a onclick=\"$('#mostrar_$id').closeModal(); permutar('$id', 1);\" class='modal-action modal-close btn btn-flat orange'><i class='material-icons right'>visibility</i>Mostar</a>
				<a class='modal-action modal-close btn btn-flat green'><i class='material-icons right'>cancel</i>Cancelar</a>
			</div>
		</div>

		<div id='ocultar_$id' class='modal'>
			<div class='modal-content'>
				<h4>Ocultar categoría</h4>
				<p>El evento actualmente está visible, está por ocultar: \"$ne\"</p>
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