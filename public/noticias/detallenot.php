<?php
//toma el valor de la fecha y hora actual
ini_set("date.timezone","America/El_Salvador");
//enlace del formato de la pagina
require("../page1.php");
//Encabezado de la pagina
function imagen($id){
	$data = Database::getRow("SELECT imagen_pri FROM noticias WHERE id_noticia = ?", array($id));


	if (empty($data))
		return 'http://placehold.it/350x150';
	else
		return 'data:img/*;base64,'.$data[0];
}
function imagen2($id){

		$data = Database::getRow("SELECT imagen_sec FROM noticias WHERE id_noticia = ?", array($id));

	if (empty($data))
		return 'http://placehold.it/350x150';
	else
		return 'data:img/*;base64,'.$data[0];
}

Page::header("Detalle Noticia");
if(empty($_GET['not'])) { //si hay un id va a proceder, de lo contrario te enviara a la pagina de inicio
	$id = null;
	$comentario = null;
}
else { //En esta condicion seleccionamos todos los comentarios de la tabla
	$id = $_GET['id'];
	$sql = "SELECT * FROM noticias WHERE id_noticia = ?";
	$params = array($id);
	$data = Database::getRow($sql, $params);
	$comentario = $data['comentario'];
}

if(!empty($_POST)) {
	if (isset($_POST['eliminarcoment'])) {
        $sql = "DELETE FROM comentarios_noticias WHERE id_comentario_noticia=?";//Y el id del producto? commo se a que producto le hice el cometario
		$params = array($_POST["idcom"]);//porque selecciona? XD no tenes presionado algo?NOXD
		Database::executeRow($sql, $params);
		//header("Location: detallepro.php?pord=$id");
    }else{
    	$_POST = Validator::validateForm($_POST);
		$comentario = $_POST['comentario'];
		$id = $_GET['id'];

		if($comentario == "")
			$comentario = null;
		try
		{
			if($comentario == "")
				throw new Exception("Datos incompletos.");
			else
			{
				$sql = "INSERT INTO comentarios_noticias (comentario,  id_noticia, id_cliente) VALUES(?,?,?)";//Y el id del producto? commo se a que producto le hice el cometario
				$params = array($comentario,$id,$_SESSION['id_cliente']);//porque selecciona? XD no tenes presionado algo?NOXD
				Database::executeRow($sql, $params);
			}
		}
		catch (Exception $error)
		{
			print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
		}
    }
}

//$id = $_GET['id'];
$sql = "SELECT * FROM noticias  WHERE id_noticia = ?";
$params = array($_GET['id']);

$data = Database::getRow($sql, $params);
if($data != null)
{
	$id = $data['id_noticia'];
	$imagen = imagen($data['id_noticia']);
	$imagen2 = imagen2($data['id_noticia']);

	$tabla = "
<div class = 'container'>
	<div class='row'>
		<div class='col s12 m6'>
			<div class='card'>
				<div class = 'card-image'>
					<img src='$imagen'><br>
					<img src='$imagen2'  >                               '><br>


					<div class='card-content black-text'>

					</div>
				</div>
			</div>
		</div>


	<font color='orange'><h4><p> $data[titulo]</p></h4></font>
			<h6><p>$data[informacion_pri]</p></h6>
		</div>
	</div>
		";
		print($tabla);
}
else
	print("<div class='card-panel yellow'><i class='material-icons left'>warning</i>No hay registros.</div>");
?>


	<div class='row'>
		<div>
			<div class='col  m12 s12'>
				<ul class='tabs'>
                    <li class='tab col m3 s12'><a class='blue-text' href='#voted'>Comentarios</a></li>
                    <?php echo Page::iniciado() ? "<li class='tab col m3 s12'><a class='blue-text' href='#posts'>Deja tu comentario</a></li>" : ''; ?>
                    <div class='indicator green' style='z-index:1'></div>
				</ul>
			</div>
			<div id='voted' class='col m12 s12'>
<?php
	$id = $_GET['id'];
	$sql1 = "
SELECT CONCAT(s.nombre_cliente,' ',s.apellido_cliente) as nombre, c.comentario, s.id_cliente, c.id_comentario_noticia FROM comentarios_noticias c,clientes s
where c.id_cliente=s.id_cliente and c.id_noticia= ?";
	$params1 = array($id);
	$data1 = Database::getRows($sql1, $params1);
	$tabla1 = "";
	if ( $data1 != null ){
		foreach($data1 as $row1){
			$tabla1 .= "
			<div class='row' id = 'comentario'>
				<div class='col s12 m4'>
					<i class='material-icons' style='vertical-align:middle;'>account_circle</i>
					<b style='vertical-align:middle;'>$row1[nombre]</b>
				</div>
				<div class='col s11 m7' style='border-left: solid black 1px; border-right: solid black 1px;'>
					<p>$row1[comentario]</p>
					<p>$row1[fecha_comentado]</p>
				</div>
				<div class='col s1 m1' style=''>";
					if ($_SESSION["id_cliente"] == $row1["id_cliente"]) {
						$tabla1 .= "
							<form method='post'>
				                <input type='hidden' name='idcom' value='".$row1["id_comentario_noticia"]."'>
				                <button class='btn waves-effect waves-light red darken-1' type='submit' name='eliminarcoment' value='0'><i class='material-icons'>delete</i></button>
				            </form>";
					}
				$tabla1.= "</div>
			</div>";
		}
	}else
		$tabla1 .= "
	<ul class='collection'>
		<li class='collection-item avatar'>
			<div style = ' margin-right:10px;'>
				<img src='../img/advertencia.png' alt='' >
			</div>
			<div>
				<b><h3>En este momento no hay comentarios disponibles</h3></b>
			</div>

		</li>
	</ul>";
	print($tabla1);
?>
		</div>
        <?php echo Page::iniciado() ? "<div id='posts' class='col s12'>
	        <p>
	            <form method='post' class='row'>
	                <div class='row'>
	                    <div class='input-field col s12 m6'>
	                        <i class='material-icons prefix'>add</i>

	                        <textarea id='comentario' type='text' name='comentario' class='validate' 'materialize-textarea' length='120' style = 'margin:0px 0px 0px 42px; width:920px; height:112px; resize:none;'/></textarea>
	                    </div>
	                </div>
	                <button type='submit' class='btn light-green darken-1'><i class='material-icons right'>send</i>Enviar</button>
	            </form>
	        </p>
	    </div>" : ''; ?>
	</div>
</div>
<?php Page::footer(); ?>