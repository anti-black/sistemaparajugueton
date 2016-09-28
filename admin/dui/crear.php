<?php $N_FORM = 12;
require "../lib/pagina.php";
//Se inician las variables
$errores = $imagen = $cat = '';

//si hay un id declarado en la url
if (isset($_GET['id'])){
	//obtiene los valores que se mostraran
	$cat = pagina::obtenerValor('SELECT categoria FROM categorias WHERE id_categoria = ?;', 0, array($_GET['id']));
	$imagen = pagina::obtenerValor('SELECT img_categoria FROM categorias WHERE id_categoria = ?;', 0, array($_GET['id']));
}

//verifica si esta declarada las variables que se van a insertar en la base
if (isset($_POST['cat']) && isset($_FILES['fileToUpload'])) {
		//verifica si edita o crea
	if (!isset($_GET['id'])) {
		//aqui crea
		$_POST = pagina::validarForm($_POST); //Se validan los datos
		//se obtienen los valores y se guardan en variables
		$cat = $_POST['cat'];
		$archivo = $_FILES['fileToUpload'];
		//errores es una cadena de texto que guarda los errores para mostrarlos despues
		$errores .= !isset($cat) || empty($cat) ? 'El campo de categoría no debe de estar vacío.' : '';
		$errores .= pagina::validarImagen($archivo);
		$sql = "INSERT INTO categorias(categoria, img_categoria) VALUES(?,?);";
		//si los errores tiene una longitud mayor a 0, es decir que tiene errores
		if (!(strlen($errores) > 0)){
			//se convierte a base 64
			$archivo64 = pagina::convertirA64($archivo);
			//se ejecuta la consuta
			if (pagina::ejecutar($sql, array($cat, $archivo64)))
				//una vez inserado se regresa al index
				header('Location: ./');
		}
	}
	else {
		//aqui edita
		$_POST = pagina::validarForm($_POST);
		$cat = $_POST['cat'];
		$archivo = $_FILES['fileToUpload'];
		$errores .= !isset($cat) || empty($cat) ? 'El campo de categoría no debe de estar vacío.' : '';
		$errores .= pagina::validarImagen($archivo);
		$destino = '/imgs/cats/'.uniqid().'.'.pathinfo($archivo[name],PATHINFO_EXTENSION);
		$sql = "UPDATE categorias SET categoria = ?, img_categoria = ? WHERE id_categoria = ?;";
		if (!(strlen($errores) > 0)){
			$archivo64 = pagina::convertirA64($archivo);
			if (pagina::ejecutar($sql, array($cat, $archivo64, $_GET['id'])))
				header('Location: ./');
		}
	}
} else
	$errores .= 'Complete todo';


echo pagina::header('Categorías');
?>
<div class="container">
	<div class="row">
		<div class="col s12 m8 l6">
			<div class="card-panel">
				<h4 class="header2">Crear una nueva categoría</h4>
				<form action"crear.php" method="post" enctype="multipart/form-data" autocomplete="off" onpaste="return false" oncut="return false" oncopy="return false">
					<div class="row">
						<div class="input-field col s12">
							<i class="material-icons prefix">note_add</i>
							<input id="cat" name="cat" type="text" class="validate" length="100" required <?php echo "value='$cat'"; ?>>
							<label for="cat">Categoría</label>
						</div>
					</div>
			      	<div class="file-field input-field col s12">
						<div class="btn">
							<span>Imagen</span>
							<input type="file" name="fileToUpload" id="fileToUpload">
						</div>
						<div class="file-path-wrapper">
							<input class='file-path validate' type='text' placeholder='PNG/JPG'>
						</div>
			    	</div>
					<div class="row">
						<button class="btn green waves-effect waves-light right" type="submit"><?php echo isset($_GET['id']) ? 'Actualizar' : 'Crear' ?>
							<i class="mdi-content-send right"></i>
						</button>
					</div>
				</form>
			</div>
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
echo pagina::footer();
?>