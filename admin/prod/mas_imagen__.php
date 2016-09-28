<?php $N_FORM = 0;
require "../lib/pagina.php";

$id = isset($_GET['id']) ? $_GET['id'] : '';
if (!empty($_FILES)) {
    $archivo = $_FILES['imagenN'];
    $errores = pagina::validarImagen($archivo);
    $imagen = pagina::convertirA64($archivo);

    $valores = array($imagen, $id);

    $sql = "INSERT INTO imagenes_productos(imagen, id_producto) VALUES (?,?);";

    if (pagina::ejecutar($sql, $valores)) {
        header("Location: imagenes.php?id=".$id);
    }
}



pagina::header('Productos' , true);
?>
<div class="container">
	<center><h3>Nueva imagen</h3></center>
	<div class="row">
		<div class="col s12 m4">
			<h4>Imagen nueva</h4>
			<form method="post" enctype="multipart/form-data">
			    <div class="row">
			        <input class="btn green waves-effect waves-light left"  type="file" name="imagenN" id="imagenN">
			    </div>
				<div class="row">
                    <button class="btn green waves-effect waves-light right" type="submit">
                        Subir
                        <i class="mdi-content-send right"></i>
                    </button>
				</div>
			</form>
		</div>
	<?php
echo (strlen($errores) > 0) ? "
		<div class='col s12 m4 l4'>
			<div class='card-panel red'>
				<h4 class='white-text'>Errores</h4>
				<p class='white-text'>$errores</p>
			</div>
		</div>" : '';
?>
	</div>
</div>
<?php
pagina::footer();
?>