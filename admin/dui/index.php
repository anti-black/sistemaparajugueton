<?php $N_FORM = 10;
require "../lib/pagina.php";

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

 echo pagina::header('Categorías');
?>
<div class="container">
	<div class="row">
		<div class="card-panel">
			<div class="row">
				<form method="get" class="col s12" autocomplete="off" onpaste="return false" oncut="return false" oncopy="return false">
					<div class="input-field col s12">
						<input name="busqueda" id="search" type="search" <?php echo "value='$busqueda'" ?> required>
						<label for="search"><i class="material-icons">search</i></label>
						<i class="material-icons">close</i>
					</div>
					<button class="btn green waves-effect waves-light right" type="submit">Buscar
						<i class="mdi-content-send right"></i>
					</button>
				</form>
			</div>
		</div>
	</div>
	<div>
		<table class="striped">
			<thead>
				<tr>
					<th>Imagen</th>
					<th>Nombre</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
<?php
if (strlen($busqueda) > 0){
	$sql = "SELECT * FROM categorias WHERE categoria LIKE ? ;";
	$filas = pagina::obtenerFilas($sql, array('%'.$busqueda.'%'));
} else {
	$sql = "SELECT * FROM categorias;";
	$filas = pagina::obtenerFilas($sql, array());
}
foreach ($filas as $fila) {
	$botones = "<a href='eliminar.php?id=$fila[id_categoria]' class='waves-effect waves-light btn'>Eliminar</a>";
	$botones .= "<a href='crear.php?id=$fila[id_categoria]' class='waves-effect waves-light btn'>Editar</a>";
	$f = "
				<tr>
					<td><div><img class='materialboxed' width='150' src='data:image/*;base64,$fila[img_categoria]' alt='Imagen de categoría'></div></td>
					<td>$fila[categoria]</td>
					<td>$botones</td>
				</tr>";
	echo $f;;
}

?>
				<tr>
					<td></td>
					<td></td>
					<td><a href="crear.php">Nuevo</a></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
echo pagina::footer();
?>