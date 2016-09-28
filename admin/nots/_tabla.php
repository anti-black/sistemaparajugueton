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

//SELECT id_noticia, titulo, subtitulo, informacion_pri, informacion_sec, informacion_ter, imagen_pri, imagen_sec, imagen_ter, fecha, estado FROM noticias
$_POST = pagina::validarForm($_POST);
if(!empty($_POST)) {
	$search = $_POST['buscar'];
	$sql = "SELECT * FROM noticias WHERE titulo LIKE ? OR subtitulo LIKE ? ORDER BY estado DESC, id_noticia ASC;";
	$params = array("%$search%","%$search%");
}
else {
	$sql = "SELECT * FROM noticias ORDER BY estado DESC, id_noticia ASC;";
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
				<th>Título</th>
				<th>Subtítulo</th>
				<th>Fecha</th>
				<th>Estado</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>";
	foreach($data as $row)
	{
		$id = pagina::URLA64(md5($row['id_noticia']));

		$fe = date('j', strtotime($row['fecha'])).' de '.mes(date('F', strtotime($row['fecha']))).', '.date('Y', strtotime($row['fecha']));
		$ti = $row['titulo'];
		$sb = $row['subtitulo'];
		$es = $row['estado'];
		$tabla .= 	"
			<tr>
				<td>$ti</td>
				<td>$sb</td>
				<td>$fe</td>
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
				<p>Esta eliminación es parmanente, Desea eliminar la noticia: \"$ti\"</p>
			</div>
			<div class='modal-footer'>
				<a onclick=\"$('#eliminacion_$id').closeModal(); eliminar('$id');\" class='modal-action modal-close btn btn-flat red'><i class='material-icons right'>delete_forever</i>Eliminar</a>
				<a class='modal-action modal-close btn btn-flat green'><i class='material-icons right'>cancel</i>Cancelar</a>
			</div>
		</div>

		<div id='mostrar_$id' class='modal'>
			<div class='modal-content'>
				<h4>Mostrar categoría</h4>
				<p>La noticia actualmente está ocultada, está por mostrar: \"$ti\"</p>
			</div>
			<div class='modal-footer'>
				<a onclick=\"$('#mostrar_$id').closeModal(); permutar('$id', 1);\" class='modal-action modal-close btn btn-flat orange'><i class='material-icons right'>visibility</i>Mostar</a>
				<a class='modal-action modal-close btn btn-flat green'><i class='material-icons right'>cancel</i>Cancelar</a>
			</div>
		</div>

		<div id='ocultar_$id' class='modal'>
			<div class='modal-content'>
				<h4>Ocultar categoría</h4>
				<p>La noticia actualmente está visible, está por ocultar: \"$ti\"</p>
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