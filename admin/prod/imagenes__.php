<?php $N_FORM = 0;
require "../lib/pagina.php";

$prod = isset($_GET['id']) ? $_GET['id'] : '';

pagina::header('Productos' , true);
?>
<div class="container">
	<center><h3>Productos</h3></center>
	<div class="row">
		<a href='mas_imagen.php?id=<?php echo $prod; ?>'class='btn cyan darken-3 left'><i class='material-icons right'>playlist_add</i>nuevo</a>
		<table class="striped">
			<thead>
				<tr>
					<th>Imagen</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>

<?php
$sql = "SELECT * FROM imagenes_productos WHERE id_producto = ? ;";
$filas = pagina::obtenerFilas($sql, array($prod));
foreach ($filas as $fila) {
	$botones = "<a href='menos_imagen.php?id=$prod&ide=$fila[id_imagene_producto]' class='btn red darken-1'><i class='material-icons'>delete</i></a>";
	$f = "
				<tr>
					<td><div><img class='materialboxed' width='150' src='data:image/*;base64,$fila[imagen]' alt='Imagen de categoría'></div></td>
					<td>$botones</td>
				</tr>";
	echo $f;;
}

?>
				<tr>
					<td></td>
					<td></td>

				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
pagina::footer();
?>