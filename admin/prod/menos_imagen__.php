<?php $N_FORM = 11;
require "../lib/pagina.php";

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$id2 = isset($_GET['ide']) ? $_GET['ide'] : 0;
$errores = '';

if ($id <= 0)
	header("Location: index.php");

if (isset($_GET['c']))
{
	$sql = "DELETE FROM imagenes_productos WHERE id_producto = ? AND id_imagene_producto = ?;";
	if (pagina::ejecutar($sql, array($id, $id2)))
		header("Location: index.php");
	else
		$errores .= 'No se pudo eliminar el producto.';

}

pagina::header('Categorías');
?>
<div class="container">
	<div class="row">
		<div class="col s12 m6 l4 <?php echo strlen($errores) > 0 ? 'offset-m1 offset-l1' : 'offset-m3 offset-l4' ?> card blue-grey darken-1">
			<div class="card-content white-text">
				<span class="card-title">Eliminar</span>
				<p>¿Desea eliminar la imagen?, ésta acción no se puede deshacer.</p>
			</div>
			<div class="card-action">
				<a href="?c=1&id=<?php echo $id ?>" >Sí</a>
				<a href="index.php">No</a>
			</div>
		</div>
<?php echo strlen($errores) > 0 ?
	"
        <div class='card-panel red'>
          <span class='white-text'>Errores</span>
			<p>$errores</p>
        </div>" : '' ;
 ?>
	</div>
</div>
<?php
pagina::footer();
?>