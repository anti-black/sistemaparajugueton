<?php
$data = $_POST['dat'];
$tipo = $_POST['tip'];

$tabla = "
		<table class='responsive-table'>
			<thead>
				<tr>
					<th>Incluir</th>
					<th>Identificador</th>
					<th>Precio normal</th>
					<th>Precio oferta</th>
					<th>Precio afiliado</th>
				</tr>
			</thead>
			<tbody>";
$relleno = '';
if (!empty($data)) {
	$filas = explode(pack("H*" , '0d0a'), $data);

	if ($tipo != 2 && $tipo != 1) $tipo = autoDefinir($filas[0]);

	switch ($tipo) {
		case '1':
			foreach ($filas as $fila) {
				$item = explode(';', $fila);
				$item = array_map('trim', $item);
				$info = array();
				$i = 0;
				$p = false;
				foreach ($item as $valor) {
					$info[$i] = $valor;
					$i++; }
				if(empty($info[0])) break;
				$PN = str_replace(',', '.', $info[1]);
				$PO = str_replace(',', '.', $info[2]);
				$PA = str_replace(',', '.', $info[3]);
				$relleno .= "
						<tr>
							<td><input type='checkbox' id='$info[0]' name='$info[0]' checked='checked'/><label for='$info[0]'>Incluido</label></td>
							<td>$info[0]</td>
							<td><div class='input-field col s12'><input name='pn$info[0]' type='number' step='0.01' min='0.01' max='' class='validate' value='$PN'/></div></td>
							<td><div class='input-field col s12'><input name='po$info[0]' type='number' step='0.01' min='0.01' max='' class='validate' value='$PO'/></div></td>
							<td><div class='input-field col s12'><input name='pa$info[0]' type='number' step='0.01' min='0.01' max='' class='validate' value='$PA'/></div></td>
						</tr>";
			}
			break;
		case '2':
			foreach ($filas as $fila) {
				$item = explode(',', $fila);
				$item = array_map('trim', $item);
				$info = array();
				$i = 0;
				$p = false;
				foreach ($item as $valor) {
					$info[$i] = $valor;
					$i++; }
				if(empty($info[0])) break;
				$ID = $info[0];
				if (!preg_match('/^[0-9]{8,20}$/', $ID)) continue;
				$PN = $info[1];
				$PO = $info[2];
				$PA = $info[3];
				$relleno .= "
						<tr>
							<td><input type='checkbox' id='$ID' name='$ID' checked='checked'/><label for='$ID'>Incluido</label></td>
							<td>$info[0]</td>
							<td><div class='input-field col s12'><input name='pn$ID' type='number' step='0.01' min='0.01' max='' class='validate' value='$PN'/></div></td>
							<td><div class='input-field col s12'><input name='po$ID' type='number' step='0.01' min='0.01' max='' class='validate' value='$PO'/></div></td>
							<td><div class='input-field col s12'><input name='pa$ID' type='number' step='0.01' min='0.01' max='' class='validate' value='$PA'/></div></td>
						</tr>";
			}
			break;
		default: echo '-1'; break;
	}
} else echo '0';

$tabla .= $relleno;
$tabla .= "
			</tbody>
		</table>
		<div class='card-panel blue-grey darken-4 s12'>
			<h6 class='white-text'>4. Enviar resultados para ser actualizados</h6>
			<div class='btn waves-effect waves-light modal-trigger' href='#confirmacion'>
				Enviar<i class='material-icons right'>send</i>
			</div>
		</div>
		<div id='confirmacion' class='modal'>
			<div class='modal-content'>
				<h4>Confirme acción</h4>
				<p>¿Ya leyó los datos interpretados y acepta actualizarlos? Si alguno de los campos no ha sido rellenado no se modificará.<br/><br/>Si está correcto lo mostrado en la tabla de clic en sí, sino de clic en no.</p>
			</div>
			<div class='modal-footer'>
				<button class='modal-action modal-close btn btn-flat waves-effect waves-light' type='submit' name='action'>Sí<i class='material-icons right'>send</i></button>
				<a href='#!' class='modal-action modal-close btn btn-flat waves-effect waves-green'>No</a>
			</div>
		</div>";
echo (mb_strlen($relleno) > 0) ? $tabla : '0';

function autoDefinir($fila){
	$chars = str_split($fila);
	foreach ($chars as $char) {
		if ($char == ';') return 1;
		if ($char == ',') return 2;
	}
	return -1;
}
?>